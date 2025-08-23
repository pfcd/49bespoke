<?php

defined( 'ABSPATH' ) || die();

require_once DNWOO_ESSENTIAL_PATH . '/includes/modules/NextWooGrid/layouts/common/templates.php';

class DNWooGrid extends ET_Builder_Module {

    public $slug = 'dnwoo_grid';
    public $vb_support = 'on';
    public $folder_name; 
    public $icon_path; 
    public $text_shadow; 
    public $margin_padding; 
    public $_additional_fields_options; 
    public $_original_content;
	public $dnwoo_filter_masonry_count;

    protected $module_credits = array(
        'module_uri' => 'https://wooessential.com/divi-woocommerce-product-grid-module/',
        'author' => 'Divi Next',
        'author_uri' => 'https://www.divinext.com',
    );

    public function init()
    {
        $this->name = esc_html__('Woo Product Grid', 'dnwooe');
        $this->folder_name = 'et_pb_woo_essential';
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->main_css_element = '%%order_class%%';
        $this->settings_modal_toggles = WooCommonSettings::carousel_modal_toggles('dnwoo_grid');
        $this->settings_modal_toggles['advanced']['toggles']['image_settings'] = esc_html__('Image Settings', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['grid_settings'] = esc_html__('Grid', 'dnwooe');
	    $this->dnwoo_filter_masonry_count = 1;
        $this->settings_modal_toggles['advanced']['toggles']['product_settings'] = array(
            'title' => esc_html__('Product Text', 'dnwooe'),
            // 'priority'            =>    78,
            'sub_toggles' => array(
                'product_title' => array(
                    'name' => esc_html__('Title', 'dnwooe'),
                ),
                'product_category' => array(
                    'name' => esc_html__('Category', 'dnwooe'),
                ),
            ),
            'tabbed_subtoggles' => true,
        );
        $this->settings_modal_toggles['advanced']['toggles']['product_price'] = array(
            'title' => esc_html__('Product Price', 'dnwooe'),
            'sub_toggles' => array(
                'regular_price' => array(
                    'name' => esc_html__('Regular Price', 'dnwooe'),
                ),
                'new_price' => array(
                    'name' => esc_html__('New Price', 'dnwooe'),
                ),
            ),
            'tabbed_subtoggles' => true,
        );
        $this->settings_modal_toggles['advanced']['toggles']['addtocardbtn'] = array(
            'title' => esc_html__('Add to Cart/Select Option', 'dnwooe'),
            'sub_toggles' => array(
                'button' => array(
                    'name' => esc_html__('Button', 'dnwooe'),
                ),
                'icon' => array(
                    'name' => esc_html__('Icon', 'dnwooe'),
                ),
            ),
            'tabbed_subtoggles' => true,
        );
        $this->settings_modal_toggles['advanced']['toggles']['viewcartbtn'] = array(
            'title' => esc_html__('View Cart', 'dnwooe'),
            'tabbed_subtoggles' => true,
            'sub_toggles' => array(
                'button' => array(
                    'name' => esc_html__('Button', 'dnwooe'),
                ),
                'icon' => array(
                    'name' => esc_html__('Icon', 'dnwooe'),
                ),
            ),
        );
        $this->settings_modal_toggles['advanced']['toggles']['quickviewbtn'] = array(
            'title' => esc_html__('Quick View', 'dnwooe'),
            'tabbed_subtoggles' => true,
            'sub_toggles' => array(
                'button' => array(
                    'name' => esc_html__('Button', 'dnwooe'),
                ),
                'icon' => array(
                    'name' => esc_html__('Icon', 'dnwooe'),
                ),
            ),
        );
        $this->settings_modal_toggles['advanced']['toggles']['quickviewpopupbox'] = array(
            'title' => esc_html__('Quick View Pop Up Box', 'dnwooe'),
            'tabbed_subtoggles' => true,
            'sub_toggles' => array(
                'quickviewpopupbox_title' => array(
                    'name' => esc_html__('Title', 'dnwooe'),
                ),
                'quickviewpopupbox_desc' => array(
                    'name' => esc_html__('Desc', 'dnwooe'),
                ),
                'quickviewpopupbox_price' => array(
                    'name' => esc_html__('Price', 'dnwooe'),
                ),
                'quickviewpopupbox_btn' => array(
                    'name' => esc_html__('Button', 'dnwooe'),
                ),
                'quickviewpopupbox_meta' => array(
                    'name' => esc_html__('Meta', 'dnwooe'),
                ),
            ),
        );
        $this->settings_modal_toggles['advanced']['toggles']['quickbox_popup_box_bg'] = esc_html__('Quick Box Popup Background', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['quickbox_popup_box_arrow'] = esc_html__('Quick Box Popup Arrow', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['quickview_popup_box_close_btn'] = esc_html__('Quick Box Popup Close Button', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['wishlist_settings'] = esc_html__('Wishlist', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['compare_settings'] = esc_html__('Compare', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['sale_badge'] = esc_html__('Sale Badge', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['dnwoo_icon'] = esc_html__('Icon', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['outofstock_badge'] = esc_html__('Out of Stock Badge', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['featured_badge'] = esc_html__('Featured Badge', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['content_bg'] = array(
            'title' => esc_html__('Content Background', 'dnwooe'),
            'priority' => 70,
        );
        $this->settings_modal_toggles['advanced']['toggles']['dnwoo_pagination'] = esc_html__('Pagination', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['dnwoo_topbar'] = esc_html__('Top Bar', 'dnwooe');
        $this->settings_modal_toggles['advanced']['toggles']['dnwoo_rating'] = esc_html__('Rating', 'dnwooe');

        $this->advanced_fields = array(
            'text' => false,
            'fonts' => array(
                'header' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_title a',
                        'text_align' => '%%order_class%% .dnwoo_product_grid_title',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'product_settings',
                    'sub_toggle' => 'product_title',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'font_size' => array(
                        'default' => '17px',
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
                    'header_level' => array(
                        'default' => 'h3',
                    ),
                ),
                'product_cate' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_categories ul li a',
                        'text_align' => '%%order_class%% .dnwoo_product_categories',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'product_settings',
                    'sub_toggle' => 'product_category',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                        'default' => "|||on|||||",
                    ),
                    'font_size' => array(
                        'default' => "12px",
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'new_price' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_price > span:last-child,  %%order_class%% .dnwoo_product_grid_item:not(.product_type_variable) .dnwoo_product_grid_price > span:last-child span, %%order_class%% .dnwoo_product_grid_price ins span,%%order_class%% .dnwoo_product_grid_item:not(.product_type_variable) .dnwoo_product_grid_price ins span',
                        'important' => 'all',
                    ),
                    'hide_text_align' => true,
                    'toggle_slug' => 'product_price',
                    'sub_toggle' => 'new_price',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'regular_price' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_item:not(.product_type_variable) .dnwoo_product_grid_price > span:first-child, %%order_class%% .dnwoo_product_grid_item:not(.product_type_variable) .dnwoo_product_grid_price > span:first-child span, %%order_class%% .dnwoo_product_grid_item:not(.product_type_variable) .dnwoo_product_grid_price del, %%order_class%% .dnwoo_product_grid_item:not(.product_type_variable) .dnwoo_product_grid_price del span,%%order_class%% .dnwoo_product_grid_item.product_type_variable .dnwoo_product_grid_price, %%order_class%% .dnwoo_product_grid_item.product_type_simple .dnwoo_product_grid_price ,%%order_class%% .dnwoo_product_grid_item:not(.product_type_variable) .dnwoo_product_grid_price del ~ span span',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'product_price',
                    'sub_toggle' => 'regular_price',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the price texts', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the price text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'sale_badge' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-onsale',
                        'font' => "%%order_class%% .dnwoo_product_grid_badge .dnwoo-onsale",
                        'color' => "%%order_class%% .dnwoo_product_grid_badge .dnwoo-onsale",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'sale_badge',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'outofstock_badge' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-stockout',
                        'font' => "%%order_class%% .dnwoo_product_grid_badge .dnwoo-stockout",
                        'color' => "%%order_class%% .dnwoo_product_grid_badge .dnwoo-stockout",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'outofstock_badge',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'featured_badge' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-featured',
                        'font' => "%%order_class%% .dnwoo_product_grid_badge .dnwoo-featured",
                        'color' => "%%order_class%% .dnwoo_product_grid_badge .dnwoo-featured",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'featured_badge',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'add_to_card' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_item .dnwoo_product_grid_buttons .add_to_cart_button.dnwoo_cart_text_button,%%order_class%% .dnwoo_product_grid_item .dnwoo_product_grid_buttons .dnwoo_choose_variable_option',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'addtocardbtn',
                    'sub_toggle' => 'button',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'quick_view_btn' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo-quick-btn',
                        'font' => "%%order_class%% .dnwoo-quick-btn",
                        'text_align' => '%%order_class%% .dnwoo-quick-btn',
                        'color' => "%%order_class%% .dnwoo-quick-btn",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'quickviewbtn',
                    'sub_toggle' => 'button',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'quick_view_popup_box_title' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => "%%order_class%% .dnwoo-product-summery .product-title",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'quickviewpopupbox',
                    'sub_toggle' => 'quickviewpopupbox_title',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'quick_view_popup_box_desc' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => "%%order_class%% .dnwoo-product-summery .product-description",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'quickviewpopupbox',
                    'sub_toggle' => 'quickviewpopupbox_desc',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'quick_view_popup_box_price' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo-product-summery .product-price span, %%order_class%% .dnwoo-product-summery .woocommerce-variation.single_variation',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'quickviewpopupbox',
                    'sub_toggle' => 'quickviewpopupbox_price',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'quick_view_popup_box_meta' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo-product-summery .product_meta .posted_in a',
                        'font' => "%%order_class%% .dnwoo-product-summery .product_meta .posted_in a",
                        'text_align' => '%%order_class%% .dnwoo-product-summery .product_meta .posted_in a',
                        'color' => "%%order_class%% .dnwoo-product-summery .product_meta .posted_in a",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'quickviewpopupbox',
                    'sub_toggle' => 'quickviewpopupbox_meta',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'view_cart' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_buttons .added_to_cart',
                        'font' => "%%order_class%% .dnwoo_product_grid_buttons .added_to_cart",
                        'color' => "%%order_class%% .dnwoo_product_grid_buttons .added_to_cart",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'viewcartbtn',
                    'sub_toggle' => 'button',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
                'addtocarticon' => array(
                    'css' => array(
                        'main' => "%%order_class%% .dnwoo_icon_wrapgrid a.icon_cart, %%order_class%% .dnwoo_product_grid_buttons a.icon_cart,%%order_class%% .dnwoo_product_grid_wrapper_layout_seven .dnwoo_product_grid_buttons a.icon_cart span::before,%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid li a.dnwoo_choose_variable_option_icon",
                        'important' => 'all',
                    ),
                    'text_color'       => array(
						'label' => esc_html__( 'Icon Color', 'dnwooe' ),
					),
                    'font_size'        => array(
						'label' => esc_html__( 'Font Size', 'dnwooe' ),
					),
                    'toggle_slug' => 'addtocardbtn',
                    'sub_toggle' => 'icon',
                    'hide_font' => true,
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_text_shadow' => true,
                    'hide_line_height' => true,
                ),
                'viewcarticon' => array(
                    'css' => array(
                        'main' => "%%order_class%% .dnwoo_icon_wrapgrid a.added_to_cart:before",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'viewcartbtn',
                    'sub_toggle' => 'icon',
                    'hide_font' => true,
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_text_shadow' => true,
                    'hide_line_height' => true,
                ),
                'quickviewicon' => array(
                    'css' => array(
                        'main' => "%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-quickview",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'quickviewbtn',
                    'sub_toggle' => 'icon',
                    'hide_font' => true,
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_text_shadow' => true,
                    'hide_line_height' => true,
                ),
                'wishlist' => array(
                    'css' => array(
                        'main' => "%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-wishlist-btn, %%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-action-btn",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'wishlist_settings',
                    'hide_font' => true,
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_text_shadow' => true,
                    'hide_line_height' => true,
                ),
                'compare' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-compare-btn:before',
                        'color' => "%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-compare-btn:before",
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'compare_settings',
                    'hide_font' => true,
                    'hide_text_align' => true,
                    'hide_letter_spacing' => true,
                    'hide_text_shadow' => true,
                    'hide_line_height' => true,
                ),
                'paginavi_text_style' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo-paginav ul li a,%%order_class%% .dnwoo-paginav ul li.active a, %%order_class%% .dnwoo-load-more-pagination',
                    ),
                    'toggle_slug' => 'dnwoo_pagination',
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
                'top_bar' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo-show-product-text p',
                    ),
                    'toggle_slug' => 'dnwoo_topbar',
                ),
            ),
            'background' => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css' => array(
                    'main' => "%%order_class%% .dnwoo_product_grid_item",
                    'important' => true,
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'main' => '%%order_class%% .dnwoo_product_grid_item',
                ),
                'important' => 'all',
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_product_grid_item, %%order_class%% .woocommerce.dnwoo_product_grid_wrapper .dnwoo_product_grid_item',
                            'border_styles' => '%%order_class%% .dnwoo_product_grid_item, %%order_class%% .woocommerce.dnwoo_product_grid_wrapper .dnwoo_product_grid_item',
                        ),
                        'important' => 'all',
                    ),
                ),
                'image_border' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_product_imgwrap img, %%order_class%% .dnwoo_product_grid_img img, %%order_class%% .dnwoo_product_grid_overlay:before, %%order_class%% .dnwoo_product_grid_wrapper_layout_four .dnwoo_product_imgwrap a.dnwoo_product_img::before, %%order_class%% .dnwoo_product_grid_wrapper_layout_six .dnwoo_product_imgwrap a.dnwoo_product_img::before',
                            'border_styles' => '%%order_class%% .dnwoo_product_imgwrap img, %%order_class%% .dnwoo_product_grid_img img, %%order_class%% .dnwoo_product_grid_overlay:before, %%order_class%% .dnwoo_product_grid_wrapper_layout_four .dnwoo_product_imgwrap a.dnwoo_product_img::before',
                        ),
                    ),
                    'label_prefix' => esc_html__('Image', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'image_settings',
                ),
                'text_border' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_product_grid_title',
                            'border_styles' => '%%order_class%% .dnwoo_product_grid_title',
                        ),
                    ),
                    'label_prefix' => esc_html__('Text', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'product_settings',
                    'sub_toggle' => 'product_title',
                ),
                'addtocart' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_product_grid_item .dnwoo_product_grid_buttons .add_to_cart_button.dnwoo_cart_text_button, %%order_class%% .dnwoo_product_grid_item .dnwoo_product_grid_buttons .dnwoo_choose_variable_option',
                            'border_styles' => '%%order_class%% .dnwoo_product_grid_item .dnwoo_product_grid_buttons .add_to_cart_button.dnwoo_cart_text_button, %%order_class%% .dnwoo_product_grid_item .dnwoo_product_grid_buttons .dnwoo_choose_variable_option',
                        ),
                    ),
                    'label_prefix' => esc_html__('Add to Cart', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'addtocardbtn',
                    'sub_toggle' => 'button',
                ),
                'viewcart' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_product_grid_buttons .added_to_cart',
                            'border_styles' => '%%order_class%% .dnwoo_product_grid_buttons .added_to_cart',
                        ),
                    ),
                    'label_prefix' => esc_html__('View Cart', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'viewcartbtn',
                    'sub_toggle' => 'button',
                ),
                'addtocarticon' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid li a.add_to_cart_button.icon_cart, %%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid li a.icon_menu',
                            'border_styles' => '%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid li a.add_to_cart_button.icon_cart, %%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid li a.icon_menu,  %%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid li a.dnwoo_choose_variable_option_icon.icon_menu',
                        ),
                    ),
                    'label_prefix' => esc_html__('Add to Cart Icon', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'addtocardbtn',
                    'sub_toggle' => 'icon',
                ),
                'viewcarticon' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid a.added_to_cart',
                            'border_styles' => '%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid a.added_to_cart',
                        ),
                    ),
                    'label_prefix' => esc_html__('View Cart Icon', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'viewcartbtn',
                    'sub_toggle' => 'icon',
                ),
                'quickviewbtn' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid li a.dnwoo-quick-btn, %%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_product_grid_buttons a.dnwoo-quick-btn',
                            'border_styles' => '%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid li a.dnwoo-quick-btn, %%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_product_grid_buttons a.dnwoo-quick-btn',
                        ),
                    ),
                    'label_prefix' => esc_html__('Quick View', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'quickviewbtn',
                    'sub_toggle' => 'button',
                ),
                'quickviewicon' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid a.dnwoo-quickview.icon_quickview',
                            'border_styles' => '%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid a.dnwoo-quickview.icon_quickview',
                        ),
                    ),
                    'label_prefix' => esc_html__('Quick View Icon', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'quickviewbtn',
                    'sub_toggle' => 'icon',
                ),
                'wishlist' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid a.dnwoo-product-wishlist-btn, %%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid a.dnwoo-product-action-btn',
                            'border_styles' => '%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid a.dnwoo-product-wishlist-btn, %%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid a.dnwoo-product-action-btn',
                        ),
                    ),
                    'label_prefix' => esc_html__('Wishlist Icon', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'wishlist_settings',
                ),
                'compare' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid a.dnwoo-product-compare-btn',
                            'border_styles' => '%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_icon_wrapgrid a.dnwoo-product-compare-btn',
                        ),
                    ),
                    'label_prefix' => esc_html__('Compare Icon', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'compare_settings',
                ),
                'sale_badge' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-onsale',
                            'border_styles' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-onsale',
                        ),
                    ),
                    'label_prefix' => esc_html__('Sale Badge', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'sale_badge',
                ),
                'outofstock_badge' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-stockout',
                            'border_styles' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-stockout',
                        ),
                    ),
                    'label_prefix' => esc_html__('Out of Stock Badge', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'outofstock_badge',
                ),
                'featured_badge' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-featured',
                            'border_styles' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-featured',
                        ),
                    ),
                    'label_prefix' => esc_html__('Featured Badge', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'featured_badge',
                ),
                'pagination' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo-paginav ul li:has(:not(span)), %%order_class%% .dnwoo-load-more-pagination, %%order_class%% .dnwoo-load-more-pagination::before',
                            'border_styles' => '%%order_class%% .dnwoo-paginav ul li:has(:not(span)), %%order_class%% .dnwoo-load-more-pagination, %%order_class%% .dnwoo-load-more-pagination::before',
                        ),
                    ),
                    'label_prefix' => '',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnwoo_pagination',
                ),
                'quickview_popup_arrow' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .product-images .swiper-button-next, %%order_class%% .product-images .swiper-button-prev',
                            'border_styles' => '%%order_class%% .product-images .swiper-button-next, %%order_class%% .product-images .swiper-button-prev',
                        ),
                    ),
                    'label_prefix' => '',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'quickbox_popup_box_arrow',
                ),
                'top_bar' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo-show-product-text',
                            'border_styles' => '%%order_class%% .dnwoo-show-product-text',
                        ),
                    ),
                    'label_prefix' => esc_html__('Top Bar', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnwoo_topbar',
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_item',
                        'important' => 'all',
                    ),
                ),
                'image_box_shadow' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_imgwrap img, %%order_class%% .dnwoo_product_grid_img img',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Image', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'image_settings',
                ),
                'text_box_shadow' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_title',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Text', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'product_settings',
                    'sub_toggle' => 'product_title',
                ),
                'addtocart' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_item .dnwoo_product_grid_buttons .add_to_cart_button.dnwoo_cart_text_button, %%order_class%% .dnwoo_product_grid_item .dnwoo_product_categories.add_to_cart_button.dnwoo_cart_text_button,%%order_class%% .dnwoo_product_grid_item .dnwoo_product_grid_buttons .dnwoo_choose_variable_option, %%order_class%% .dnwoo_product_grid_item .dnwoo_product_categories.dnwoo_choose_variable_option',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Add to Cart', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'addtocardbtn',
                    'sub_toggle' => 'button',
                ),
                'addtocarticon' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_icon_wrapgrid a.add_to_cart_button,%%order_class%% .dnwoo_icon_wrapgrid a.icon_menu',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Add to Cart Icon', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'addtocardbtn',
                    'sub_toggle' => 'icon',
                ),
                'viewcarticon' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_icon_wrapgrid a.added_to_cart',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('View Cart Icon', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'viewcartbtn',
                    'sub_toggle' => 'icon',
                ),
                'viewcart' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_buttons .added_to_cart',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('View Cart', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'viewcartbtn',
                    'sub_toggle' => 'button',
                ),
                'quickviewbtn' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo-quick-btn',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Quick View', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'quickviewbtn',
                    'sub_toggle' => 'button',
                ),
                'quickviewicon' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-quickview',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Quick View Icon', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'quickviewbtn',
                    'sub_toggle' => 'icon',
                ),
                'wishlist' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-wishlist-btn, %%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-action-btn',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Wishlist Icon', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'wishlist_settings',
                ),
                'compare' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-compare-btn',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Compare Icon', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'compare_settings',
                ),
                'sale_badge' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-onsale',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Sale Badge', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'sale_badge',
                ),
                'outofstock_badge' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-stockout',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Out of Stock Badge', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'outofstock_badge',
                ),
                'featured_badge' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-featured',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Featured Badge', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'featured_badge',
                ),
                'top_bar' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo-show-product-text',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Top Bar', 'dnwooe'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnwoo_topbar',
                ),
            ),
            'filters' => array(
                'child_filters_target' => array(
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'image_settings',
                    'label' => esc_html__('Image', 'dnwooe'),
                    'image_grid' => array(
                        'css' => array(
                            'main' => '%%order_class%% a.dnwoo_product_img img',
                        ),
                    ),
                ),
            ),
            'max_width' => array(
                'css' => array(
                    'main' => "%%order_class%%.dnwoo_grid",
                    'module_alignment' => '%%order_class%%.dnwoo_grid.et_pb_module',
                ),
            ),
        );

        $this->custom_css_fields = array(
            'product_image' => array(
                'label' => esc_html__('Product Image', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_imgwrap img',
            ),
            'product_name' => array(
                'label' => esc_html__('Product Name', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_grid_title',
            ),
            'product_price' => array(
                'label' => esc_html__('Product Price', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_grid_price',
            ),
            'sale_badge' => array(
                'label' => esc_html__('Sale Badge', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-onsale',
            ),
            'outofstock_badge' => array(
                'label' => esc_html__('Out of stock Badge', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-stockout',
            ),
            'add_to_cart' => array(
                'label' => esc_html__('Add To Cart', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_grid_buttons .dnwoo_product_addtocart, %%order_class%% .dnwoo_product_grid_buttons .icon_cart',
            ),
            'select_variable_options' => array(
                'label' => esc_html__('Select Variable Product Options Button', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_grid_buttons .dnwoo_choose_variable_option, %%order_class%% .dnwoo_product_grid_buttons .icon_menu_btn',
            ),
            'view_cart' => array(
                'label' => esc_html__('View Cart', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_grid_buttons .added_to_cart',
            ),
            'quickview' => array(
                'label' => esc_html__('Quick View', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_product_grid_buttons .dnwoo-quickview',
            ),
            'add_to_cart_icon' => array(
                'label' => esc_html__('Add To Cart Icon', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid .ajax_add_to_cart',
            ),
            'select_variable_options_icon' => array(
                'label' => esc_html__('Select Variable Product Options Icon', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid .dnwoo_choose_variable_option_icon',
            ),
            'view_cart_icon' => array(
                'label' => esc_html__('View Cart Icon', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid .added_to_cart',
            ),
            'wishlist_icon' => array(
                'label' => esc_html__('Wishlist Icon', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid .dnwoo-product-wishlist-btn',
            ),
            'compare_icon' => array(
                'label' => esc_html__('Compare Icon', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid .dnwoo-product-compare-btn',
            ),
            'quickview_icon' => array(
                'label' => esc_html__('Quick View Icon', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid .dnwoo-quickview',
            ),
            'product_count_top_bar' => array(
                'label' => esc_html__('Product Count Top Bar', 'dnwooe'),
                'selector' => '%%order_class%% .dnwoo-show-product-text',
            ),
        );
    }

    public function get_fields()
    {
        $fields = array(
            'next_woo_carousel_layouts' => array(
                'label' => esc_html__('Select Layout', 'dnwooe'),
                'description' => esc_html__('Choose your posts layout.', 'dnwooe'),
                'type' => 'select',
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'options' => array(
                    'one' => esc_html__('Layout 1', 'dnwooe'),
                    'two' => esc_html__('Layout 2', 'dnwooe'),
                    'three' => esc_html__('Layout 3', 'dnwooe'),
                    'four' => esc_html__('Layout 4', 'dnwooe'),
                    'five' => esc_html__('Layout 5', 'dnwooe'),
                    'six' => esc_html__('Layout 6', 'dnwooe'),
                    'seven' => esc_html__('Layout 7', 'dnwooe'),
                    'eight' => esc_html__('Layout 8', 'dnwooe'),
                ),
                'default' => 'one',
                'default_on_front' => 'one',
                'computed_affects' => array('__nextwooproductgrid'),
            ),
            'type' => array(
                'label' => esc_html__('Product View Type', 'dnwooe'),
                'type' => 'select',
                'option_category' => 'basic_option',
                'options' => array(
                    'default' => esc_html__('Default (Menu ordering + name)', 'dnwooe'),
                    'latest' => esc_html__('Latest Products', 'dnwooe'),
                    'featured' => esc_html__('Featured Products', 'dnwooe'),
                    'sale' => esc_html__('Sale Products', 'dnwooe'),
                    'best_selling' => esc_html__('Best Selling Products', 'dnwooe'),
                    'top_rated' => esc_html__('Top Rated Products', 'dnwooe'),
                    'product_category' => esc_html__('Product Category', 'dnwooe'),
                ),
                'default_on_front' => 'default',
                'description' => esc_html__('Choose which type of product view you would like to display.', 'dnwooe'),
                'toggle_slug' => 'main_content',
                'computed_affects' => array(
                    '__nextwooproductgrid',
                ),
            ),
            'hide_out_of_stock' => array(
                'label' => esc_html__('Hide Out of Stock Products', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => esc_html__('Yes', 'dnwooe'),
                    'off' => esc_html__('No', 'dnwooe'),
                ),
                'default' => 'on',
                'default_on_front' => 'on',
                'toggle_slug' => 'main_content',
                'description' => esc_html__('Hide out of stock products from the loop.', 'dnwooe'),
                'computed_affects' => array(
                    '__nextwooproductgrid',
                ),
            ),
            'dnwoo_badge_outofstock' => array(
                'label' => esc_html__('Out of stock Product Text', 'dnwooe'),
                'type' => 'text',
                'default' => 'Sold',
                'option_category' => 'configuration',
                'description' => esc_html__('Define the Out of stock product text for your badge.', 'dnwooe'),
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'text',
                'show_if' => array(
                    'hide_out_of_stock' => 'off',
                ),
            ),
            'thumbnail_size' => array(
                'label' => esc_html__('Thumbnail Size', 'dnwooe'),
                'description' => esc_html__('Here you can specify the size of category image.', 'dnwooe'),
                'type' => 'select',
                'options' => array(
                    'full' => esc_html__('Full', 'dnwooe'),
                    'woocommerce_thumbnail' => esc_html__('Woocommerce Thumbnail', 'dnwooe'),
                    'woocommerce_single' => esc_html__('Woocommerce Single', 'dnwooe'),
                ),
                'default' => 'woocommerce_thumbnail',
                'default_on_front' => 'woocommerce_thumbnail',
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'computed_affects' => array(
                    '__nextwooproductgrid',
                ),
            ),
            'use_current_page' => array(
                'label' => esc_html__('Use Current Page', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => esc_html__('Yes', 'dnwooe'),
                    'off' => esc_html__('No', 'dnwooe'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'main_content',
                'description' => esc_html__('Use product grid module in category, tag page.', 'dnwooe'),
            ),
            'include_categories' => array(
                'label' => esc_html__('Include Categories', 'dnwooe'),
                'type' => 'categories',
                'renderer_options' => array(
                    'use_terms' => true,
                    'term_name' => 'product_cat',
                    'field_name' => 'et_pb_include_product_cat',
                ),
                'meta_categories' => array(
                    'all' => esc_html__('All Categories', 'dnwooe'),
                    // 'current' => esc_html__('Current Category', 'dnwooe'),
                ),
                'toggle_slug' => 'main_content',
                'description' => esc_html__('Select Categories. If no category is selected, products from all categories will be displayed.', 'dnwooe'),
                'computed_affects' => array(
                    '__nextwooproductgrid',
                ),
                'show_if' => array(
                    'use_current_page' => 'off'
                )
            ),
            'products_number' => array(
                'label' => esc_html__('Product Count', 'dnwooe'),
                'type' => 'text',
                'option_category' => 'configuration',
                'description' => esc_html__('Define the number of products that should be displayed per page.', 'dnwooe'),
                'computed_affects' => array(
                    '__nextwooproductgrid',
                ),
                'toggle_slug' => 'main_content',
                'default' => 10,
            ),
            'offset_number' => array(
                'label' => esc_html__('Offset Number', 'dnwooe'),
                'type' => 'text',
                'option_category' => 'configuration',
                'default' => 0,
                'tab_slug' => 'general',
                'toggle_slug' => 'main_content',
                'description' => esc_html__('Choose how many products you would like to skip. These products will not be shown.', 'dnwooe'),
                'computed_affects' => array(
                    '__nextwooproductgrid',
                ),
            ),
            'order' => array(
                'label' => esc_html__('Sorted By', 'dnwooe'),
                'description' => esc_html__('Choose how your posts should be sorted.', 'dnwooe'),
                'type' => 'select',
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'default' => 'ASC',
                'options' => array(
                    'ASC' => esc_html__('Ascending', 'dnwooe'),
                    'DESC' => esc_html__('Descending', 'dnwooe'),
                ),
                'default_on_front' => 'ASC',
                'computed_affects' => array('__nextwooproductgrid'),
            ),
            'orderby' => array(
                'label' => esc_html__('Order by', 'dnwooe'),
                'type' => 'select',
                'option_category' => 'configuration',
                'options' => array(
                    'date' => esc_html__('Date', 'dnwooe'),
                    'modified' => esc_html__('Modified Date', 'dnwooe'),
                    'title' => esc_html__('Title', 'dnwooe'),
                    'name' => esc_html__('Slug', 'dnwooe'),
                    'ID' => esc_html__('ID', 'dnwooe'),
                    'rand' => esc_html__('Random', 'dnwooe'),
                    'none' => esc_html__('None', 'dnwooe'),
                    'price'      => __( 'Sort by price: low to high', 'dnwooe' ),
                    'price-desc' => __( 'Sort by price: high to low', 'dnwooe' )
                ),
                'default' => 'date',
                'show_if_not' => array(
                    'type' => array(
                        'latest',
                        'best_selling',
                        'top_rated',
                        'featured',
                        'product_category',
                    ),
                ),
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'description' => esc_html__('Here you can specify the order in which the products will be displayed.', 'dnwooe'),
                'computed_affects' => array(
                    '__nextwooproductgrid',
                ),
            ),
            'quickviewpopupbox_arrow_color' => array(
                'label' => esc_html__('Quick View Arrow Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for Quick View Arrow', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'quickbox_popup_box_arrow',
            ),
            'quickviewpopupbox_closebtn_color' => array(
                'label' => esc_html__('Quick View Arrow Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for Quick View close button', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'quickview_popup_box_close_btn',
            ),
        );

        $computed_fields = array(
            '__nextwooproductgrid' => array(
                'type' => 'computed',
                'computed_callback' => array('DNWooGrid', 'get_products'),
                'computed_depends_on' => array(
                    'next_woo_carousel_layouts',
                    'type',
                    'products_number',
                    'offset_number',
                    'order',
                    'include_categories',
                    'orderby',
                    'hide_out_of_stock',
                    'thumbnail_size',
                ),
            ),
        );

        $show_hide = array(
            'show_add_to_cart_icon' => array(
                'label' => esc_html__('Add to cart/Select Options Icon', 'dnwooe'),
                'description' => esc_html__('Choose whether or not the add to cart Icon or Select Options (Only for Variable products) should be visible.', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => esc_html__('Yes', 'dnwooe'),
                    'off' => esc_html__('No', 'dnwooe'),
                ),
                'default' => 'on',
                'tab_slug' => 'general',
                'toggle_slug' => 'display_setting',
            ),
            'show_wish_list_icon' => array(
                'label' => esc_html__('Wish List Icon', 'dnwooe'),
                'description' => esc_html__('Choose whether or not the wish list Icon should be visible.', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => esc_html__('Yes', 'dnwooe'),
                    'off' => esc_html__('No', 'dnwooe'),
                ),
                'default' => 'on',
                'tab_slug' => 'general',
                'toggle_slug' => 'display_setting',
            ),
            'show_add_compare_icon' => array(
                'label' => esc_html__('Add Compare Icon', 'dnwooe'),
                'description' => esc_html__('Choose whether or not the add compare should be visible.', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => esc_html__('Yes', 'dnwooe'),
                    'off' => esc_html__('No', 'dnwooe'),
                ),
                'default' => 'on',
                'tab_slug' => 'general',
                'toggle_slug' => 'display_setting',
            ),
            'show_quickview_icon' => array(
                'label' => esc_html__('Quick View Icon', 'dnwooe'),
                'description' => esc_html__('Choose whether or not the quick view should be visible.', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => esc_html__('Yes', 'dnwooe'),
                    'off' => esc_html__('No', 'dnwooe'),
                ),
                'default' => 'on',
                'tab_slug' => 'general',
                'toggle_slug' => 'display_setting',
            ),
            'show_add_to_cart' => array(
                'label' => esc_html__('Add to cart/Select Options Button', 'dnwooe'),
                'description' => esc_html__('Choose whether or not the add to cart or Select Options (Only for Variable products) button should be visible.', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => esc_html__('Yes', 'dnwooe'),
                    'off' => esc_html__('No', 'dnwooe'),
                ),
                'default' => 'on',
                'tab_slug' => 'general',
                'toggle_slug' => 'display_setting',
                'show_if' => array(
                    'next_woo_carousel_layouts' => array('one', 'two', 'seven', 'eight'),
                ),
            ),
            'dnwoo_show_add_to_cart_text' => array(
                'label' => esc_html__('Add to cart text', 'dnwooe'),
                'type' => 'text',
                'default' => 'Add To Cart',
                'option_category' => 'basic_option',
                'description' => esc_html__('Define the custom add to cart button text for your products.', 'dnwooe'),
                'toggle_slug' => 'display_setting',
                'dynamic_content' => 'text',
                'show_if' => array(
                    'show_add_to_cart' => 'on',
                    'next_woo_carousel_layouts' => array('one', 'two', 'seven', 'eight'),
                ),
            ),
            'dnwoo_select_option_text' => array(
                'label' => esc_html__('Select Options text', 'dnwooe'),
                'description' => esc_html__('Define the custom Select Options text for your variable products.', 'dnwooe'),
                'type' => 'text',
                'default' => 'Select Options',
                'option_category' => 'basic_option',
                'description' => esc_html__('Define the custom Select Options Button text.', 'dnwooe'),
                'toggle_slug' => 'display_setting',
                'dynamic_content' => 'text',
                'show_if' => array(
                    'show_add_to_cart' => 'on',
                    'next_woo_carousel_layouts' => array('one', 'two', 'seven', 'eight'),
                ),
            ),
            'show_quick_view_button' => array(
                'label' => esc_html__('Quick View Button', 'dnwooe'),
                'description' => esc_html__('Choose whether or not the quick view button should be visible.', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => esc_html__('Yes', 'dnwooe'),
                    'off' => esc_html__('No', 'dnwooe'),
                ),
                'default' => 'on',
                'tab_slug' => 'general',
                'toggle_slug' => 'display_setting',
                'show_if' => array(
                    'next_woo_carousel_layouts' => array('one', 'two'),
                ),
            ),
            'dnwoo_quick_view_text' => array(
                'label' => esc_html__('Quick View text', 'dnwooe'),
                'type' => 'text',
                'default' => 'Quick View',
                'option_category' => 'basic_option',
                'description' => esc_html__('Define the quick view text.', 'dnwooe'),
                'toggle_slug' => 'display_setting',
                'dynamic_content' => 'text',
                'show_if' => array(
                    'show_quick_view_button' => 'on',
                    'next_woo_carousel_layouts' => array('one', 'two'),
                ),
            ),
            'show_price_text' => array(
                'label' => esc_html__('Show Price', 'dnwooe'),
                'description' => esc_html__('Choose whether or not the add to cart button should be visible.', 'dnwooe'),
                'type' => 'yes_no_button',
                'options' => array(
                    'on' => esc_html__('Yes', 'dnwooe'),
                    'off' => esc_html__('No', 'dnwooe'),
                ),
                'default' => 'on',
                'option_category' => 'configuration',
                'toggle_slug' => 'display_setting',
            ),
            'show_category' => array(
                'label' => esc_html__('Show Category', 'dnwooe'),
                'description' => esc_html__('Here you can choose whether the category should be added.', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => et_builder_i18n('On'),
                    'off' => et_builder_i18n('Off'),
                ),
                'default' => 'on',
                'default_on_front' => 'on',
                'toggle_slug' => 'display_setting',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'show_sku' => array(
                'label' => esc_html__('Show SKU in the proudct', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => et_builder_i18n('On'),
                    'off' => et_builder_i18n('Off'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'display_setting',
                'description' => esc_html__('Here you can choose whether the SKU will be showed in the proudct.', 'dnwooe'),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'show_rating' => array(
                'label' => esc_html__('Show Star Rating', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => et_builder_i18n('On'),
                    'off' => et_builder_i18n('Off'),
                ),
                'default' => 'on',
                'default_on_front' => 'on',
                'toggle_slug' => 'display_setting',
                'description' => esc_html__('Here you can choose whether the star rating should be added.', 'dnwooe'),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'show_product_topbar' => array(
                'label' => esc_html__('Show Product Count Top Bar', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => et_builder_i18n('On'),
                    'off' => et_builder_i18n('Off'),
                ),
                // 'affects'         => array(
                //     'show_default_sorting',
                // ),
                'default' => 'on',
                'default_on_front' => 'on',
                'toggle_slug' => 'display_setting',
                'description' => esc_html__('Here you can choose whether the product count in a top bar should be added.', 'dnwooe'),
            ),
            'show_default_sorting' => array(
                'label' => esc_html__('Show Default Sorting', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => et_builder_i18n('On'),
                    'off' => et_builder_i18n('Off'),
                ),
                'default' => 'on',
                'default_on_front' => 'on',
                'toggle_slug' => 'display_setting',
                'description' => esc_html__('Here you can choose whether the product count in a top bar should be added.', 'dnwooe'),
                'show_if'   => array(
                    'show_product_topbar' => 'on'
                )
            ),
            'show_featured_product' => array(
                'label' => esc_html__('Featured Product Badge', 'dnwooe'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => array(
                    'on' => et_builder_i18n('On'),
                    'off' => et_builder_i18n('Off'),
                ),
                'default' => 'on',
                'default_on_front' => 'on',
                'toggle_slug' => 'display_setting',
                'description' => esc_html__('Here you can your featured product badge', 'dnwooe'),
            ),
            'dnwoo_badge_featured' => array(
                'label' => esc_html__('Featured Product Badge Text', 'dnwooe'),
                'type' => 'text',
                'default' => 'Hot',
                'option_category' => 'basic_option',
                'description' => esc_html__('Define the featured product text for your badge featured.', 'dnwooe'),
                'toggle_slug' => 'display_setting',
                'dynamic_content' => 'text',
                'show_if' => array(
                    'show_featured_product' => 'on',
                ),
            ),
            'show_badge' => array(
                'label' => esc_html__('Sale Badge Type', 'dnwooe'),
                'type' => 'select',
                'option_category' => 'configuration',
                'options' => array(
                    'none' => esc_html__('None', 'dnwooe'),
                    'sale' => esc_html__('Sale', 'dnwooe'),
                    'percentage' => esc_html__('Percentage', 'dnwooe'),
                ),
                'default' => 'sale',
                'description' => esc_html__('Turn badge on and off.', 'dnwooe'),
                'toggle_slug' => 'display_setting',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'dnwoo_badge_sale' => array(
                'label' => esc_html__('Sale Badge type text', 'dnwooe'),
                'type' => 'text',
                'default' => 'Sale',
                'option_category' => 'basic_option',
                'description' => esc_html__('Define the Badge type text for your product badge.', 'dnwooe'),
                'toggle_slug' => 'display_setting',
                'dynamic_content' => 'text',
                'show_if' => array(
                    'show_badge' => 'sale',
                ),
            ),
            'dnwoo_badge_percentage' => array(
                'label' => esc_html__('Percentage Badge type text', 'dnwooe'),
                'type' => 'text',
                'default' => 'off',
                'option_category' => 'basic_option',
                'description' => esc_html__('Define the Badge type text for your product badge.', 'dnwooe'),
                'toggle_slug' => 'display_setting',
                'dynamic_content' => 'text',
                'show_if' => array(
                    'show_badge' => 'percentage',
                ),
            ),
        );

        $pagination = array(
            'show_pagination' => array(
                'label' => esc_html__('Pagination Type', 'dnwooe'),
                'type' => 'select',
                'option_category' => 'configuration',
                'options' => array(
                    'none' => esc_html__('None', 'dnwooe'),
                    'numbers' => esc_html__('Numbers', 'dnwooe'),
                    'loadmore' => esc_html__('Load More', 'dnwooe'),
                ),
                'default' => 'off',
                'description' => esc_html__('Turn pagination on and off.', 'dnwooe'),
                'toggle_slug' => 'display_setting',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'next_text' => array(
                'label' => esc_html__('Next Text', 'dnwooe'),
                'description' => esc_html__('Here you can define Next Link text in numbered pagination.', 'dnwooe'),
                'type' => 'text',
                'option_category' => 'configuration',
                'toggle_slug' => 'display_setting',
                'show_if' => array(
                    'show_pagination' => 'numbers',
                ),
            ),
            'prev_text' => array(
                'label' => esc_html__('Prev Text', 'dnwooe'),
                'description' => esc_html__('Here you can define Previous Link text in numbered pagination.', 'dnwooe'),
                'type' => 'text',
                'option_category' => 'configuration',
                'toggle_slug' => 'display_setting',
                'show_if' => array(
                    'show_pagination' => 'numbers',
                ),
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
                'toggle_slug' => 'dnwoo_pagination',
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
                'toggle_slug' => 'dnwoo_pagination',
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
                'toggle_slug' => 'dnwoo_pagination',
                'hover' => 'tabs',
                'show_if' => array(
                    'show_pagination' => 'numbers',
                ),
            ),
            'pagination_active_text_color' => array(
                'label' => esc_html__('Active Text Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for pagination active page number color', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnwoo_pagination',
                'hover' => 'tabs',
                'show_if' => array(
                    'show_pagination' => 'numbers',
                ),
            ),
            'pagination_active_border_color' => array(
                'label' => esc_html__('Active Border Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for pagination active border color', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnwoo_pagination',
                'show_if' => array(
                    'show_pagination' => 'numbers',
                ),
            ),
        );

        $grid = array(
            'dnwoo_grid_carousel_number' => array(
                'label' => esc_html__('Grid Number', 'dnwooe'),
                'description' => esc_html__('Choose in how many grids you want to show your posts.', 'dnwooe'),
                'type' => 'range',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'grid_settings',
                'fixed_unit' => false,
                'unitless' => true,
                'default' => 3,
                'range_settings' => array(
                    'min' => 1,
                    'step' => 1,
                    'max' => 10,
                ),
                'mobile_options' => true,
                'responsive' => true,
            ),
            'dnwoo_grid_carousel_gap' => array(
                'label' => esc_html__('Grid Gap', 'dnwooe'),
                'description' => esc_html__('Choose the grid-gap.', 'dnwooe'),
                'type' => 'range',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'grid_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default_unit' => 'px',
                'default' => '30px',
                'default_on_front' => '30px',
                'range_settings' => array(
                    'min' => 0,
                    'step' => 1,
                    'max' => 1000,
                ),
                'mobile_options' => true,
                'responsive' => true,
            ),
        );

        $rating_allowed_layouts = array('two', 'three', 'four', 'five', 'eight');
        $rating = array(
            'rating_alignment' => array(
                'label' => esc_html__('Alignment', 'dnwooe'),
                'description' => esc_html__('Align to the left, right or center.', 'dnwooe'),
                'type' => 'align',
                'option_category' => 'layout',
                'options' => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnwoo_rating',
                'default' => 'left',
                'mobile_options' => true,
                'responsive' => true,
                'show_if' => array(
                    'show_rating' => 'on',
                    'next_woo_carousel_layouts' => $rating_allowed_layouts,
                ),
            ),
            'rating_active_color' => array(
                'label' => esc_html__('Active Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for active rating star', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnwoo_rating',
                'show_if' => array(
                    'show_rating' => 'on',
                ),
            ),
            'rating_inactive_color' => array(
                'label' => esc_html__('Inactive Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for nonactive rating star', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnwoo_rating',
                'show_if' => array(
                    'show_rating' => 'on',
                ),
            ),
        );

        $margin_padding = array(
            'dnwoo_product_grid_image_margin' => array(
                'label' => esc_html__('Image Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_image_padding' => array(
                'label' => esc_html__('Image Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_product_name_margin' => array(
                'label' => esc_html__('Product Name Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_product_name_padding' => array(
                'label' => esc_html__('Product Name Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_cate_margin' => array(
                'label' => esc_html__('Product Category Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_cate_padding' => array(
                'label' => esc_html__('Product Category Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_price_margin' => array(
                'label' => esc_html__('Product Price Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_price_padding' => array(
                'label' => esc_html__('Product Price Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_addtocart_margin' => array(
                'label' => esc_html__('Add To Cart Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_addtocart_padding' => array(
                'label' => esc_html__('Add To Cart Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_viewcart_margin' => array(
                'label' => esc_html__('View Cart Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_viewcart_padding' => array(
                'label' => esc_html__('View Cart Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_quickview_margin' => array(
                'label' => esc_html__('Quick View Margin', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_quickview_padding' => array(
                'label' => esc_html__('Quick View Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_onsale_margin' => array(
                'label' => esc_html__('Sale Badge Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_onsale_padding' => array(
                'label' => esc_html__('Sale Badge Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_outofstock_margin' => array(
                'label' => esc_html__('Stock of Out Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_outofstock_padding' => array(
                'label' => esc_html__('Stock of Out Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_featured_margin' => array(
                'label' => esc_html__('Featured Badge Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_featured_padding' => array(
                'label' => esc_html__('Featured Badge Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_product_grid_pagination_margin' => array(
                'label' => esc_html__('Pagination Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'default' => '0|10px|0|0',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'show_if' => array(
                    'show_pagination' => 'numbers',
                ),
            ),
            'dnwoo_product_grid_pagination_space_padding' => array(
                'label' => esc_html__('Pagination Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'show_if' => array(
                    'show_pagination' => 'numbers',
                ),
            ),
            'dnwoo_product_grid_pagi_loadmore_margin' => array(
                'label' => esc_html__('Load More Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'default' => '20px|0|0|0',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'show_if' => array(
                    'show_pagination' => 'loadmore',
                ),
            ),
            'dnwoo_product_grid_pagi_loadmore_space_padding' => array(
                'label' => esc_html__('Load More Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'show_if' => array(
                    'show_pagination' => 'loadmore',
                ),
            ),
            'dnwoo_addtocarticonmar_margin' => array(
                'label' => esc_html__('Add to cart Icon Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_addtorcarticonpad_padding' => array(
                'label' => esc_html__('Add to cart Icon Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_wishlisticonmar_margin' => array(
                'label' => esc_html__('Wish List Icon Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_wishlisticonpad_padding' => array(
                'label' => esc_html__('Wish List Icon Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_addcompareiconmar_margin' => array(
                'label' => esc_html__('Add Compare Icon Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_addcompareiconpad_padding' => array(
                'label' => esc_html__('Add Compare Icon Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_addquickviewiconmar_margin' => array(
                'label' => esc_html__('Quick View Icon Margin', 'dnwooe'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnwoo_addquickviewiconpad_padding' => array(
                'label' => esc_html__('Quick View Icon Padding', 'dnwooe'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
        );

        $top_bar = array(
            'topbar_width' => array(
                'label' => esc_html__('Bar Width', 'dnwooe'),
                'description' => esc_html__('Adjust the width of the Top Bar.', 'dnwooe'),
                'type' => 'range',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnwoo_topbar',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '100%',
                'default_unit' => '%',
                'range_settings' => array(
                    'min' => 0,
                    'step' => 1,
                    'max' => 100,
                ),
            ),
        );

        $background_opt = array(
            'hover' => 'tabs',
            'description' => esc_html__('Add a background fill color or gradient for the description text', 'dnwooe'),
        );
        $desc_opt = array(
            'hover' => 'tabs',
            'description' => esc_html__('Add a background fill color or gradient for the description text', 'dnwooe'),
        );
        $deps = array(
            'description' => esc_html__('Add a background fill color or gradient for the description text', 'et-builder'),
            'show_if' => array(
                'next_woo_carousel_layouts' => array('three', 'four', 'five', 'six', 'seven', 'eight'),
            ),
        );

        $sale_badge_bg = DNWoo_Common::background_fields($this, "sale_badge_", "Background Color", "sale_badge", "advanced", $background_opt);
        $outofstock_badge_bg = DNWoo_Common::background_fields($this, "outofstock_badge_", "Background", "outofstock_badge", "advanced", $desc_opt);
        $featured_badge_bg = DNWoo_Common::background_fields($this, "featured_badge_", "Background", "featured_badge", "advanced", $desc_opt);
        $addtocart_bg_color = DNWoo_Common::background_fields($this, "addtocard_", "Background Color", "addtocardbtn", "advanced", array_merge($desc_opt, array('sub_toggle' => 'button')));
        $viewcart_bg_color = DNWoo_Common::background_fields($this, "viewcart_", "Background Color", "viewcartbtn", "advanced", array_merge($desc_opt, array('sub_toggle' => 'button')));
        $quickview_bg_color = DNWoo_Common::background_fields($this, "quickview_", "Background Color", "quickviewbtn", "advanced", array_merge($desc_opt, array('sub_toggle' => 'button')));
        $content_bg_color = DNWoo_Common::background_fields($this, "content_", "Background Color", "content_bg", "general", $deps);

        $addtocarticon_bg = DNWoo_Common::background_fields($this, "addtocarticonbg_", "Add to Cart Icon Background", "addtocardbtn", "advanced", array_merge($desc_opt, array('sub_toggle' => 'icon')));
        $viewcarticon_bg = DNWoo_Common::background_fields($this, "viewcarticonbg_", "View Cart Icon Background", "viewcartbtn", "advanced", array_merge($desc_opt, array('sub_toggle' => 'icon')));
        $wishlisticon_bg = DNWoo_Common::background_fields($this, "wishlisticonbg_", "Wish List Icon Background", "wishlist_settings", "advanced", $desc_opt);
        $addcompareicon_bg = DNWoo_Common::background_fields($this, "addcompareiconbg_", "Add Comapare Background", "compare_settings", "advanced", $desc_opt);
        $quickviewicon_bg = DNWoo_Common::background_fields($this, "quickviewiconbg_", "Quick View Background", "quickviewbtn", "advanced", array_merge($desc_opt, array('sub_toggle' => 'icon')));
        $quickviewpopupbtn_bg = DNWoo_Common::background_fields($this, "quickviewbtn_", "Add to cart btn Background", "quickviewpopupbox", "advanced", array_merge($desc_opt, array('sub_toggle' => 'quickviewpopupbox_btn')));
        $quickviewpopup_view_btn_bg = DNWoo_Common::background_fields($this, "quickview_view_btn_", "View cart btn Background", "quickviewpopupbox", "advanced", array_merge($desc_opt, array('sub_toggle' => 'quickviewpopupbox_btn')));
        $quickviewpopup_bg = DNWoo_Common::background_fields($this, "quickviewpopupbg_", "Quick View Pop up Box Background", "quickbox_popup_box_bg", "advanced", $desc_opt);
        $quickviewpopuparrow = DNWoo_Common::background_fields($this, "quickviewpopuparrow_", "Quick View Pop up Box Arrow", "quickbox_popup_box_arrow", "advanced", $desc_opt);
        $quickviewpopup_close_btn    = DNWoo_Common::background_fields($this, "quickviewpopup_close_btn_", "Quick View Pop up Box close button", "quickview_popup_box_close_btn", "advanced", $desc_opt);
        
        $image_overlay_bg = DNWoo_Common::background_fields($this, "image_overlay_", "Image Overlay Background", "image_settings", "advanced", array(
            'description' => esc_html__('Add a background fill color or gradient for the description text', 'dnwooe'),
            'show_if' => array(
                'next_woo_carousel_layouts' => array('four', 'six'),
            ),
        ));
        $topbar_bg = DNWoo_Common::background_fields($this, "topbar_", "Top Bar Background", "dnwoo_topbar", "advanced", array(
            'description' => esc_html__('Add a background fill color or gradient for the pagination topbar. The Bar will appear, if the pagination is turned on.', 'dnwooe'),
        ));

        return array_merge(
            $fields,
            $show_hide,
            $grid,
            $sale_badge_bg,
            $rating,
            $outofstock_badge_bg,
            $featured_badge_bg,
            $addtocart_bg_color,
            $viewcart_bg_color,
            $quickview_bg_color,
            $content_bg_color,
            $margin_padding,
            $pagination,
            $top_bar,
            $computed_fields,
            $addtocarticon_bg,
            $viewcarticon_bg,
            $wishlisticon_bg,
            $addcompareicon_bg,
            $quickviewicon_bg,
            $image_overlay_bg,
            $quickviewpopupbtn_bg,
            $quickviewpopup_view_btn_bg,
            $quickviewpopup_bg,
            $quickviewpopuparrow,
            $topbar_bg,
            $quickviewpopup_close_btn
        );
    }

    public static function get_products()
    {
        return '';
    }

    public function callingPaginationScripts()
    {
        // wp_enqueue_style('dnwoo_pagination');
        wp_enqueue_script('dnwoo-pagination');
        wp_enqueue_script('dnwoo-pagination-activation');
    }

    public function callingScriptAndStyles()
    {
        wp_enqueue_style('dnwoo_quickview_modal');
        wp_enqueue_style('dnwoo_product_grid');
        wp_script_is('dnext_isotope', 'enqueued') ? wp_enqueue_script('dnext_isotope') : wp_enqueue_script('dnwoo_swiper_frontend');
        wp_script_is('magnific-popup', 'enqueued') ? wp_enqueue_script('magnific-popup') : wp_enqueue_script('dnwoo-magnific-popup');
        wp_enqueue_script('dnwoo_scripts-public');
        wp_style_is('dnext_swiper-min', 'enqueued') ? wp_enqueue_style('dnext_swiper-min') : wp_enqueue_style('dnwoo_swiper-min');
        wp_enqueue_style('dnwoo_magnific-popup');
    }

    public function get_filter_html($filter_module_count) {
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
	    $orderby = isset( $_GET['orderby'.$filter_module_count] ) ? wc_clean( wp_unslash( sanitize_text_field($_GET['orderby'.$filter_module_count]) ) ) : $default_orderby;
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
         $filter = '';
         ob_start();
         ?>
	    <form class="woocommerce-ordering" method="get">
		    <select name="orderby<?php echo esc_attr($filter_module_count);?>" class="dnwoo-orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
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

    public function render($attrs, $content, $render_slug)
    {
        if (!class_exists('WooCommerce')) {
            DNWoo_Common::show_wc_missing_alert();
            return;
        }
        // echo '<pre>';
        // var_dump($this->main_css_element);
        // die();
        $this->callingScriptAndStyles();
        $order_class = $this->get_module_order_class($render_slug);

        $multi_view = et_pb_multi_view_options($this);

        $layout = $this->props['next_woo_carousel_layouts'];
        $products_number = $this->props['products_number'];
        $offset_number = $this->props['offset_number'];
        $order = $this->props['order'];
        $orderby = $this->props['orderby'];
        $type = $this->props['type'];
        $include_categories = $this->props['include_categories'];
        $use_current_page = $this->props['use_current_page'];
        $hide_out_of_stock = $this->props['hide_out_of_stock'];
        $dnwoo_badge_outofstock = $this->props['dnwoo_badge_outofstock'];
        $thumbnail_size = $this->props['thumbnail_size'];
        $show_rating        = $this->props['show_rating'];
        $show_sku           = $this->props['show_sku'];
        $show_price_text = $this->props['show_price_text'];
        $show_category = $this->props['show_category'];
        $show_add_to_cart = $this->props['show_add_to_cart'];
        $dnwoo_show_add_to_cart_text = $this->props['dnwoo_show_add_to_cart_text'];
        $dnwoo_select_option_text = $this->props['dnwoo_select_option_text'];
        $show_add_to_cart_icon = $this->props['show_add_to_cart_icon'];
        $show_wish_list_icon = $this->props['show_wish_list_icon'];
        $show_add_compare_icon = $this->props['show_add_compare_icon'];
        $show_quickview_icon = $this->props['show_quickview_icon'];
        $show_quick_view_button = $this->props['show_quick_view_button'];
        $dnwoo_quick_view_text = $this->props['dnwoo_quick_view_text'];
        $show_pagination = $this->props['show_pagination'];
        $next_text = $this->props['next_text'];
        $prev_text = $this->props['prev_text'];
        $loadmore_text = $this->props['loadmore_text'];
        $show_featured_product = $this->props['show_featured_product'];
        $featured_text = $this->props['dnwoo_badge_featured'];
        $show_badge = $this->props['show_badge'];
        $dnwoo_badge_sale_text = $this->props['dnwoo_badge_sale'];
        $dnwoo_badge_percentage_text = $this->props['dnwoo_badge_percentage'];
        $header_level = $this->props['header_level'];

        $pagination_alignment = DNWoo_Common::get_alignment("pagination_alignment", $this, "dnwoo");

        $product_tag_arr = is_product_tag() ? array(get_queried_object()->slug) : array();
        $search = isset( $_GET['s'] ) && !empty(  wp_verify_nonce( sanitize_text_field($_GET['s']), 'dnwoo_carousel' )  ) ?  wp_verify_nonce( sanitize_text_field($_GET['s']), 'dnwoo_carousel' )  : '';
        
        $paged = get_query_var("paged") ? get_query_var("paged") : 1;

	    $filter_module_count = $this->dnwoo_filter_masonry_count++;

	    $meta_key = ( !empty($_GET['orderby'.$filter_module_count]) ) ? sanitize_text_field($_GET['orderby'.$filter_module_count]) : $orderby;

        
       if( 'price' == $meta_key ) {
            $orderby    = 'meta_value_num';
            $meta_key   = '_price';
            $order = 'ASC';
        }else if( 'price-desc' == $meta_key) {
            $orderby    = 'meta_value_num';
            $meta_key   = '_price';
            $order = 'DESC';
        }else if( 'date' == $meta_key) {
            $orderby = 'date';
            $order = 'DESC';
        }else if( 'rating' == $meta_key) {
            $orderby = array(
                'meta_value_num' => 'DESC',
                'ID' => 'ASC'
            );
            $meta_key = '_wc_average_rating';
        }else if( 'popularity' == $meta_key) {
            $orderby = 'total_sales';
            $order = 'DESC';
        }
        


        $settings = array(
            'products_number' => intval($products_number),
            'product_tag' => $product_tag_arr,
            'offset' => $offset_number,
            'order' => $order,
            'orderby' => $orderby,
            'meta_key' => $meta_key, // phpcs:ignore
            'type' => $type,
            'current_categories' => (is_product_category() && 'on' === $use_current_page) ? (string) get_queried_object_id() : '',
            'current_tags' => (is_product_tag() && 'on' === $use_current_page) ? (string) get_queried_object_id() : '',
            'include_categories' => $include_categories,
            'hide_out_of_stock' => $hide_out_of_stock,
            'thumbnail_size' => $thumbnail_size,
            'request_from' => 'frontend',
            'paged' => $paged,
            'show_pagination' => $show_pagination,
            'search' => $search,
            'meta_query' => [], // phpcs:ignore
            'tax_query' => [], // phpcs:ignore
        );

        

        if ( 'product_category' === $type || $use_current_page ) {
            $settings = $this->filter_products_query($settings);
            add_action( 'pre_get_posts', array( $this, 'apply_woo_widget_filters' ), 10 );
        }

        if ( 'product_category' === $type || $use_current_page ) {
			remove_action( 'pre_get_posts', array( $this, 'apply_woo_widget_filters' ), 10 );
			remove_filter( 'woocommerce_shortcode_products_query', array( $this, 'filter_products_query' ) );
		}
        
        // lol start
        
        // lol end

        $products = dnwoo_query_products($settings);

        
        if ('' !== $offset_number && !empty($offset_number)) {
            $total = ceil(((int) $products->found_posts - (int) $offset_number) / (int) $products_number);
            
        } else {
            $total = ceil((int) $products->found_posts / (int) $products_number);
        }
        
        $total_product = $products->found_posts;
        
        $total_product_offset_number = $products->found_posts - $offset_number;
        

        $show_product = "";
        $total_product = '' !== $offset_number && !empty($offset_number) ? $total_product_offset_number : $total_product;
        
        $first = ($products_number * $paged) - $products_number + 1;
        $last = min($total_product, $products_number * $paged);

        $filter = (isset( $this->props['show_default_sorting'] ) && 'on' == $this->props['show_default_sorting'])  ? $this->get_filter_html($filter_module_count) : '';


        $show_product = 'on' === $this->props['show_product_topbar'] ? sprintf( _nx('<div class="dnwoo-show-product-text"><p class="woocommerce-result-count">Showing %1$d&ndash;%2$d of %3$d result</p></div>', '<div class="dnwoo-show-product-text"><p class="woocommerce-result-count">Showing %1$d&ndash;%2$d of %3$d results</p>%4$s</div>', $total_product, 'with first and last result', 'dnwooe'), $first, $last, $total_product, $filter) : '';

        $order_class = $this->get_module_order_class($render_slug);


        $single_products = '';
        if ($products->have_posts()) {
            $counter = 1;
            while ($products->have_posts()) {
                $products->the_post();
                $product_id = get_the_ID();
                $product = wc_get_product($product_id);
                $product_type = esc_attr($product->get_type());
                $sku = 'on' === $show_sku ? 'SKU: '. $product->get_sku() : '';
                $single_products .= '<li class="product dnwoo_product_grid_item product_type_' . $product_type . '">';
                
                if (file_exists(get_stylesheet_directory() . 'layouts/layout-' . $layout . '.php')) {
                    include get_stylesheet_directory() . 'layouts/layout-' . $layout . '.php';
                } elseif (file_exists(plugin_dir_path(__FILE__) . 'layouts/layout-' . $layout . '.php')) {
                    include plugin_dir_path(__FILE__) . 'layouts/layout-' . $layout . '.php';
                }

                $single_products .= '</li> <!-- Grid Item -->';
                
                $counter++;
            }
            wp_reset_postdata();
        }

        $load_more_arr = array(
            'carousel-layouts' => $layout,
            'products-number' => $products_number,
            'offset-number' => $offset_number,
            'order' => $order,
            'orderby' => $orderby,
            'type' => $type,
            'include-categories' => $include_categories,
            'out-of-stock' => $hide_out_of_stock,
            'thumbnail-size' => $thumbnail_size,
            'show-rating' => $show_rating,
            'show-sku' => $show_sku ,
            'show-price-text' => $show_price_text,
            'show-category' => $show_category,
            'show-add-to-cart' => $show_add_to_cart,
            'show-quick-view' => $show_quick_view_button,
            'orderclass' => $order_class,
            'addtocarticon' => $show_add_to_cart_icon,
            'wishlisticon' => $show_wish_list_icon,
            'addcompare' => $show_add_compare_icon,
            'quickviewicon' => $show_quickview_icon,
            'show-featured' => $show_featured_product,
            'outofstock-text' => $dnwoo_badge_outofstock,
            'featured-text' => $featured_text,
            'show-badge' => $show_badge,
            'sale-text' => $dnwoo_badge_sale_text,
            'percentage-text' => $dnwoo_badge_percentage_text,
            'addtocart-text' => $dnwoo_show_add_to_cart_text,
            'select-option-text' => $dnwoo_select_option_text,
            'quickview-text' => $dnwoo_quick_view_text,
            'header-level' => $header_level,
            'total' => 'numbers' == $show_pagination ? $total_product : $total,
            'prev-text' => esc_html__($prev_text, 'dnwooe'),
            'next-text' => esc_html__($next_text, 'dnwooe'),
            'pagination-alignment' => $pagination_alignment,
            'current_categories' => (is_product_category() && 'on' == $use_current_page) ? (string) get_queried_object_id() : '',
            'current_tags' => (is_product_tag() && 'on' == $use_current_page) ? (string) get_queried_object_id() : '',
        );

        $load_more_arr = sprintf('data-values=\'%1$s\'', wp_json_encode( $load_more_arr ));

        $pagination = '';
        if ("loadmore" === $show_pagination) {
            $pagination = sprintf(
                '<div class="dnwoo_load_more_btn_wrap %3$s">
                    <a href="#" class="dnwoo-load-more-pagination" %2$s>
                        %1$s
                    </a>
                </div>',
                esc_html__($loadmore_text, 'dnwooe'),
                $load_more_arr,
                $pagination_alignment
            );
        } elseif ("numbers" === $show_pagination) {
            $this->callingPaginationScripts();
            $pagination = sprintf('<div class="dnwoo-paginav %2$s"><nav class="dnwoo-woocommerce-pagination"><ul id="dnwoo-paginate-page" class="page-numbers" %1$s></ul></nav></div>', $load_more_arr, $pagination_alignment);
        }
        $this->apply_css($render_slug);
        $this->apply_background_css($render_slug);

        
        // $filter = '';
        return sprintf(
            '<div class="dnwoo_product_main_wrapper" id="dnwoo_product_grid">
                <div>
                    %4$s
                    <ul class="products dnwoo_product_grid_wrapper dnwoo_product_grid_wrapper_layout_%2$s woocommerce">
                        %1$s
                    </ul>
                    %3$s
                </div>
            </div>
            ',
            $single_products,
            $layout,
            $pagination,
            $show_product
        );
    }

    public function apply_css($render_slug)
    {

        $css_settings = array(
            // Option slug should be the key
            'dnwoo_grid_carousel_number' => array(
                'css' => 'grid-template-columns: repeat(%1$s, 1fr) !important;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_product_grid_wrapper_layout_one, %%order_class%% .dnwoo_product_grid_wrapper_layout_two, %%order_class%% .dnwoo_product_grid_wrapper_layout_three, %%order_class%% .dnwoo_product_grid_wrapper_layout_four, %%order_class%% .dnwoo_product_grid_wrapper_layout_five, %%order_class%% .dnwoo_product_grid_wrapper_layout_six, %%order_class%% .dnwoo_product_grid_wrapper_layout_seven, %%order_class%% .dnwoo_product_grid_wrapper_layout_eight",
                ),
            ),
            'dnwoo_grid_carousel_gap' => array(
                'css' => 'grid-gap: %1$s !important;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_product_grid_wrapper_layout_one, %%order_class%% .dnwoo_product_grid_wrapper_layout_two, %%order_class%% .dnwoo_product_grid_wrapper_layout_three, %%order_class%% .dnwoo_product_grid_wrapper_layout_four, %%order_class%% .dnwoo_product_grid_wrapper_layout_five, %%order_class%% .dnwoo_product_grid_wrapper_layout_six, %%order_class%% .dnwoo_product_grid_wrapper_layout_seven, %%order_class%% .dnwoo_product_grid_wrapper_layout_eight",
                ),
            ),
            'rating_alignment' => array(
                'css' => 'justify-content: %1$s !important;',
                'selector' => array(
                    'desktop' => "%%order_class%% .dnwoo_product_ratting",
                ),
            ),
            'rating_active_color' => array(
                'css' => 'color: %1$s !important;',
                'selector' => array(
                    'desktop' => "%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_product_ratting span:before,%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_product_ratting span:before",
                ),
            ),
            'rating_inactive_color' => array(
                'css' => 'color: %1$s !important;',
                'selector' => array(
                    'desktop' => "%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_product_ratting .star-rating:before,%%order_class%% .woocommerce .dnwoo_product_grid_item .dnwoo_product_ratting .star-rating:before,%%order_class%% .dnwoo_product_grid_item .dnwoo_product_content .dnwoo_product_ratting .star-rating span:before,%%order_class%% .dnwoo_product_grid_item .dnwoo_product_content .dnwoo_product_ratting .star-rating span:before",
                ),
            ),
            'pagination_bg_color' => array(
                'css' => 'background: %1$s !important;',
                'selector' => array(
                    'desktop' => '%%order_class%% .dnwoo-paginav ul li:not(.active):has(:not(span)),%%order_class%% .dnwoo-load-more-pagination',
                    'hover' => '%%order_class%% .dnwoo-paginav ul li:not(.active):has(:not(span)):hover,%%order_class%% .dnwoo-load-more-pagination::before',
                ),
            ),
            'pagination_active_bg_color' => array(
                'css' => 'background: %1$s !important;',
                'selector' => array(
                    'desktop' => '%%order_class%% .dnwoo-paginav ul li.active,%%order_class%% .dnwoo-load-more-pagination',
                    'hover' => '%%order_class%% .dnwoo-paginav ul li.active:hover,%%order_class%% .dnwoo-load-more-pagination:hover',
                ),
            ),
            'pagination_active_border_color' => array(
                'css' => 'border-color: %1$s !important;',
                'selector' => array(
                    'desktop' => '%%order_class%% .dnwoo-paginav ul li.active',
                ),
            ),
            'pagination_active_text_color' => array(
                'css' => 'color: %1$s !important;',
                'selector' => array(
                    'desktop' => '%%order_class%% .dnwoo-paginav ul li.active a',
                    'hover' => '%%order_class%% .dnwoo-paginav ul li.active a:hover',
                ),
            ),
            'topbar_width' => array(
                'css' => 'width: %1$s !important;',
                'selector' => array(
                    'desktop' => '%%order_class%% .dnwoo-show-product-text',
                ),
            ),
        );

        foreach ($css_settings as $key => $value) {
            DNWoo_Common::set_css($key, $value['css'], $value['selector'], $render_slug, $this);
        }
        // item image width end
        // Image filter css
        DNWoo_Common::set_image_filter('image_grid', $this, $render_slug);

        /**
         * Custom Padding Margin Output
         *
         */
        $customMarginPadding = array(
            // No need to add "_margin" or "_padding" in the key
            'dnwoo_product_grid_image' => array(
                'selector' => '%%order_class%% .dnwoo_img_wrap, %%order_class%% .dnwoo_product_grid_img, %%order_class%% .dnwoo_product_imgwrap',
                'type' => array('margin', 'padding'), //
            ),
            'dnwoo_product_grid_product_name' => array(
                'selector' => '%%order_class%% .dnwoo_product_grid_title',
                'type' => array('margin', 'padding'),
            ),
            'dnwoo_product_grid_cate' => array(
                'selector' => '%%order_class%% .dnwoo_product_categories li a',
                'type' => array('margin', 'padding'),
            ),
            'dnwoo_product_grid_price' => array(
                'selector' => '%%order_class%% .dnwoo_product_grid_price',
                'type' => array('margin', 'padding'),
            ),
            'dnwoo_product_grid_addtocart' => array(
                'selector' => '%%order_class%% .dnwoo_product_grid_buttons .dnwoo_product_addtocart, %%order_class%% .dnwoo_product_grid_buttons .icon_cart',
                'type' => array('margin', 'padding'),
            ),
            'dnwoo_product_grid_viewcart' => array(
                'selector' => '%%order_class%% .dnwoo_product_grid_buttons .added_to_cart',
                'type' => array('margin', 'padding'),
            ),
            'dnwoo_product_grid_quickview' => array(
                'selector' => '%%order_class%% .dnwoo_product_grid_buttons .dnwoo-quick-btn.dnwoo-quickview',
                'type' => array('margin', 'padding'),
            ),
            'dnwoo_product_grid_onsale' => array(
                'selector' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-onsale',
                'type' => array('margin', 'padding'),
            ),
            'dnwoo_product_grid_outofstock' => array(
                'selector' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-stockout',
                'type' => array('margin', 'padding'),
            ),
            'dnwoo_product_grid_featured' => array(
                'selector' => '%%order_class%% .dnwoo_product_grid_badge .dnwoo-featured',
                'type' => array('margin', 'padding'),
            ),
            'dnwoo_addtocarticonmar' => array(
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid a.icon_cart',
                'type' => 'margin',
            ),
            'dnwoo_addtorcarticonpad' => array(
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid a.icon_cart::before',
                'type' => 'padding',
            ),
            'dnwoo_wishlisticonmar' => array(
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-wishlist-btn, %%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-action-btn',
                'type' => 'margin',
            ),
            'dnwoo_wishlisticonpad' => array(
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-wishlist-btn span.icon_heart_alt::before, %%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-wishlist-btn span.icon_heart::before',
                'type' => 'padding',
            ),
            'dnwoo_addcompareiconmar' => array(
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-compare-btn, %%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-compare-btn',
                'type' => 'margin',
            ),
            'dnwoo_addcompareiconpad' => array(
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-compare-btn span.icon_left-right::before, %%order_class%% .dnwoo-product-compare-btn.compare.icon_compare.added::before',
                'type' => 'padding',
            ),
            'dnwoo_addquickviewiconmar' => array(
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid a.icon_quickview',
                'type' => 'margin',
            ),
            'dnwoo_addquickviewiconpad' => array(
                'selector' => '%%order_class%% .dnwoo_icon_wrapgrid a.icon_quickview::before',
                'type' => 'padding',
            ),
            'dnwoo_product_grid_pagination' => array(
                'selector' => '%%order_class%% .dnwoo-paginav ul li',
                'type' => 'margin',
            ),
            'dnwoo_product_grid_pagination_space' => array(
                'selector' => '%%order_class%% .dnwoo-paginav ul li a, %%order_class%% .dnwoo-paginav ul li.active a',
                'type' => 'padding',
            ),
            'dnwoo_product_grid_pagi_loadmore' => array(
                'selector' => '%%order_class%% .dnwoo_load_more_btn_wrap a',
                'type' => 'margin',
            ),
            'dnwoo_product_grid_pagi_loadmore_space' => array(
                'selector' => '%%order_class%% .dnwoo_load_more_btn_wrap a',
                'type' => 'padding',
            ),
        );

        foreach ($customMarginPadding as $key => $value) {
            if (is_array($value['type'])) {
                foreach ($value['type'] as $type) {
                    DNWoo_Common::apply_mp_set_style($render_slug, $this->props, $key . "_" . $type, $value['selector'], $type);
                }
            } else {
                DNWoo_Common::apply_mp_set_style($render_slug, $this->props, $key . "_" . $value['type'], $value['selector'], $value['type']);
            }
        }

        // Quick View Pop up Arrow Color
        $this->generate_styles(
            array(
                'base_attr_name' => 'quickviewpopupbox_arrow_color',
                'selector' => '%%order_class%% .product-images .swiper-button-next, %%order_class%% .product-images .swiper-button-prev',
                'hover_selector' => '%%order_class%% .product-images .swiper-button-next:hover, %%order_class%% .product-images .swiper-button-prev:hover',
                'css_property' => 'color',
                'render_slug' => $render_slug,
                'important' => true,
                'type' => 'color',
            )
        );

        // Quick View Pop up Close Button
        $this->generate_styles(
            array(
                'base_attr_name' => 'quickviewpopupbox_closebtn_color',
                'selector' => '.dnwoo-quick-view-modal.dnwooquickview-open%%order_class%% .dnwoo-modal-dialog .dnwoo-modal-content .dnwoo-modal-close',
                'hover_selector' => '.dnwoo-quick-view-modal.dnwooquickview-open%%order_class%%  .dnwoo-modal-dialog .dnwoo-modal-content .dnwoo-modal-close:hover',
                'css_property' => 'color',
                'render_slug' => $render_slug,
                'important' => true,
                'type' => 'color',
            )
        );
    }

    public function apply_background_css($render_slug)
    {
        $gradient_opt = array(
            'sale_badge_' => array(
                "desktop" => "%%order_class%% .dnwoo_product_grid_badge .dnwoo-onsale",
                "hover" => "%%order_class%% .dnwoo_product_grid_badge .dnwoo-onsale:hover",
            ),
            'outofstock_badge_' => array(
                "desktop" => "%%order_class%% .dnwoo_product_grid_badge .dnwoo-stockout",
                "hover" => "%%order_class%% .dnwoo_product_grid_badge .dnwoo-stockout:hover",
            ),
            'featured_badge_' => array(
                "desktop" => "%%order_class%% .dnwoo_product_grid_badge .dnwoo-featured",
                "hover" => "%%order_class%% .dnwoo_product_grid_badge .dnwoo-featured:hover",
            ),
            'addtocard_' => array(
                "desktop" => "%%order_class%% .dnwoo_product_addtocart,%%order_class%% .dnwoo_choose_variable_option",
                "hover" => "%%order_class%% .dnwoo_product_addtocart:hover,%%order_class%% .dnwoo_choose_variable_option:hover",
            ),
            'viewcart_' => array(
                "desktop" => "%%order_class%% .dnwoo_product_grid_buttons .added_to_cart",
                "hover" => "%%order_class%% .dnwoo_product_grid_buttons .added_to_cart:hover",
            ),
            'quickview_' => array(
                "desktop" => "%%order_class%% .dnwoo_product_grid_buttons .dnwoo-quickview",
                "hover" => "%%order_class%% .dnwoo_product_grid_buttons .dnwoo-quickview:hover",
            ),
            'content_' => array(
                "desktop" => "%%order_class%% .dnwoo_product_details_wrap, %%order_class%% .dnwoo_product_grid_wrapper_layout_seven .dnwoo_product_grid_item .dnwoo_product_content",
                "hover" => "%%order_class%% .dnwoo_product_details_wrap:hover, %%order_class%% .dnwoo_product_grid_wrapper_layout_seven .dnwoo_product_grid_item .dnwoo_product_content:hover",
            ),
            'addtocarticonbg_' => array(
                "desktop" => "%%order_class%% .dnwoo_icon_wrapgrid a.icon_cart, %%order_class%% .dnwoo_icon_wrapgrid a.icon_menu",
                "hover" => "%%order_class%% .dnwoo_icon_wrapgrid a.icon_cart:hover, %%order_class%% .dnwoo_icon_wrapgrid a.icon_menu:hover, %%order_class%% .dnwoo_icon_wrapgrid a.added_to_cart:hover",
            ),
            'viewcarticonbg_' => array(
                "desktop" => "%%order_class%% .dnwoo_icon_wrapgrid a.added_to_cart",
                "hover" => "%%order_class%% .dnwoo_icon_wrapgrid a.added_to_cart:hover",
            ),
            'wishlisticonbg_' => array(
                "desktop" => "%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-wishlist-btn, %%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-action-btn",
                "hover" => "%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-wishlist-btn:hover, %%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-action-btn:hover",
            ),
            'addcompareiconbg_' => array(
                "desktop" => "%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-compare-btn",
                "hover" => "%%order_class%% .dnwoo_icon_wrapgrid a.dnwoo-product-compare-btn:hover",
            ),
            'quickviewiconbg_' => array(
                "desktop" => "%%order_class%% .dnwoo_icon_wrapgrid a.icon_quickview",
                "hover" => "%%order_class%% .dnwoo_icon_wrapgrid a.icon_quickview:hover",
            ),
            'quickviewbtn_' => array(
                "desktop" => "%%order_class%% .dnwoo-product-summery .product-buttons .single_add_to_cart_button",
                "hover" => "%%order_class%% .dnwoo-product-summery .product-buttons .single_add_to_cart_button:hover",
            ),
            'quickview_view_btn_' => array(
                "desktop" => "%%order_class%% .dnwoo-product-summery .single_variation_wrap .added_to_cart.wc-forward",
                "hover" => "%%order_class%% .dnwoo-product-summery .single_variation_wrap .added_to_cart.wc-forward:hover",
            ),
            'quickviewpopupbg_' => array(
                "desktop" => ".dnwoo-quick-view-modal .dnwoo-modal-content %%order_class%%",
                "hover" => ".dnwoo-quick-view-modal .dnwoo-modal-content %%order_class%%:hover",
            ),
            'quickviewpopuparrow_' => array(
                "desktop" => "%%order_class%% .product-images .swiper-button-next, %%order_class%% .product-images .swiper-button-prev",
                "hover" => "%%order_class%% .product-images .swiper-button-next:hover, %%order_class%% .product-images .swiper-button-prev:hover",
            ),
            'quickviewpopup_close_btn_'  => array(
                "desktop" => ".dnwoo-quick-view-modal.dnwooquickview-open%%order_class%%  .dnwoo-modal-dialog .dnwoo-modal-content .dnwoo-modal-close",
                "hover"   => ".dnwoo-quick-view-modal.dnwooquickview-open%%order_class%%  .dnwoo-modal-dialog .dnwoo-modal-content .dnwoo-modal-close:hover",
            ),
            'image_overlay_' => array(
                "desktop" => "%%order_class%% .dnwoo_product_grid_wrapper_layout_four .dnwoo_product_grid_item:hover .dnwoo_product_imgwrap a.dnwoo_product_img::before,
                 %%order_class%% .dnwoo_product_grid_wrapper_layout_six .dnwoo_product_grid_item:hover .dnwoo_product_imgwrap a.dnwoo_product_img::before,
                 %%order_class%% .dnwoo_product_grid_wrapper_layout_four .dnwoo_product_imgwrap a.dnwoo_product_img:hover::before,
                 %%order_class%% .dnwoo_product_grid_wrapper_layout_six .dnwoo_product_imgwrap a.dnwoo_product_img:hover::before",
            ),
            'topbar_' => array(
                "desktop" => '%%order_class%% .dnwoo-show-product-text',
                "hover" => '%%order_class%% .dnwoo-show-product-text:hover',
            ),
        );
        DNWoo_Common::apply_all_bg_css($gradient_opt, $render_slug, $this);
    }

    /*
     * _product_btn function
     *
     *   @param int $product_id
     *   @param string $product_type
     *   @param string $permalink
     *   @param string $show_add_to_cart
     *   @param string $add_to_cart_text
     *   @param string $select_option_text
     *   @param string $chooseOptionIcon
     *   @param string $cartIcon
     */
	public function _add_to_cart($product_id, $product_type, $permalink, $show_add_to_cart, $add_to_cart_text, $select_option_text, $chooseOptionIcon, $cartIcon) {
        global $product;
		$output = '';
		if ('variable' === $product_type) {
			$output = sprintf('<a href="%1$s" class="product_type_variable dnwoo_choose_variable_option">
            <span class="icon_menu_btn" %3$s></span> %2$s 
        </a>',
				$permalink,
				$select_option_text,
				$chooseOptionIcon
			);
		} else {
			$output = sprintf(
				'<a href="%1$s" data-quantity="1" class="product_type_%3$s dnwoo_product_addtocart add_to_cart_button ajax_add_to_cart dnwoo_cart_text_button" data-product_id="%2$s"><span class="icon_cart_btn" %5$s></span>%4$s</a>',
				'variable' == $product_type ? $permalink : sprintf('?add-to-cart=%1$s', $product_id),
				$product_id,
				$product_type,
				'on' === $show_add_to_cart ? $add_to_cart_text : '',
				$cartIcon
			);
		}

		return apply_filters('woocommerce_loop_add_to_cart_link', $output, $product, $product_type, $permalink, $show_add_to_cart, $add_to_cart_text, $select_option_text, $chooseOptionIcon, $cartIcon);
	}

    public function _add_to_cart_icon($product_id, $product_type, $permalink, $cartIcon, $chooseOptionIcon)
    {
        if ('variable' === $product_type) {
            return sprintf('<a href="%3$s" data-quantity="1" class="product_type_%1$s dnwoo_choose_variable_option_icon icon_menu" %2$s></a>',
                $product_type,
                $chooseOptionIcon,
                $permalink
            );
        }

        return sprintf(
            '<a href="%1$s" class="product_type_%3$s add_to_cart_button ajax_add_to_cart icon_cart" data-product_id="%2$s" %4$s></a>',
            'variable' == $product_type ? $permalink : sprintf('?add-to-cart=%1$s', $product_id),
            $product_id,
            $product_type,
            $cartIcon
        );
    }
    public function filter_products_query( $args ) {
		if ( is_search() ) {
			$args['s'] = get_search_query();
		}

		if ( function_exists( 'WC' ) ) {
			$args['meta_query'] = WC()->query->get_meta_query( et_()->array_get( $args, 'meta_query', array() ), true ); // phpcs:ignore
			$args['tax_query']  = WC()->query->get_tax_query( et_()->array_get( $args, 'tax_query', array() ), true ); // phpcs:ignore

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
}

new DNWooGrid;