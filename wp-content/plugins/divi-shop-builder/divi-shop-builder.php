<?php
/**
 * Plugin Name: Divi Shop Builder
 * Plugin URI: https://wpzone.co
 * Version: 2.0.22
 * Description:  Expand the Divi builder to your WooCommerce Shop, Cart, and Checkout pages. Build and customize all your ecommerce pages with Divi’s drag and drop builder.
 * Author: WP Zone
 * Tested up to: 6.7.1
 * WC tested up to: 9.5.2
 * Text Domain: divi-shop-builder
 * Domain Path: /languages/
 * License: GNU General Public License v3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Requires PHP: 7.0
 * AGS Info: ids.aspengrove 859817 ids.divispace 859817 legacy.key ags_divi_wc_license_key legacy.status ags_divi_wc_license_status adminPage admin.php?page=ags-divi-wc docs https://wpzone.co/docs/plugin/divi-shop-builder/
 * Update URI: https://wpzone.co/

 */

/*
    Despite the following, this project is licensed exclusively
    under GNU General Public License (GPL) version 3 (no future versions).
    This statement modifies the following text.

    Divi Shop Builder plugin
    Copyright (C) 2025  WP Zone

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

    ========

	For the text of the GNU General Public License version 3, and licensing/copyright information for third-party code used in this product, see ./license.txt.

*/
update_option ('ags_divi_wc_license_status', 'valid');
update_option ('ags_divi_wc_license_key', '*********');
define('DIVI_WOO_FILE_PATH', dirname(__FILE__));
include_once( DIVI_WOO_FILE_PATH . '/includes/implementation.php' );
include_once( DIVI_WOO_FILE_PATH . '/includes/product-meta-box.php' );

	/**
	 * Localisation
	 */
	load_plugin_textdomain( 'divi-shop-builder', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    // array of options

	/**
	 * AGS_divi_wc class
	 */
	if ( ! class_exists( 'AGS_divi_wc' ) ) {

		/**
		 * The Product Archive Customiser class
		 */
		final class AGS_divi_wc {

			protected $settings;
			private static $addedMenuItem;

			public static $pluginBaseUrl;
			public static $plugin_directory;
			public $loginErrors = [];
			public $registrationErrors = [];
			public $registrationSuccessMessage;


			// woocommerce-carousel-for-divi\woocommerce-carousel-for-divi.php
			const	PLUGIN_NAME			= 'Divi Shop Builder',
					PLUGIN_AUTHOR		= 'WP Zone',
					PLUGIN_VERSION		= '2.0.22',
					PLUGIN_EDITION      = 'pro',
					PLUGIN_STORE_URL	= 'https://wpzone.co/',
					PLUGIN_PAGE			= 'admin.php?page=ags-divi-wc',
					PLUGIN_FILE			= __FILE__,
					PLUGIN_SLUG			= 'divi-shop-builder';

			/**
			 * The constructor!
			 */
			public function __construct() {
				global $wpdb;
				
			    
				require __DIR__.'/updater/updater.php';
				
				
				if (ags_divi_wc_has_license_key()) {
                

					add_action( 'wp_enqueue_scripts', array( $this, 'ags_divi_wc_styles' ) );
					add_action( 'init', array( $this, 'ags_divi_wc_setup' ) );
                    add_action('init', 'wp_raise_memory_limit', -1);
					add_filter( 'et_fb_get_asset_definitions', array( $this, 'get_asset_definitions' ), 11 );


					add_action( 'divi_extensions_init', 'agswcc_initialize_extension' );

					add_filter('et_builder_module_general_fields', [$this, 'filter_module_fields']);
					add_filter('do_shortcode_tag', [$this, 'filter_module_output'], 10, 3);
					add_filter('posts_search', [$this,'wpz_add_product_tags_to_search'], 10, 2);
					add_action('wp_loaded', [$this,'wpz_remove_default_search']);
					
					add_action('admin_init', [__CLASS__, 'onAdminInit']);
					
					add_action('wp_add_nav_menu_item', [__CLASS__, 'onAddNavMenuItem'], 10, 3);
					add_action('wp_update_nav_menu_item', [__CLASS__, 'onUpdateNavMenuItem'], 10, 2);
					add_filter('wp_setup_nav_menu_item', [__CLASS__, 'filterNavMenuItem']);
					add_filter('wp_nav_menu_item_custom_fields', [__CLASS__, 'navMenuItemSettings'], 10, 2);
					add_filter('walker_nav_menu_start_el', [__CLASS__, 'filterNavMenuItemStartHtml'], 10, 4);
					
					add_action('edit_term', [__CLASS__, 'onEditTaxonomyTerm'], 10, 3);
					
					add_action('wp_ajax_dswcp_update_cart', [__CLASS__, 'updateCartAjax']);
					add_action('wp_ajax_nopriv_dswcp_update_cart', [__CLASS__, 'updateCartAjax']);
					
					add_filter('woocommerce_add_to_cart_fragments', [__CLASS__, 'updateDiviHeaderCart']);
					
					if (!function_exists('et_show_cart_total') && $wpdb->get_var('SELECT 1 FROM '.$wpdb->postmeta.' WHERE meta_key="_dswcp_hide_divi_cart_icon" LIMIT 1')) {
						function et_show_cart_total() {}
					}
					
					// phpcs:ignore WordPress.Security.NonceVerification.Missing -- just a flag that controls output for this request, not a CSRF risk
					if (!empty($_POST['divishopbuilder_loginregister'])) {
						add_filter('login_errors', function($errorMessage) {
							$this->loginErrors[] = $errorMessage;
						}, 9999);
						add_filter('woocommerce_process_registration_errors', function ($error) {
							add_filter('woocommerce_add_success', [$this, 'captureRegistrationSuccess'], 9999);
							add_filter('woocommerce_add_error', [$this, 'captureRegistrationError'], 9999);
							return $error;
						});
						
						add_filter('woocommerce_registration_auth_new_customer', function ($return) {
							remove_filter('woocommerce_add_success', [$this, 'captureRegistrationSuccess'], 9999);
							remove_filter('woocommerce_add_error', [$this, 'captureRegistrationError'], 9999);
							// phpcs:ignore WordPress.Security.NonceVerification.Missing -- just a flag that controls output for this request, not a CSRF risk
							return $return && empty($_POST['divishopbuilder_no_login']);
						} );
					}
					
					add_filter('product_attributes_type_selector', [__CLASS__, 'filterProductAttributeTypes']);
					add_filter('woocommerce_dropdown_variation_attribute_options_html', [__CLASS__, 'filterProductAttributeField'], 10, 2);

                
				}
				

				// wp-layouts\ags-layouts.php
				self::$pluginBaseUrl    = plugin_dir_url(__FILE__);
				self::$plugin_directory = __DIR__ . '/';

				add_action('before_woocommerce_init', [$this,'before_woocommerce_init']);
				
				// wp-layouts\ags-layouts.php
				add_action('admin_menu', array(__CLASS__, 'registerAdminPage'), 11);
				// wp-layouts\ags-layouts.php
				add_action('admin_enqueue_scripts', array(__CLASS__, 'adminScripts'));
				// divi-switch\functions.php
				add_action('load-plugins.php', array(__CLASS__, 'onLoadPluginsPhp'));
				add_filter( 'woocommerce_settings_pages', array( $this, 'thankyou_page_setting' ), 99, 1 );

				register_activation_hook( AGS_divi_wc::PLUGIN_FILE, array(__CLASS__, 'plugin_first_activate' ) );


                add_action( 'admin_init', function () {
                    if ( current_user_can('manage_options')) {
                        include_once self::$plugin_directory . 'includes/admin/notices/admin-notices.php';
                    }
                });

				add_action('wp_ajax_dswcp_validate_checkout_step', [__CLASS__, 'validateCheckoutStep']);
				add_action('wp_ajax_nopriv_dswcp_validate_checkout_step', [__CLASS__, 'validateCheckoutStep']);
				
				add_filter('et_pb_module_shortcode_attributes', [__CLASS__, 'maybeAppendModuleStylesToOutput'], 10, 3);
				
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- just setting a non-persistent flag based on request type
				if (isset($_GET['wc-ajax']) && $_GET['wc-ajax'] === 'update_order_review' && !is_admin() && !defined('WOOCOMMERCE_CHECKOUT')) {
					define( 'WOOCOMMERCE_CHECKOUT', true );
				}

                
				if (self::PLUGIN_EDITION == 'pro') {
					require_once(__DIR__.'/includes/pro/WooShopPro.php');
				}
				
			}
			
			public function captureRegistrationError($errorMessage) {
				$this->registrationErrors[] = $errorMessage;
				return null;
			}
			
			public function captureRegistrationSuccess($message) {
				$this->registrationSuccessMessage = $message;
				return null;
			}
			
			public static function updateDiviHeaderCart($fragments) {
				ob_start();
				et_show_cart_total();
				$fragments['.et-cart-info:has(span:not(:empty))'] = ob_get_clean();
				return $fragments;
			}
			
			public static function maybeAppendModuleStylesToOutput($props, $attrs, $slug) {
				global $dswcp_is_nav_item, $dswcp_nav_item_layout_id;
				if (!empty($dswcp_is_nav_item)) {
					
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- non-persistent, output control only
					$isComputedPropertyRequest = (defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && $_REQUEST['action'] == 'et_pb_process_computed_property');
					if (et_core_is_fb_enabled() || $isComputedPropertyRequest) {
						add_filter($slug.'_shortcode_output', [__CLASS__, 'appendModuleStylesToOutput'], 10, 2);
						
						if ($isComputedPropertyRequest) {
							$index = rand(1, 999);
							for ($i = 0; $i < $index; ++$i) {
								ET_Builder_Element::set_order_class($slug);
							}
							
							// phpcs:ignore WordPress.Security.NonceVerification.Missing -- non-persistent, output control only
							if (!empty($_POST['conditional_tags']['is_wrapped_styles'])) {
								ET_Builder_Element::begin_theme_builder_layout($dswcp_nav_item_layout_id);
								add_filter('et_builder_default_post_types', [__CLASS__, 'emptyArray'], 9999);
							}
						}
					}
					
				}
				
				return $props;
			}
			
			public static function appendModuleStylesToOutput($output, $slug) {
				$output .= '<style>'.self::filterModuleStyles(ET_Builder_Element::get_style(), ET_Builder_Element::get_module_order_class($slug)).'</style>';
				
				// phpcs:ignore WordPress.Security.NonceVerification.Missing -- non-persistent, output control only
				if (!empty($_POST['conditional_tags']['is_wrapped_styles'])) {
					remove_filter('et_builder_default_post_types', [__CLASS__, 'emptyArray'], 9999);
					ET_Builder_Element::end_theme_builder_layout();
				}
				
				remove_filter($slug.'_shortcode_output', [__CLASS__, 'appendModuleStylesToOutput'], 10, 2);
				return $output;
			}
			
			public static function filterModuleStyles($styles, $orderClass) {
				$inBlock = false;
				$inOwnBlock = false;
				$inQuote = '';
				$inEscape = false;
				$inMediaQuery = false;
				$inParenthesis = 0;
				$buffer = '';
				$result = '';
				for ($i = 0; $i < strlen($styles); ++$i) {
					$buffer .= $styles[$i];
					switch ($styles[$i]) {
						case '"':
						case '\'':
							if (!$inEscape && $inQuote === $styles[$i]) {
								$inQuote = '';
							} else if (!$inQuote) {
								$inQuote = $styles[$i];
							}
							break;
						case '\\':
							if ($inQuote) {
								$inEscape = !$isEscape;
							}
							break;
						case '@':
							if (!$inBlock && !$inQuote && substr($styles, $i + 1, 5) == 'media') {
								$inMediaQuery = true;
								$inParenthesis = 0;
							}
							break;
						case '{':
							if (!$inBlock && !$inQuote && !$inEscape) {
								if ($inMediaQuery) {
									$inMediaQuery = false;
									$result .= $buffer;
									$buffer = '';
								} else {
									$inBlock = true;
									if (strpos($buffer, '.'.$orderClass) !== false || strpos($buffer, '#'.$orderClass) !== false) {
										$inOwnBlock = true;
										$result .= $buffer;
									} else if ($inOwnBlock) {
										$result .= '{';
									}
									$inParenthesis = 0;
									$buffer = '';
								}
							}
							break;
						case '}':
							if (!$inQuote && !$inEscape) {
								if ($inBlock) {
									if ($inOwnBlock) {
										$result .= $buffer;
									}
									$buffer = '';
									$inBlock = false;
									$inOwnBlock = false;
								} else {
									$result .= $buffer;
									$buffer = '';
								}
							}
							break;
						case ',':
							if (!$inBlock && !$inMediaQuery && !$inQuote && !$inEscape) {
								if (strpos($buffer, '.'.$orderClass) !== false || strpos($buffer, '#'.$orderClass) !== false) {
									$result .= substr($buffer, 0, -1);
									$buffer = ',';
									$inOwnBlock = true;
								} else {
									$buffer = $buffer[0] == ',' ? ',' : '';
								}
							}
						case '(':
							if (!$inBlock && !$inMediaQuery && !$inQuote && !$inEscape) {
								++$inParenthesis;
							}
							break;
						case ')':
							if ($inParenthesis && !$inQuote && !$inEscape) {
								--$inParenthesis;
							}
							break;
						
					}
					
					if ($styles[$i] !== '\\') {
						$inEscape = false;
					}
				}
				
				return $result;
			}
			
			public static function emptyArray() {
				return [];
			}
			
			public static function updateCartAjax() {
				require_once(ET_BUILDER_DIR.'functions.php');
				
				if (isset($_POST['cartAction'])) {
					check_ajax_referer('dswcp-update-cart');
					switch ($_POST['cartAction']) {
						case 'update-quantity':
							if (!isset($_POST['item']) || !isset($_POST['quantity'])) {
								wp_send_json_error();
							}
							WC()->cart->set_quantity( sanitize_text_field($_POST['item']), absint($_POST['quantity']) );
							break;
						case 'item-remove':
							if (!isset($_POST['item'])) {
								wp_send_json_error();
							}
							WC()->cart->remove_cart_item( sanitize_text_field($_POST['item']) );
							break;
						default:
							wp_send_json_error();
					}
				}
				
				if (isset($_POST['cartConfig'])) {
				
					$cartConfig = sanitize_text_field($_POST['cartConfig']);
					$cartConfigKeyDelim = strrpos($cartConfig, '|');
					
					if ($cartConfigKeyDelim) {
						$cartConfigSig = substr($cartConfig, $cartConfigKeyDelim + 1);
						$cartConfigKey = base64_decode(get_option('dswcp_mini_cart_config_key'));
						$cartConfig = base64_decode(substr($cartConfig, 0, $cartConfigKeyDelim));
						
						if ($cartConfig && $cartConfigKey && ($cartConfigSig === hash_hmac('sha256', $cartConfig.floor(time()/7200), $cartConfigKey) || $cartConfigSig === hash_hmac('sha256', $cartConfig.(floor(time()/7200) - 1), $cartConfigKey))) {
							$props = json_decode($cartConfig, true);
							if ($props) {
								$sideCartId = empty($_POST['sideCartId']) ? '' : sanitize_text_field($_POST['sideCartId']);
								ob_start();
								include(__DIR__.'/includes/pro/modules/WooMiniCart/render.php');
								wp_send_json_success( ['html' => ob_get_clean()] );
							}
						}
						
					
					}
				
				}
				
				wp_send_json_success(['reload' => 1]);
			}
			
			public static function validateCheckoutStep() {
				// phpcs:ignore WordPress.Security.NonceVerification.Missing, ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized -- just validating at this point, non-persistent; sanitizing on the next line
				parse_str(isset($_POST['fields']) ? $_POST['fields'] : '', $fields);
				$fields = array_map('sanitize_text_field', $fields);
				$result = ( new DSWCP_Validation_Checkout() )->check_fields($fields);
				if (is_wp_error($result)) {
					$html = '';
					foreach ( $result->errors as $errors ) {
						foreach ($errors as $error) {
							$html .= wc_print_notice($error, 'error', [], true);
						}
					}
					wp_send_json_error($html);
				}
				wp_send_json_success();
			}
			
			public static function onUpdateNavMenuItem($menuId, $menuItemId) {
				if (isset(self::$addedMenuItem) && $menuItemId === self::$addedMenuItem) {
					delete_post_meta($menuItemId, '_menu_item_classes');
					self::$addedMenuItem = null;
				}
				
				if (current_user_can('edit_theme_options') && isset($_REQUEST['update-nav-menu-nonce']) && wp_verify_nonce( sanitize_key($_REQUEST['update-nav-menu-nonce']), 'update-nav_menu')) {
					if (empty($_POST['dswcp-hide-divi-cart-icon'][$menuItemId])) {
						delete_post_meta($menuItemId, '_dswcp_hide_divi_cart_icon');
					} else {
						update_post_meta($menuItemId, '_dswcp_hide_divi_cart_icon', 1);
					}
					if (empty($_POST['dswcp-layout-id'][$menuItemId])) {
						delete_post_meta($menuItemId, '_dswcp_layout_id');
					} else {
						update_post_meta($menuItemId, '_dswcp_layout_id', (int) $_POST['dswcp-layout-id'][$menuItemId]);
					}
				}
			}
			
			public static function onEditTaxonomyTerm($termId, $termTaxonomyId, $taxonomy) {
				if (in_array($taxonomy, wc_get_attribute_taxonomy_names()) && isset($_REQUEST['_wpnonce']) && wp_verify_nonce(sanitize_key($_REQUEST['_wpnonce']), 'update-tag_'.$termId) && current_user_can('edit_term', $termId)) {
					if (isset($_POST['dswcp_filter_number'])) {
						if ($_POST['dswcp_filter_number'] === '') {
							delete_term_meta($termId, '_dswcp_filter_number');
						} else {
							update_term_meta($termId, '_dswcp_filter_number', (float) $_POST['dswcp_filter_number']);
						}
					}
					if (isset($_POST['dswcp_filter_color_type'])) {
						switch ($_POST['dswcp_filter_color_type']) {
							case 'color':
								update_term_meta($termId, '_dswcp_filter_color', isset($_POST['dswcp_filter_color']) ? sanitize_hex_color($_POST['dswcp_filter_color']) : '#000000');
								break;
							default:
								delete_term_meta($termId, '_dswcp_filter_color');
						}
					}
					if (isset($_POST['dswcp_filter_image'])) {
						$image = (int) $_POST['dswcp_filter_image'];
						if ($image && get_post_type($image) == 'attachment' && current_user_can('read', $image)) {
							update_term_meta($termId, '_dswcp_filter_image', $image);
						} else {
							delete_term_meta($termId, '_dswcp_filter_image');
						}
					}
				}
			}
			
			public static function filterProductAttributeTypes($types) {
				$types['dswcp_color'] = _x('Divi Shop Builder - Color', 'product attribute type', 'divi-shop-builder');
				return $types;
			}
			
			public static function filterProductAttributeField($html, $params) {
				// based on woocommerce/includes/wc-template-functions.php
				if ( !empty( $params['product'] ) && ! empty( $params['attribute'] ) ) {
					$attributes = $params['product']->get_attributes();
					if (isset($attributes[ $params['attribute'] ])) {
						$attribute = $attributes[ $params['attribute'] ];
						$taxonomyObject = $attribute->get_taxonomy_object();
						if (isset($taxonomyObject->attribute_type) && substr($taxonomyObject->attribute_type, 0, 6) == 'dswcp_') {
							if ( empty( $params['options'] ) ) {
								$variationAttributes = $params['product']->get_variation_attributes();
								$options = $variationAttributes[ $params['attribute'] ];
							} else {
								$options = $params['options'];
							}
							
							switch ($taxonomyObject->attribute_type) {
								case 'dswcp_color':
									$taxonomy = wc_attribute_taxonomy_name( $taxonomyObject->attribute_name );
									$html .= '<ul class="dswcp-palette">';
									foreach ($options as $option) {
										$term = get_term_by('slug', $option, $taxonomy);
										$color = get_term_meta($term->term_id, '_dswcp_filter_color', true);
										$html .= '<li data-value="'.esc_attr($option).'"><a href="#"'.($color ? ' style="background-color: '.esc_attr($color).';"' : '').'><span>'.esc_html($term->name).'</span></a></li>';
									}
									$html .= '</ul>';
									break;
							}
							
							$html = '<span class="dswcp-attribute-'.esc_attr( substr($taxonomyObject->attribute_type, 6) ).'">'.$html.'</span>';
						}
					}
				}
				return $html;
			}
			
			public static function productAttributeTermFields($term) {
?>
				<tr>
					<th scope="row" valign="top">
						<?php esc_html_e('Filtering Numeric Value', 'divi-shop-builder'); ?>
					</th>
					<td>
						<input type="number" name="dswcp_filter_number" value="<?php $number = get_term_meta($term->term_id, '_dswcp_filter_number', true); if ($number !== '') echo((float) $number); ?>">
						<p class="description">
							<?php
							printf(
								// translators: %1$s is the attribute name
								esc_html__('This value will be used for filtering if a numeric attribute filtering control is used for the %1$s attribute in Divi Shop Builder. If not set, this product will not be shown if a numeric filter is applied to the %1$s attribute. Numeric value range filtering is not recommended for attributes with a very large number of terms with numeric values.', 'divi-shop-builder'),
								esc_html(wc_attribute_label($term->taxonomy))
							);
							?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row" valign="top">
						<?php esc_html_e('Filtering Color', 'divi-shop-builder'); ?>
					</th>
					<td class="dswcp-filtering-color-options">
						<?php $colorValue = get_term_meta($term->term_id, '_dswcp_filter_color', true); ?>
						<label>
							<input type="radio" name="dswcp_filter_color_type" value="none"<?php checked(!$colorValue); ?>>
							<?php esc_html_e('None', 'divi-shop-builder'); ?>
						</label>
						<label>
							<input type="radio" name="dswcp_filter_color_type" value="color"<?php checked(!empty($colorValue)); ?>>
							<?php esc_html_e('Color:', 'divi-shop-builder'); ?>
						</label>
						<input type="color" name="dswcp_filter_color" value="<?php echo(esc_attr($colorValue)); ?>" onChange="jQuery(this).prev().children('input:first').attr('checked', true);">
						<p class="description">
							<?php
							printf(
								// translators: %1$s is the attribute name
								esc_html__('This color will be used for filtering if a color filtering control is used for the %1$s attribute in Divi Shop Builder. If not set, this product will not be shown if a color filter is applied to the %1$s attribute.', 'divi-shop-builder'),
								esc_html(wc_attribute_label($term->taxonomy))
							);
							?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row" valign="top">
						<?php esc_html_e('Filtering Image', 'divi-shop-builder'); ?>
					</th>
					<td>
						<?php $image = get_term_meta($term->term_id, '_dswcp_filter_image', true); ?>
						<?php
						if ($image) {
							echo(wp_get_attachment_image($image, 'thumbnail', false, ['sizes' => '', 'srcset' => '']));
						}
						?>
						<input type="hidden" name="dswcp_filter_image" value="<?php echo((int) $image); ?>">
						<button type="button" class="button-secondary dswcp-filter-image-select"><?php esc_html_e('Select Image', 'divi-shop-builder'); ?></button>
						<button type="button" class="button-secondary dswcp-filter-image-remove"<?php if (!$image) echo(' disabled'); ?>><?php esc_html_e('Remove Image', 'divi-shop-builder'); ?></button>
						
						<p class="description">
							<?php
							printf(
								// translators: %1$s is the attribute name
								esc_html__('This image will be used for filtering if an image attribute filtering control is used for the %1$s attribute in Divi Shop Builder. If not set, this product will not be shown if an image filter is applied to the %1$s attribute.', 'divi-shop-builder'),
								esc_html(wc_attribute_label($term->taxonomy))
							);
							?>
						</p>
						
						<script>
						// based on wp-admin/js/custom-background.js
						jQuery(function($) {
							var frame;
							$('.dswcp-filter-image-select').on( 'click', function( event ) {
								var $el = $(this);

								event.preventDefault();

								if ( frame ) {
									frame.open();
									return;
								}

								frame = wp.media.frames.customBackground = wp.media({
									title: $el.text(),
									library: {
										type: 'image'
									}
								});
								
								frame.on( 'select', function() {
									var attachment = frame.state().get('selection').first();
									var $img = $el.siblings('img:first');
									if (!$img.length) {
										$img = $('<img>').addClass('attachment-thumbnail size-thumbnail').prependTo($el.parent());
									}
									$img.attr({
										src: attachment.attributes.sizes.thumbnail ? attachment.attributes.sizes.thumbnail.url : attachment.attributes.url,
										alt: attachment.attributes.alt
									});
									$el.siblings('input:first').val(attachment.id);
									$el.siblings('.dswcp-filter-image-remove:first').attr('disabled', false);
								});
								
								frame.open();
							});
							
							
							$('.dswcp-filter-image-remove').on( 'click', function( event ) {
								var $el = $(this);

								event.preventDefault();
								
								$el.siblings('input:first').val(0);
								$el.siblings('img').remove();
								$el.attr('disabled', true);
							});
						});
						</script>
					</td>
				</tr>
<?php
			}
			
			public static function onAddNavMenuItem($menuId, $menuItemId, $menuItem) {
				if (isset($menuItem['menu-item-classes']) && in_array($menuItem['menu-item-classes'], ['dswcp-menu-mini-cart', 'dswcp-menu-cta'])) {
					self::$addedMenuItem = $menuItemId;
					update_post_meta($menuItemId, '_dswcp_type', $menuItem['menu-item-classes'] == 'dswcp-menu-cta' ? 'cta' : 'minicart');
				}
			}
			
			public static function filterNavMenuItem($item) {
				$type = get_post_meta($item->db_id, '_dswcp_type', true);
				if ($type == 'minicart') {
					$item->type = 'dswcp-mini-cart';
					$item->type_label = __('Divi Shop Builder Mini Cart', 'divi-shop-builder');
				} else if ($type == 'cta') {
					$item->type = 'dswcp-cta';
					$item->type_label = __('Divi Shop Builder Call To Action', 'divi-shop-builder');
				}
				return $item;
			}
			
			public static function navMenuItemSettings($menuItemId, $menuItem) {
				if ($menuItem->type == 'dswcp-mini-cart' || $menuItem->type == 'dswcp-cta') {
					$selectedLayout = get_post_meta($menuItemId, '_dswcp_layout_id', true);
					$requiredShortcode = $menuItem->type == 'dswcp-cta' ? 'et_pb_button' : 'ags_woo_mini_cart';
					
					$layouts = get_posts([
						'post_type' => 'et_pb_layout',
						'nopaging' => true,
						'ignore_sticky_posts' => true,
						's' => '['.$requiredShortcode,
						'search_columns' => ['post_content']
					]);
					
					
					if (is_array($layouts)) {
						$regex = '/'.get_shortcode_regex([$requiredShortcode]).'/';
						$layouts = array_filter($layouts, function($layout) use ($regex) {
							return preg_match($regex, $layout->post_content);
						});
					}
					
					if (!$layouts) {
						if (is_array($layouts)) {
							$layoutId = wp_insert_post([
								'post_type' => 'et_pb_layout',
								'post_title' => $menuItem->type == 'dswcp-cta' ? __('Call to Action Menu Item', 'divi-shop-builder') : __('Mini Cart Menu Item', 'divi-shop-builder'),
								'post_content' => '['.$requiredShortcode.'][/'.$requiredShortcode.']',
								'post_status' => 'publish'
							]);
							
							if ($layoutId) {
								update_post_meta($layoutId, '_et_pb_use_builder', 'on');
								wp_set_object_terms($layoutId, 'module', 'layout_type');
							
								$layouts = [
									get_post($layoutId)
								];
								$selectedLayout = $layoutId;
							}
						} else {
							$layouts = [];
						}
					}
					
					echo('<p class="description description-thin">
							<label>
								Divi Layout<br>
								<select name="dswcp-layout-id['.((int) $menuItemId).']">');
					foreach ($layouts as $layout) {
						echo('<option value="'.((int) $layout->ID).'"'.selected($layout->ID, $selectedLayout, false).'>'.esc_html($layout->post_title).'</option>');
					}
					echo(      '</select>
							</label>
						</p>');
					if ($menuItem->type == 'dswcp-mini-cart') {
						echo('<label><input type="checkbox" name="dswcp-hide-divi-cart-icon['.((int) $menuItemId).']"'.checked(get_post_meta($menuItemId, '_dswcp_hide_divi_cart_icon', true), 1, false).'>'
								.esc_html__('Hide the default Divi cart icon', 'divi-shop-builder')
								.'</label>');
					}
				}
			}
			
			public static function filterNavMenuItemStartHtml($html, $menuItem, $itemDepth, $params) {
				global $dswcp_is_nav_item, $dswcp_nav_item_layout_id;
				if ($menuItem->type == 'dswcp-mini-cart' || $menuItem->type == 'dswcp-cta') {
					$layoutId = get_post_meta($menuItem->ID, '_dswcp_layout_id', true);
					if ($layoutId) {
						$dswcp_is_nav_item = true;
						$dswcp_nav_item_layout_id = $layoutId;
						$html = $params->before.do_shortcode(get_the_content(null, false, $layoutId)).$params->after;
						$dswcp_is_nav_item = false;
						$dswcp_nav_item_layout_id = null;
					}
				}
				return $html;
			}
			
			public static function onAdminInit() {
				global $pagenow;
				
				// based on wp-admin/edit-link-form.php
				add_meta_box( 'dswcp-side-cart-menu-item-box', __( 'Divi Shop Builder', 'divi-shop-builder' ), [__CLASS__, 'navMenuMetaBox'], 'nav-menus', 'side' );
				
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- just adding fields to the output form (read-only)
				if (isset($pagenow) && $pagenow == 'term.php' && isset($_GET['taxonomy']) && in_array(sanitize_text_field($_GET['taxonomy']), wc_get_attribute_taxonomy_names())) {
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- just adding fields to the output form (read-only)
					add_filter( sanitize_text_field($_GET['taxonomy']).'_edit_form_fields', [__CLASS__, 'productAttributeTermFields'] );
					wp_enqueue_media();
				}
			}
			
			public static function navMenuMetaBox() {
				// based on woocommerce/includes/admin/class-wc-admin-menus.php

				?>
				<div>
					<div class="tabs-panel-active">
						<ul class="categorychecklist">
							<li>
								<label>
									<input type="checkbox" class="menu-item-checkbox" name="menu-item[-1][menu-item-object-id]" value="-1" />
									<?php esc_html_e('Mini Cart', 'divi-shop-builder'); ?>
								</label>
								<input type="hidden" class="menu-item-type" name="menu-item[-1][menu-item-type]" value="custom" />
								<input type="hidden" class="menu-item-title" name="menu-item[-1][menu-item-title]" value="<?php esc_attr_e('Mini Cart', 'divi-shop-builder'); ?>" />
								<input type="hidden" class="menu-item-url" name="menu-item[-1][menu-item-url]" value="#" />
								<input type="hidden" class="menu-item-classes" name="menu-item[-1][menu-item-classes]" value="dswcp-menu-mini-cart" />
							</li>
							<li>
								<label>
									<input type="checkbox" class="menu-item-checkbox" name="menu-item[-2][menu-item-object-id]" value="-2" />
									<?php esc_html_e('Call to Action', 'divi-shop-builder'); ?>
								</label>
								<input type="hidden" class="menu-item-type" name="menu-item[-2][menu-item-type]" value="custom" />
								<input type="hidden" class="menu-item-title" name="menu-item[-2][menu-item-title]" value="<?php esc_attr_e('Call to Action', 'divi-shop-builder'); ?>" />
								<input type="hidden" class="menu-item-url" name="menu-item[-2][menu-item-url]" value="#" />
								<input type="hidden" class="menu-item-classes" name="menu-item[-2][menu-item-classes]" value="dswcp-menu-cta" />
							</li>
						</ul>
					</div>
					<p class="button-controls">
						<span class="add-to-menu">
							<button type="submit" class="button-secondary right" onClick="jQuery(this).closest('div').addSelectedToMenu(wpNavMenu.addMenuItemToBottom).find(':checkbox').prop('checked', false);">
								<?php esc_html_e( 'Add to menu', 'divi-shop-builder' ); ?>
							</button>
							<span class="spinner"></span>
						</span>
					</p>
				</div>
				<?php
			}


			// wp-layouts\ags-layouts.php
			public static function registerAdminPage() {
				/* Admin Pages */
				add_submenu_page('et_divi_options', esc_html__( 'Shop Builder', 'divi-shop-builder'), esc_html__( 'Shop Builder', 'divi-shop-builder'), 'manage_options', 'ags-divi-wc', array(__CLASS__, 'adminPage'));

			}

			/**
			 *  On plugin activate, creates an options to store
			 *  activation date
			 *
			 * @used in AGS_Divi_Wc_Notices :: notice_admin_conditions
			 */
			public static function plugin_first_activate() {
				$firstActivate = get_option( 'ds_divi_shop_builder_first_activate' );
				if ( empty( $firstActivate ) ) {
					update_option( 'ds_divi_shop_builder_first_activate', time(), false );
					update_option( 'ds_divi_shop_builder_notice_hidden', 0, false );
				}
			}

			// wp-layouts\ags-layouts.php
			public static function adminScripts() {

				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- just checking which page we are on
				if ( isset($_GET['page']) && $_GET['page'] == 'ags-divi-wc' ) {
					// wp-layouts\ags-layouts.php
					wp_enqueue_style('ags-layouts-admin', self::$pluginBaseUrl.'/styles/admin.min.css', array(), self::PLUGIN_VERSION);
					// ags-product-addons
					wp_enqueue_style('ags-divi-wc-addons-admin', self::$pluginBaseUrl .'/includes/admin/addons/css/admin.min.css', array(), self::PLUGIN_VERSION);

				}

			}

			// divi-switch\functions.php
			public static function pluginActionLinks($links) {

				array_unshift($links, '<a href="admin.php?page=ags-divi-wc">'.esc_html__('Settings', 'divi-shop-builder').'</a>');
				return $links;

			}
			// divi-switch\functions.php
			public static function onLoadPluginsPhp() {

				add_filter('plugin_action_links_'.plugin_basename(__FILE__), array(__CLASS__, 'pluginActionLinks'));

			}

			// woocommerce-carousel-for-divi\woocommerce-carousel-for-divi.php
			public static function adminPage() {
				
				if (ags_divi_wc_has_license_key()) {
                
					?>

					<div id="ags_divi_wc-settings-container">
					<div id="ags_divi_wc-settings">

						<div id="ags_divi_wc-settings-header">
                            <div class="ags_divi_wc-settings-logo">
                                <img alt="Divi Shop Builder Icon"
                                     src="<?php echo esc_url( AGS_divi_wc::$pluginBaseUrl . 'includes/media/icons/divi-shop-builder.svg' ); ?>">
                                <h1><?php esc_html_e( 'Divi Shop Builder', 'wpz-woocommerce-random-orders' ); ?></h1>
                            </div>
							<div id="ags_divi_wc-settings-header-links">
								<a id="ags_divi_wc-settings-header-link-support"
								   href="https://wpzone.co/docs/plugin/divi-shop-builder/"
								   target="_blank"><?php esc_html_e('Documentation', 'divi-shop-builder'); ?></a>
							</div>
						</div>

						<ul id="ags_divi_wc-settings-tabs">
							<li class="ags_divi_wc-settings-active">
								<a href="#about"><?php esc_html_e('About', 'divi-shop-builder'); ?></a>
							</li>
                            <li><a href="#addons"><?php esc_html_e('Addons', 'divi-shop-builder') ?></a></li>
                            
							<li><a href="#license"><?php esc_html_e('License Key', 'divi-shop-builder'); ?></a></li>
                            
						</ul>

						<div id="ags_divi_wc-settings-tabs-content">
							<div id="ags_divi_wc-settings-about" class="ags_divi_wc-settings-active">

                                <div class="mb-40">
                                    <h3><?php esc_html_e('Divi Shop Builder', 'divi-shop-builder') ?></h3>
                                    <p><?php esc_html_e('Expand the Divi builder to your WooCommerce Shop, Cart, and Checkout pages. Build and customize all your ecommerce pages with Divi’s drag and drop builder.', 'divi-shop-builder') ?></p>
                                    <p><?php printf( esc_html__('Divi Shop Builder includes %s 14 modules %s for styling default WooCommerce pages with Divi', 'divi-shop-builder'), '<strong>','</strong>'); ?></p>
                                    <ul>
                                        <li><?php esc_html_e('Filters Module', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Woo Shop +', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Cart List', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Cart/Checkout Notices', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Cart Totals', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Checkout Billing', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Checkout Coupon', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Checkout Order', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Checkout Shipping', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Thank you module', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Account Content', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Account Navigation', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Account User Image', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Account User Name', 'divi-shop-builder') ?></li>
                                    </ul>
                                </div>
                                <div class="mb-40">
                                    <h3><?php esc_html_e('Main features', 'divi-shop-builder') ?></h3>
                                    <ul>
                                        <li><?php esc_html_e('100+ configurations and styling options for unlimited layout possibilities', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Extend Divi’s drag and drop editor to Shop, Cart, Account, and Checkout pages', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Set what element to show in what order', 'divi-shop-builder') ?> </li>
                                        <li><?php esc_html_e('Build a custom Cart page with the List, Total, and Notices modules', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Customize every Checkout element with Billing, Coupon, Order, and Shipping modules', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Edit form titles and input fields with custom text and style options', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Includes hover effects for product images and CTA button style options', 'divi-shop-builder') ?></li>
                                        <li><?php esc_html_e('Add a list of products to any page with completely custom positioning and style', 'divi-shop-builder') ?> </li>
                                        <li><?php esc_html_e('Lets you edit every aspect of WooCommerce with the Divi builder', 'divi-shop-builder') ?></li>
                                    </ul>
                                    <p>
                                    <a href="https://wpzone.co/product/divi-shop-builder/" target="_blank"><?php esc_html_e ('Read More about plugin features', 'divi-shop-builder') ?>.</a>
                                    </p>
                                </div>

                                <div class="mb-40">
                                    <h3><?php esc_html_e ('Product documentation', 'divi-shop-builder') ?></h3>
								    <p><?php printf( esc_html__ ('Get started your adventure with Divi Shop Builder with a %splugin documentation%s that covers the basics ', 'divi-shop-builder'), '<a href="https://wpzone.co/docs/plugin/divi-shop-builder/" target="_blank">', '</a>'  ); ?></p>
                                </div>
                                <div class="mb-40">
                              <h3><?php esc_html_e('Premade layouts', 'divi-shop-builder') ?></h3>
                                    <p><?php printf( esc_html__ ('Divi Shop Builder ships great premade layouts that you can use to jumpstart your design. %sDownload layouts from here%s.', 'divi-shop-builder'), '<a href="http://divishopbuilder.aspengrovestudio.com/" target="_blank">', '</a>'  ); ?></p>
                                </div>
                            </div>

                            <div id="ags_divi_wc-settings-addons" >
								<?php
								define('AGS_DIVI_SHOP_BUILDER_ADDONS_URL', 'https://wpzone.co/wp-content/uploads/product-addons/divi-shop-builder.json');
								require_once( plugin_dir_path( __FILE__ ) . '/includes/admin/addons/addons.php');
								AGS_Divi_Shop_Builder_Addons::outputList();
								?>
                            </div>
                            
                            <div id="ags_divi_wc-settings-license">
								<?php ags_divi_wc_license_key_box(); ?>
							</div>
                            
						</div>
					</div>

					<script>
						var ags_divi_wc_tabs_navigate = function () {
							jQuery('#ags_divi_wc-settings-tabs-content > div, #ags_divi_wc-settings-tabs > li').removeClass('ags_divi_wc-settings-active');
							jQuery('#ags_divi_wc-settings-' + location.hash.substr(1)).addClass('ags_divi_wc-settings-active');
							jQuery('#ags_divi_wc-settings-tabs > li:has(a[href="' + location.hash + '"])').addClass('ags_divi_wc-settings-active');
						};

						if (location.hash) {
							ags_divi_wc_tabs_navigate();
						}

						jQuery(window).on('hashchange', ags_divi_wc_tabs_navigate);
					</script>

					<?php
                
				}

				else {
				   ags_divi_wc_activate_page();
				}
				
			}

			/**
			 * Divi Shop Builder setup
			 *
			 * @return void
			 */
			public function ags_divi_wc_setup()
            {

				$this->settings = [
					'layout' => [
						'label'            => esc_html__( 'Layout', 'divi-shop-builder' ),
						'description'      => esc_html__( 'Display products in list view or in default grid.', 'divi-shop-builder' ),
						'type'             => 'select',
						'choices'          => [
							'grid' => esc_html__( 'Grid', 'divi-shop-builder' ),
							'list' => sprintf( esc_html__('%s [PRO]', 'divi-shop-builder'), esc_html__( 'List', 'divi-shop-builder' ) ),
							'both' => sprintf( esc_html__('%s [PRO]', 'divi-shop-builder'), esc_html__( 'Grid / List View Switch', 'divi-shop-builder' ) ),
						],
						'default' => 'grid',
						'section'  => 'wc_ags_archive',
					],
					'deafault_view' => [
						'label'            => esc_html__( 'Default Layout', 'divi-shop-builder' ),
						'description'      => esc_html__( 'Default view for the Both layout type.', 'divi-shop-builder' ),
						'type'             => 'select',
						'choices'          => [
							'grid' => esc_html__( 'Grid', 'divi-shop-builder' ),
							'list' => esc_html__( 'List', 'divi-shop-builder' ),
						],
						'default' => 'grid',
						'show_if'     => [
							'layout' => 'both',
						],
						'section'  => 'wc_ags_archive',
					],
					'columns' => [
						'label'    => esc_html__( 'Product columns', 'divi-shop-builder' ),
						'description' => esc_html__('Changes the number of products per row for desktop devices.', 'divi-shop-builder'),
						'default'           => '4',
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_choices' ],
						'section'  => 'wc_ags_archive',
						'type'     => 'select',
						'responsive' => true,
						'choices'  => [
										'1' => '1',
										'2' => '2',
										'3' => '3',
										'4' => '4',
										'5' => '5',
										'6' => '6'
						],
						'show_if'     => [
							'layout' => array( 'grid', 'both' ),
						],
					],

					'description_type' => [
						'label'            => esc_html__( 'Description Content', 'divi-shop-builder' ),
						'description'      => esc_html__( 'Once Description is enabled for grid layout, or list view is enabled, for each product you can display the text. Choose if you want to display Short Description, or you want to set a custom text. You can change the custom text on the product edit page, and if it is not set, Short Description will be used.  ', 'divi-shop-builder' ),
						'type'             => 'select',
						'choices'          => [
							'short_description' => esc_html__( 'Display short description', 'divi-shop-builder' ),
							'custom_description' => esc_html__( 'Display custom description', 'divi-shop-builder' ),
						],
						'default' => 'short_description',
						'section'  => 'wc_ags_archive',
					],
					/*
					'columns_tablet' => [
						'label'    => __( 'Product columns for Tablet', 'divi-shop-builder' ),
						'description' => __('Changes the number of products per row for tablet devices.', 'divi-shop-builder'),
						'default'           => '3',
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_choices' ],
						'section'  => 'wc_ags_archive',
						'type'     => 'select',
						'choices'  => [
										'1' => '1',
										'2' => '2',
										'3' => '3',
										'4' => '4',
										'5' => '5'
						],
					],
					'columns_mobile' => [
						'label'    => __( 'Product columns for Mobile', 'divi-shop-builder' ),
						'description' => __('Changes the number of products per row for mobile devices.', 'divi-shop-builder'),
						'default'           => '1',
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_choices' ],
						'section'  => 'wc_ags_archive',
						'type'     => 'select',
						'choices'  => [
										'1' => '1',
										'2' => '2',
										'3' => '3'
						],
					],
					*/
					'product_count' => [
						'label'    => esc_html__( 'Display product count results', 'divi-shop-builder' ),
						'description' => esc_html__('Enable/disable the WooCommerce results count. Count results show up on the WooCommerce product archive pages that displays the amount of products you are currently viewing and the total amount of products in your current query.', 'divi-shop-builder'),
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_choices' ],
						'section'  => 'wc_ags_archive',
						'type'     => 'select',
						'default'     => 'above',
						'choices'          => [
							'hide' => esc_html__( 'Don\'t display', 'divi-shop-builder' ),
							'above' => esc_html__( 'Above', 'divi-shop-builder' ),
							'below' => esc_html__( 'Below', 'divi-shop-builder' ),
							'abovebelow' => esc_html__( 'Above and below', 'divi-shop-builder' ),
						],
					],
					'product_sorting' => [
						'label'    => esc_html__( 'Display product sorting', 'divi-shop-builder' ),
						'description' => esc_html__('WooCommerce offers the ability to customize the sorting order of products with a few settings changes. Enable or disable display the product sorting on the archive pages. Change default sorting by going to WooCommerce > Settings >> Products >> Default Product Sorting ', 'divi-shop-builder'),
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_choices' ],
						'section'  => 'wc_ags_archive',
						'type'     => 'select',
						'default'     => 'above',
						'choices'          => [
							'hide' => esc_html__( 'Don\'t display', 'divi-shop-builder' ),
							'above' => esc_html__( 'Above', 'divi-shop-builder' ),
							'below' => esc_html__( 'Below', 'divi-shop-builder' ),
							'abovebelow' => esc_html__( 'Above and below', 'divi-shop-builder' ),
						],
					],
					'pagination' => [
						'label'    => esc_html__( 'Display pagination', 'divi-shop-builder' ),
						'description' => esc_html__('', 'divi-shop-builder'),
						'default'           => 'below',
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_choices' ],
						'section'  => 'wc_ags_archive',
						'type'     => 'select',
						'choices'          => [
							'hide' => esc_html__( 'Don\'t display', 'divi-shop-builder' ),
							'above' => esc_html__( 'Above', 'divi-shop-builder' ),
							'below' => esc_html__( 'Below', 'divi-shop-builder' ),
							'abovebelow' => esc_html__( 'Above and below', 'divi-shop-builder' ),
						],
					],
					'in_stock_text' => [
						'label'       => esc_html__( 'In Stock Text', 'divi-shop-builder' ),
						'description' => esc_html__( 'Set custom text that will be displayed when a product is in stock and product availability text is not provided by WooCommerce', 'divi-shop-builder' ),
						'default'     => esc_html__( 'In stock', 'divi-shop-builder' ),
						'section'       => 'wc_ags_archive',
                        'type'        => 'text'
					],
					'new_badge_pos' => [
						'label'       => esc_html__( 'New Badge Position', 'divi-shop-builder' ),
						'description' => esc_html__( '', 'divi-shop-builder' ),
						'type'        => 'select',
						'default'     => 'no_overlay',
						'choices'     => array(
							'no_overlay'       => esc_html__( 'Don\'t overlay on product image', 'divi-shop-builder' ),
							'overlay_tl'     => esc_html__( 'Overlay on product image - top left', 'divi-shop-builder' ),
							'overlay_tr'         => esc_html__( 'Overlay on product image - top right', 'divi-shop-builder' ),
							'overlay_bl' => esc_html__( 'Overlay on product image - bottom left', 'divi-shop-builder' ),
							'overlay_br'    => esc_html__( 'Overlay on product image - bottom right', 'divi-shop-builder' ),
						),
						'section' => 'wc_ags_archive',
					],

					'sale_flash' => [
						'label'    => esc_html__( 'Display sale badges', 'divi-shop-builder' ),
						'description' => esc_html__('When a product is on sale in your shop, WooCommerce adds a sales flash to that product to show customers that the product has a sale running to draw their attention to it. Enable/disable displaying the sale badges (flashes) on the archive pages.', 'divi-shop-builder'),
						'default'           => true,
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_checkbox' ],
						'section'  => 'wc_ags_archive',
						'type'     => 'checkbox',
						'show_if_not'     => [
							'layout' => 'grid',
						],
					],
					'percentage_sale_flash' => [
						'label'    => esc_html__( 'Display percentage sale badges', 'divi-shop-builder' ),
						'description' => esc_html__('When a product is on sale in your shop, Divi Shop Builder adds a sales badge with calculated percentage of discounted price to that product to show customers that the product has a sale running to draw their attention to it. Enable/disable displaying the sale badges (flashes) on the archive pages.', 'divi-shop-builder'),
						'default'           => false,
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_checkbox' ],
						'section'  => 'wc_ags_archive',
						'type'     => 'checkbox',
						'show_if_not'     => [
							'layout' => 'grid'
						],
					],
					'percentage_sale_min_value' => [
						'label'    => esc_html__( 'Minimum discount percentage for displaying percentage sale badge', 'divi-shop-builder' ),
						'description' => esc_html__('This setting specifies the minimum discount percentage needed to show a discount badge on a product. If a product\'s discount meets or exceeds this threshold, the percentage will be displayed. For smaller discounts, only the sale badge text will be shown without the calculated percentage. This ensures significant discounts are highlighted and minor ones do not clutter the display.', 'divi-shop-builder'),
						'default'           => '5%',
						'input_attrs'  => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
						'default_unit'     => '%',
						'validate_unit'   => true,
						'allowed_units'   => array( '%'),
						'section'  => 'wc_ags_archive',
						'type'            => 'range'
					],
					'sale_badge_percentage_custom_text' => [
						'label'       => esc_html__( 'Percentage Badge Sale Text', 'divi-shop-builder' ),
						'description' => esc_html__( 'Set custom text that will be displayed in the percentage sale badge. X is a number placeholder.', 'divi-shop-builder' ),
						'default'     => esc_html__( '#% off', 'divi-shop-builder' ),
						'section'       => 'wc_ags_archive',
						'type'        => 'text'
					],
					'new_badge_custom_text' => [
						'label'       => esc_html__( 'New Badge Text', 'divi-shop-builder' ),
						'description' => esc_html__( 'Set custom text that will be displayed in the new badge', 'divi-shop-builder' ),
						'default'     => esc_html__( 'New', 'divi-shop-builder' ),
						'section'     => 'wc_ags_archive',
						'type'        => 'text'
					],
					'sale_badge_pos' => [
						'label'       => esc_html__( 'Sale Badge Position', 'divi-shop-builder' ),
						'description' => esc_html__( '', 'divi-shop-builder' ),
						'type'        => 'select',
						'default'     => 'no_overlay',
						'choices'     => array(
							'no_overlay'       => esc_html__( 'Don\'t overlay on product image', 'divi-shop-builder' ),
							'overlay_tl'     => esc_html__( 'Overlay on product image - top left', 'divi-shop-builder' ),
							'overlay_tr'         => esc_html__( 'Overlay on product image - top right', 'divi-shop-builder' ),
							'overlay_bl' => esc_html__( 'Overlay on product image - bottom left', 'divi-shop-builder' ),
							'overlay_br'    => esc_html__( 'Overlay on product image - bottom right', 'divi-shop-builder' ),
						),
						'section' => 'wc_ags_archive',
					],
					'sale_percentage_badge_pos' => [
						'label'       => esc_html__( 'Sale Percentage Badge Position', 'divi-shop-builder' ),
						'description' => esc_html__( 'This overwrites sale badge settings', 'divi-shop-builder' ),
						'type'        => 'select',
						'default'     => 'no_overlay',
						'choices'     => array(
							'no_overlay'       => esc_html__( 'Don\'t overlay on product image', 'divi-shop-builder' ),
							'overlay_tl'     => esc_html__( 'Overlay on product image - top left', 'divi-shop-builder' ),
							'overlay_tr'         => esc_html__( 'Overlay on product image - top right', 'divi-shop-builder' ),
							'overlay_bl' => esc_html__( 'Overlay on product image - bottom left', 'divi-shop-builder' ),
							'overlay_br'    => esc_html__( 'Overlay on product image - bottom right', 'divi-shop-builder' ),
						),
						'section' => 'wc_ags_archive',
					],
					'sale_badge_custom_text' => [
						'label'       => esc_html__( 'Sale Text', 'divi-shop-builder' ),
						'description' => esc_html__( 'Set custom text that will be displayed in the sale badge', 'divi-shop-builder' ),
						'default'     => esc_html__( 'Sale', 'divi-shop-builder' ),
						'section'       => 'wc_ags_archive',
                        'type'        => 'text'
					],
					'add_to_cart' => [
						'label'    => esc_html__( 'Display add to cart buttons', 'divi-shop-builder' ),
						'description' => esc_html__('Enable/disable displaying "Add to Cart" button on the archive pages.', 'divi-shop-builder'),
						'default'           => true,
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_checkbox' ],
						'section'  => 'wc_ags_archive_list',
						'type'     => 'checkbox',
						'show_if_not'     => [
							'layout' => 'grid',
						],
					],
					'quantity' => [
						'label'    => esc_html__( 'Display add to cart quantity field', 'divi-shop-builder' ),
						'description' => esc_html__('Enable/disable displaying add to cart quantity field on the archive pages.', 'divi-shop-builder'),
						'default'           => true,
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_checkbox' ],
						'section'  => 'wc_ags_archive_list',
						'type'     => 'checkbox',
						'show_if_not'     => [
							'layout' => 'grid',
						],
					],
					'default_quantity' => [
						'label'    => esc_html__( 'Add to cart default quantity', 'divi-shop-builder' ),
						'description' => esc_html__('Define a quantity for add to cart quantity field', 'divi-shop-builder'),
						'default'     => 1,
						'section'  => 'wc_ags_archive',
						'type'        => 'range',
						'unitless'    => true,
						'input_attrs' => array(
							'min'  => 1,
							'max'  => 100,
							'step' => 1
						),
					],
					'thumbnail' => [
						'label'    => esc_html__( 'Display product image', 'divi-shop-builder' ),
						'description' => esc_html__('Enable/disable displaying product thumbnails on the archive pages.', 'divi-shop-builder'),
						'default'           => true,
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_checkbox' ],
						'section'  => 'wc_ags_archive_list',
						'type'     => 'checkbox',
						'show_if_not'     => [
							'layout' => 'grid',
						],
					],
					'price' => [
						'label'    => esc_html__( 'Display prices', 'divi-shop-builder' ),
						'description' => esc_html__('Enable/disable displaying product prices on the archive pages.', 'divi-shop-builder'),
						'default'           => true,
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_checkbox' ],
						'section'  => 'wc_ags_archive_list',
						'type'     => 'checkbox',
						'show_if_not'     => [
							'layout' => 'grid',
						],
					],
					'rating' => [
						'label'    => esc_html__( 'Display ratings', 'divi-shop-builder' ),
						'description' => esc_html__('Enable/disable displaying product rating stars on the archive pages, below the image.', 'divi-shop-builder'),
						'default'           => true,
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_checkbox' ],
						'section'  => 'wc_ags_archive_list',
						'type'     => 'checkbox',
						'show_if_not'     => [
							'layout' => 'grid',
						],
					],
					'categories' => [
						'label'    => esc_html__( 'Display categories', 'divi-shop-builder' ),
						'description' => esc_html__('Enable/disable displaying the product category below the product price.', 'divi-shop-builder'),
						'default'           => false,
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_checkbox' ],
						'section'  => 'wc_ags_archive_list',
						'type'     => 'checkbox',
						'show_if_not'     => [
							'layout' => 'grid',
						],
					],
					'stock' => [
						'label'    => esc_html__( 'Display stock', 'divi-shop-builder' ),
						'description' => esc_html__('Show the "stock quantity" under each product in the shop, category and archive pages.', 'divi-shop-builder'),
						'default'           => false,
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_checkbox' ],
						'section'  => 'wc_ags_archive_list',
						'type'     => 'checkbox',
						'show_if_not'     => [
							'layout' => 'grid',
						],
					],
					'new_badge' => [
						'label'    => esc_html__( 'Display new badge', 'divi-shop-builder' ),
						'description' => esc_html__('Enable/disable this feature.', 'divi-shop-builder'),
						'default'           => false,
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_checkbox' ],
						'section'  => 'wc_ags_archive_list',
						'type'     => 'checkbox',
						'show_if_not'     => [
							'layout' => 'grid',
						],
					],
					'no_products_heading_text' => [
						'label'    => esc_html__( 'Heading Text', 'divi-shop-builder' ),
						'description' => esc_html__('Set the heading text of the message that is displayed when no products were found.', 'divi-shop-builder'),
						'default'     => __('No Products Found', 'divi-shop-builder'),
						'section'  => 'wc_ags_none_found',
						'type'        => 'text',
					],
					'no_products_text' => [
						'label'    => esc_html__( 'Message Text', 'divi-shop-builder' ),
						'description' => esc_html__('Set the text of the message that is displayed when no products were found.', 'divi-shop-builder'),
						'default'     => __('We couldn\'t find any products that match your filtering criteria.', 'divi-shop-builder'),
						'section'  => 'wc_ags_none_found',
						'type'        => 'text',
					],
					/*
					'new_badge_position' => [
						'label'    => __( 'Badge position', 'divi-shop-builder' ),
						'default'           => 'default',
						'sanitize_callback' => array( $this, 'ags_divi_wc_sanitize_choices' ),
						'section'  => 'wc_ags_badge',
						'type'     => 'select',
						'choices'  => [
							'default' => 'Below thumbnail',
							'top_left' => 'Top left corner',
							'top_right' => 'Top right corner',
							'bottom_left' => 'Bottom left corner',
							'bottom_right' => 'Bottom right corner',
						],
						'active_callback' => array( $this, 'ags_divi_wc_is_new_badge_enabled' ),
						'child_item' => 'new-badge',
						// Divi/includes/builder/module/Signup.php
						/*
						'show_if'     => [
							'new_badge' => 'on',
						],
						*/
						/* example:
						'show_if_not' => [
							'field' => 'off',
						],
						*/
					//],
					'newness' => [
						'label'           => esc_html__( 'Days', 'divi-shop-builder' ),
						'description' => esc_html__('Show a "NEW" badge for products published in the last X days', 'divi-shop-builder'),
						'default'           => '28', // update in implementation.php too if this changes
						'sanitize_callback' => [ $this, 'ags_divi_wc_sanitize_choices' ],
						'section'         => 'wc_ags_badge',
						'active_callback' => array( $this, 'ags_divi_wc_is_new_badge_enabled' ),
						'child_item' => 'new-badge',
						'type'        => 'range',
						'unitless'    => true,
						'input_attrs' => array(
							'min'  => 0,
							'max'  => 365,
							'step' => 1
						),
						/*
						'show_if'     => [
							'new_badge' => 'on',
						],
						*/
					],
					'new_badge_background' => [
						'label'    => esc_html__('New Badge', 'divi-shop-builder'),
						//'default'           => [ 'color' => '#000000' ],
						'section'  => 'wc_ags_badge',
						'type'            => 'background_options',
						'css' => [
							'main' => '.wc-new-badge'
						],
						'child_item' => 'new-badge',
						/*
						'show_if'     => [
							'new_badge' => 'on',
						],
						*/
					],
					'new_badge_text' => [
						'label'    => esc_html__('New Badge', 'divi-shop-builder'),
						'default'           => [ 'size' => 30, 'color' => '#000000' ],
						'section'  => 'wc_ags_badge',
						'type'            => 'text_options',
						'css' => [
							'main' => '.wc-new-badge'
						],
						'child_item' => 'new-badge',
						/*
						'show_if'     => [
							'new_badge' => 'on',
						],
						*/
					],
					'new_badge_border' => [
						'label'    => esc_html__('New Badge', 'divi-shop-builder'),
						//'default'           => [ 'radius' => 5 ],
						'section'  => 'wc_ags_badge',
						'type'            => 'border_options',
						'css' => [
							// divi-shop-builder\includes\css\divi-shop-builder.css
							'main' => 'ul.products li.product .wc-new-badge'
						],
						'child_item' => 'new-badge',
						/*
						'show_if'     => [
							'new_badge' => 'on',
						],
						*/
					],
					'button_style' => [
						'label'    => esc_html__('Button', 'divi-shop-builder'),
						'section'  => 'wc_ags_button',
						'type'     => 'button_options',
						//'use_alignment'            => true,
						'css' => [
							'main' => '.product .button',
                            'important' => 'all'
							//'alignment' => '.button',
						],
						'box_shadow'     => [
							'css' => [
								'main'      => '.product .button',
								'important' => true,
							],
						],
						'margin_padding' => [
							'css' => [
								'important' => 'all'
							]
						],
						'child_item' => 'button',
					],
					'sort_select' => [
						'label'    => esc_html__('Sorting Dropdown', 'divi-shop-builder'),
						'section'  => 'wc_ags_sort_select',
						'type'            => 'form_field_options',
						'css' => [
							'main' => '.woocommerce-ordering .orderby',
							// Divi\includes\builder\module\Signup.php
							'important'              => array( 'form_text_color' ),
						],
					],
					'quantity_style' => [
						'label'    => esc_html__('Quantity Field', 'divi-shop-builder'),
						'section'  => 'wc_ags_quantity',
						'type'            => 'form_field_options',
						'css' => [
							'main' => '.quantity input.qty',
							// Divi\includes\builder\module\Signup.php
							'important'              => 'all',
						],
					],
					'results_count_text' => [
						'label'    => esc_html__('Results Count', 'divi-shop-builder'),
						//'default'           => [ 'size' => 30, 'color' => '#000000' ],
						'section'  => 'wc_ags_results_count',
						'type'            => 'text_options',
						'css' => [
							'main' => '.woocommerce-result-count'
						],
					],
					'description_text' => [
						'label'    => esc_html__('Product Description', 'divi-shop-builder'),
						//'default'           => [ 'size' => 30, 'color' => '#000000' ],
						'section'  => 'wc_ags_product_description',
						'type'            => 'text_options',
						'css' => [
							'main' => '.ags-divi-wc-product-excerpt'
						],
//						'show_if'     => [
//							'layout' => 'list',
//						],
					],
					'pagination_border' => [
						'label'    => esc_html__('Pagination', 'divi-shop-builder'),
						//'default'           => [ 'radius' => 5 ],
						'section'  => 'wc_ags_pagination',
						'type'            => 'border_options',
						'css' => [
							'main' => '.woocommerce-pagination .page-numbers li'
						],
					],
					'pagination_wrapper_border' => [
						'label'    => esc_html__('Pagination Wrapper', 'divi-shop-builder'),
						'default'  => array(
							'border_styles' => array(
								'width' => '1px',
								'style' => 'solid',
								'color' => '#d3ced2'
							),
						),
						'section'  => 'wc_ags_pagination',
						'type'            => 'border_options',
						'css' => [
							'main' => '.woocommerce-pagination ul.page-numbers'
						],
					],

                    'pagination_active_text_color' => [
                        'label'    => esc_html__('Current Page Text Color', 'divi-shop-builder'),
                        'default' => '#8a7e88',
                        'section'  => 'wc_ags_pagination',
                        'type'            => 'alpha_color',
                        'css' => [
                            'main' => '.woocommerce-pagination .page-numbers li span.current'
                        ]
                    ],

                    'pagination_background_current' => [
                        'label'    => esc_html__('Current Page Text', 'divi-shop-builder'),
                        //'default'           => [ 'color' => '#000000' ],
                        'section'  => 'wc_ags_pagination',
                        'type'            => 'background_options',
                        'css' => [
                            'main' => '.woocommerce-pagination .page-numbers.current'
                        ],
                    ],

					'pagination_background' => [
						'label'    => esc_html__('Pagination Color', 'divi-shop-builder'),
						//'default'           => [ 'color' => '#000000' ],
						'section'  => 'wc_ags_pagination',
						'type'            => 'background_options',
						'css' => [
							'main' => '.woocommerce-pagination .page-numbers'
						],
					],

                    'pagination_text' => [
                        'label'    => esc_html__('Pagination', 'divi-shop-builder'),
                        //'default'           => [ 'size' => 30, 'color' => '#000000' ],
                        'section'  => 'wc_ags_pagination',
                        'type'            => 'text_options',
                        'css' => [
                            'main' => '.woocommerce-pagination .page-numbers',
                            'text_align' => '.woocommerce .woocommerce-pagination'
                        ],
                        'options_priority' => array(
                            'pagination_text_text_color' => 0,
                        ),
                    ],

					'product_background' => [
						'label'    => esc_html__('Product', 'divi-shop-builder'),
						//'default'           => [ 'color' => '#000000' ],
						'section'  => 'wc_ags_product',
						'type'            => 'background_options',
						'css' => [
							'main' => 'li.product'
						],
					],

					'product_border' => [
						'label'    => esc_html__('Product', 'divi-shop-builder'),
						//'default'           => [ 'radius' => 5 ],
						'section'  => 'wc_ags_product',
						'type'            => 'border_options',
						'css' => [
							'main' => 'li.product'
						],
					],

				];

				/*
				WooCommerce Subscriptions support

				Find the WCS_Query instance and hook add_menu_items() in admin requests.

				Note: If there is an admin_init hook in future, this could probably be moved there
				instead of in the init hook with an is_admin() check.
				*/
				if (is_admin()) {
					foreach ($GLOBALS['wp_filter']['init'][10] as $hook) {
						if (!empty($hook['function']) && is_array($hook['function']) && is_a($hook['function'][0], 'WCS_Query')) {
							$wcs_query = $hook['function'][0];
							add_filter( 'woocommerce_account_menu_items', [ $wcs_query, 'add_menu_items' ] );
							break;
						}
					}
				}


            }

			function get_settings($context='all') {
				if ($context == 'all') {
					$contextSettings = $this->settings;
				} else {
					$contextSettings = [];
					foreach ($this->settings as $settingId => $setting) {
						if ( !isset($setting['contexts']) || in_array($context, $setting['contexts']) ) {
							$contextSettings[$settingId] = $setting;
						}
					}
				}

				return $this->expand_settings($context, $contextSettings);
			}

			function expand_settings($context, $settings) {

				switch ($context) {
					case 'page':
						$expandedSettings = [];
						foreach ($settings as $settingId => $setting) {

								switch ($setting['type']) {

									case 'text_options':

										$commonParams = [];

										if (isset($setting['show_if'])) {
											$commonParams['show_if'] = $setting['show_if'];
										}
										if (isset($setting['show_if_not'])) {
											$commonParams['show_if_not'] = $setting['show_if_not'];
										}

										$expandedSettings[$settingId.'_font_family'] = array_merge($commonParams, [
											'label'	      => sprintf(esc_html__('%s Font Family', 'divi-shop-builder'), $setting['label']),
											'sanitize_callback' => 'et_sanitize_font_choices',
											'section'     => $setting['section'],
											'type'        => 'select_option',
											'choices'	=> self::get_font_choices(),
										]);

										if (isset($setting['default']['font_family'])) {
											$expandedSettings[$settingId.'_font_family']['default'] = $setting['default']['font_family'];
										}


										$expandedSettings[$settingId.'_size'] = array_merge($commonParams, [
											'label'	      => sprintf(esc_html__('%s Font Size', 'divi-shop-builder'), $setting['label']),
											'sanitize_callback' => 'absint',
											'section'     => $setting['section'],
											'type'        => 'range',
											'input_attrs' => array(
												'min'  => 12,
												'max'  => 50,
												'step' => 1
											),
										]);

										if (isset($setting['default']['font_size'])) {
											$expandedSettings[$settingId.'_font_size']['default'] = $setting['default']['font_size'];
										}

										$expandedSettings[$settingId.'_transform'] = array_merge($commonParams, [
											'label'    => sprintf(esc_html__('%s Font Style', 'divi-shop-builder'), $setting['label']),
											'sanitize_callback' => 'et_sanitize_font_style',
											'section'  => $setting['section'],
											'choices'     => et_divi_font_style_choices(),
											'type'        => 'font_style',
										]);

										if (isset($setting['default']['text_transform'])) {
											$expandedSettings[$settingId.'_text_transform']['default'] = $setting['default']['text_transform'];
										}

										$expandedSettings[$settingId.'_color'] = array_merge($commonParams, [
											'label'    => sprintf(esc_html__('%s Text Color', 'divi-shop-builder'), $setting['label']),
											'sanitize_callback' => 'et_sanitize_alpha_color',
											'type'            => 'alpha_color',
											'section'  => $setting['section'],
										]);

										if (isset($setting['default']['font_color'])) {
											$expandedSettings[$settingId.'_font_color']['default'] = $setting['default']['font_color'];
										}

										break;

									case 'border_options':

										$commonParams = [];

										if (isset($setting['show_if'])) {
											$commonParams['show_if'] = $setting['show_if'];
										}
										if (isset($setting['show_if_not'])) {
											$commonParams['show_if_not'] = $setting['show_if_not'];
										}

										$expandedSettings[$settingId.'_radius'] = array_merge($commonParams, [
											'label'	      => sprintf(esc_html__('%s Border Radius', 'divi-shop-builder'), $setting['label']),
											'sanitize_callback' => 'absint',
											'section'     => $setting['section'],
											'type'        => 'range',
											'input_attrs' => array(
												'min'  => 0,
												'max'  => 50,
												'step' => 1
											),
										]);

										if (isset($setting['default']['radius'])) {
											$expandedSettings[$settingId.'_radius']['default'] = $setting['default']['radius'];
										}

										break;

									case 'background_options':

										$commonParams = [];

										if (isset($setting['show_if'])) {
											$commonParams['show_if'] = $setting['show_if'];
										}
										if (isset($setting['show_if_not'])) {
											$commonParams['show_if_not'] = $setting['show_if_not'];
										}

										$expandedSettings[$settingId.'_color'] = array_merge($commonParams, [
											'label'    => sprintf(esc_html__('%s Background Color', 'divi-shop-builder'), $setting['label']),
											'sanitize_callback' => 'et_sanitize_alpha_color',
											'section'  => $setting['section'],
											'type'            => 'alpha_color',
										]);

										if (isset($setting['default']['color'])) {
											$expandedSettings[$settingId.'_color']['default'] = $setting['default']['color'];
										}

										break;

									default:
										$expandedSettings[$settingId] = $setting;
								}
						}

						break;
					default:
						$expandedSettings = $settings;
				}

				return $expandedSettings;
			}

			static function get_font_choices() {

	            /**
	             * Code from Elegant Themes
	             */
            	$site_domain = get_locale();

	            $google_fonts = et_builder_get_fonts( array(
		            'prepend_standard_fonts' => false,
	            ) );

	            $user_fonts = et_builder_get_custom_fonts();

	            // combine google fonts with custom user fonts
	            $google_fonts = array_merge( $user_fonts, $google_fonts );

	            $et_domain_fonts = array(
		            'ru_RU' => 'cyrillic',
		            'uk'    => 'cyrillic',
		            'bg_BG' => 'cyrillic',
		            'vi'    => 'vietnamese',
		            'el'    => 'greek',
		            'ar'    => 'arabic',
		            'he_IL' => 'hebrew',
		            'th'    => 'thai',
		            'si_lk' => 'sinhala',
		            'bn_bd' => 'bengali',
		            'ta_lk' => 'tamil',
		            'te'    => 'telegu',
		            'km'    => 'khmer',
		            'kn'    => 'kannada',
		            'ml_in' => 'malayalam',
	            );

	            $et_one_font_languages = et_get_one_font_languages();

	            $font_choices = array();
	            $font_choices['none'] = array(
		            'label' => 'Default Theme Font'
	            );

	            $removed_fonts_mapping = et_builder_old_fonts_mapping();

	            foreach ( $google_fonts as $google_font_name => $google_font_properties ) {
		            $use_parent_font = false;

		            if ( isset( $removed_fonts_mapping[ $google_font_name ] ) ) {
			            $parent_font = $removed_fonts_mapping[ $google_font_name ]['parent_font'];
			            $google_font_properties['character_set'] = $google_fonts[ $parent_font ]['character_set'];
			            $use_parent_font = true;
		            }

		            if ( '' !== $site_domain && isset( $et_domain_fonts[$site_domain] ) && isset( $google_font_properties['character_set'] ) && false === strpos( $google_font_properties['character_set'], $et_domain_fonts[$site_domain] ) ) {
			            continue;
		            }

		            $font_choices[ $google_font_name ] = array(
			            'label' => $google_font_name,
			            'data'  => array(
				            'parent_font'    => $use_parent_font ? $google_font_properties['parent_font'] : '',
				            'parent_styles'  => $use_parent_font ? $google_fonts[$parent_font]['styles'] : $google_font_properties['styles'],
				            'current_styles' => $use_parent_font && isset( $google_fonts[$parent_font]['styles'] ) && isset( $google_font_properties['styles'] ) ? $google_font_properties['styles'] : '',
				            'parent_subset'  => $use_parent_font && isset( $google_fonts[$parent_font]['character_set'] ) ? $google_fonts[$parent_font]['character_set'] : '',
				            'standard'       => isset( $google_font_properties['standard'] ) && $google_font_properties['standard'] ? 'on' : 'off',
			            )
		            );
	            }

	            /**
	             * End code from Elegant Themes
	             */

				return $font_choices;
			}

			/**
			 * Checkbox sanitization callback.
			 *
			 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
			 * as a boolean value, either TRUE or FALSE.
			 *
			 * @param bool $checked Whether the checkbox is checked.
			 * @return bool Whether the checkbox is checked.
			 */
			public function ags_divi_wc_sanitize_checkbox( $checked )
            {
				return ( ( isset( $checked ) && true == $checked ) ? true : false );
			}

			/**
			 * Sanitizes choices (selects / radios)
			 * Checks that the input matches one of the available choices
			 *
			 * @param array $input the available choices.
			 * @param array $setting the setting object.
			 */
			public function ags_divi_wc_sanitize_choices( $input, $setting ) {
				// Ensure input is a slug.
				$input = sanitize_key( $input );

				// Get list of choices from the control associated with the setting.
				$choices = $setting->manager->get_control( $setting->id )->choices;

				// If the input is a valid key, return it; otherwise, return the default.
				return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
			}


			public function ags_divi_wc_is_control_active( $control )
            {
				$settings = $this->get_settings('page');
				$optionValues = get_option('ags_divi_wc', []);
				$optionKey = substr( $control->id, 12, -1 );

				if ( isset( $settings[$optionKey]['show_if'] ) ) {
					foreach ( $settings[$optionKey]['show_if'] as $conditionField => $conditionValue ) {
						if ( !isset($optionValues[$conditionField]) || $optionValues[$conditionField] != $conditionValue ) {
							return false;
						}
					}
				}

				if ( isset( $settings[$optionKey]['show_if_not'] ) ) {
					foreach ( $settings[$optionKey]['show_if_not'] as $conditionField => $conditionValue ) {
						if ( isset($optionValues[$conditionField]) && $optionValues[$conditionField] == $conditionValue ) {
							return false;
						}
					}
				}

				return true;
			}

			/**
			 * Enqueue styles
			 *
			 * @return void
			 */
			function ags_divi_wc_styles()
            {
				wp_enqueue_style( 'ags-dynamic-styles', plugins_url( '/includes/css/divi-shop-builder-styles.css', __FILE__ ) );
			}

			// woocommerce-carousel-for-divi\woocommerce-carousel-for-divi.php
			// Divi\includes\builder\functions.php
			function get_asset_definitions($defs) {

				// for debug:
				//return $defs;

				if( !class_exists( 'AGS_Divi_WC_ModuleShop_Child' ) ){
					return $defs;
				}

				$shortcodes = '';
				foreach ( array_diff_key(AGS_Divi_WC_ModuleShop_Child::$TYPES, ['attribute' => 0, 'taxonomy' => 0]) as $type => $label ) {
					$shortcodes .= '[ags_woo_shop_plus_child item="'.$type.'" item_title="'.$label.'" /]';
				}

				$account_nav_shortcodes = '';
				$account_content_shortcodes = '';
				$menuItems = wc_get_account_menu_items();

				foreach( $menuItems as $item => $name ) {
					$account_nav_shortcodes 	.= '[ags_woo_account_navigation_item item="'.$item.'" item_title="'.$name.'" /]';

					if( $item === 'customer-logout' ) continue;

					$account_content_shortcodes .= '[ags_woo_account_content_item item="'.$item.'" item_title="'.$name.'" /]';
				}

				$account_content_shortcodes .= '[ags_woo_account_content_item item="login" item_title="'. __( 'Login, Register, Lost Password', 'divi-shop-builder' ) . '" /]';

				return $defs.sprintf(
					'; window.AGS_Divi_WC_Backend=%s;',
					et_fb_remove_site_url_protocol(
						wp_json_encode(
							[
								// Divi\includes\builder\functions.php
								'shopModuleDefaultContent' => et_fb_process_shortcode($shortcodes),
								'accountNavModuleDefaultContent' => et_fb_process_shortcode($account_nav_shortcodes),
								'accountContentModuleDefaultContent' => et_fb_process_shortcode($account_content_shortcodes)
							],
							ET_BUILDER_JSON_ENCODE_OPTIONS
						)
					)
				);
			}


			public function thankyou_page_setting( $settings ){

				$new_settings = array();

				foreach( $settings as $setting ){

					if( $setting['id'] === 'advanced_page_options' && $setting['type'] === 'sectionend' ){
						$new_settings[] = array(
							'title'    => __( 'Thank you page', 'woocommerce' ),
							'desc'     => __( 'Thank you page after the successful checkout', 'divi-shop-builder' ),
							'id'       => 'woocommerce_thankyou_page_id',
							'type'     => 'single_select_page',
							'default'  => '',
							'class'    => 'wc-enhanced-select-nostd',
							'css'      => 'min-width:300px;',
							'args'     => array(
								'exclude' =>
									array(
										wc_get_page_id( 'cart' ),
										wc_get_page_id( 'myaccount' ),
										wc_get_page_id( 'checkout' ),
									),
							),
							'desc_tip' => true,
							'autoload' => false,
						);
					}

					$new_settings[] = $setting;
				}

				$settings = $new_settings;

				return $settings;
			}

			/**
			 * Check if WooCommerce My Account Registration is enabled
			 *
			 * @return bool
			 */
			public function isWooMyAccountRegistrationEnabled() {
				return "yes" === get_option( 'woocommerce_enable_myaccount_registration' );
			}

			public function filter_module_fields($fields) {
				$moduleSlug = '';

				// Unfortunately we don't have a good way to determine which module these fields are from...
				$trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS + DEBUG_BACKTRACE_PROVIDE_OBJECT, 4);
				if (isset($trace[3]['object']->slug)) {
					$moduleSlug = $trace[3]['object']->slug;
				}

				switch ($moduleSlug) {
					case 'et_pb_search':
						$fields['dsb_include_products'] = array(
							'label'           => esc_html__( 'Include WooCommerce products (powered by Divi Shop Builder)', 'divi-shop-builder' ),
							'type'            => 'yes_no_button',
							'option_category' => 'configuration',
							'options'         => array(
								'off' => esc_html( 'No', 'divi-shop-builder' ),
								'on'  => esc_html( 'Yes', 'divi-shop-builder' ),
							),
							'description'     => esc_html__( 'Enable this option to include WooCommerce products in the search results', 'divi-shop-builder' ),
							'toggle_slug'     => 'exceptions',
						);
						$fields['dsb_search_product_tags'] = array(
							'label'           => esc_html__( 'Search WooCommerce product tags (powered by Divi Shop Builder)', 'divi-shop-builder' ),
							'type'            => 'yes_no_button',
							'option_category' => 'configuration',
							'options'         => array(
								'off' => esc_html( 'No', 'divi-shop-builder' ),
								'on'  => esc_html( 'Yes', 'divi-shop-builder' ),
							),
							'default'         => 'off',
							'description'     => esc_html__( 'Enable this option to search WooCommerce product tags', 'et_builder' ),
							'toggle_slug'     => 'exceptions',
							'show_if' => [
								'dsb_include_products' => 'on'
							]
						);
						break;
				}

				return $fields;
			}

			public function filter_module_output($output, $slug, $settings) {
				switch ($slug) {
					case 'et_pb_search':
						if (isset($settings['dsb_include_products']) && $settings['dsb_include_products'] == 'on') {
							$additionalFields = '<input type="hidden" name="dsb_include_products" value="1">';
							if (isset($settings['dsb_search_product_tags']) && $settings['dsb_search_product_tags'] == 'on') {
								$additionalFields .= '<input type="hidden" name="dsb_search_product_tags" value="1">';
							}

							$closeForm = strpos($output, '</form>');

							if ($closeForm) {
								$output = substr($output, 0, $closeForm).$additionalFields.substr($output, $closeForm);
							}
						}
						break;
				}

				return $output;
			}

		    function wpz_add_product_tags_to_search($searchSql, $query = false) {

			    if ( is_admin() || ! is_a( $query, 'WP_Query' ) || ! $query->is_search ) {
				    return $searchSql;
			    }
				
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- search is non-persistent
			    if ( $searchSql && isset( $_GET['et_pb_searchform_submit'] ) && isset( $_GET['dsb_include_products'] ) && isset( $_GET['dsb_search_product_tags'] ) ) {
				    global $wpdb;
				    $searchSql = preg_replace(
					    '/ (AND|OR) \\(' . preg_quote( $wpdb->posts ) . '\\.post_content (NOT )?LIKE \'(.+)\'\\)/U',
					    '$0 $1 $2 EXISTS( SELECT 1 FROM ' . $wpdb->term_relationships . ' JOIN ' . $wpdb->term_taxonomy . ' USING (term_taxonomy_id) JOIN ' . $wpdb->terms . ' USING (term_id) WHERE object_id=' . $wpdb->posts . '.ID AND taxonomy="product_tag" AND name LIKE \'$3\')',
					    $searchSql
				    );
			    }

			    return $searchSql;
			}

            /* Search Module */
			function wpz_remove_default_search() {
				remove_action( 'pre_get_posts', [ $this, 'et_pb_custom_search' ] );
				add_action( 'pre_get_posts', [ $this, 'wpz_custom_search' ] );
			}

			/* Search Module */
			function wpz_custom_search( $query = false ) {
				if ( is_admin() || ! is_a( $query, 'WP_Query' ) || ! $query->is_search ) {
					return;
				}
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- search is non-persistent
				if ( isset( $_GET['et_pb_searchform_submit'] ) && isset( $_GET['dsb_include_products'] ) ) {
					$postTypes = array();
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- search is non-persistent
					if ( ! isset( $_GET['et_pb_include_posts'] ) && ! isset( $_GET['et_pb_include_pages'] ) ) {
						$postTypes = array( 'post' );
					}
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- search is non-persistent
					if ( isset( $_GET['et_pb_include_pages'] ) ) {
						$postTypes = array( 'page' );
					}
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- search is non-persistent
					if ( isset( $_GET['et_pb_include_posts'] ) ) {
						$postTypes[] = 'post';
					}
					/* BEGIN Add custom post types */
					$postTypes[] = 'product';
					/* END Add custom post types */
					$query->set( 'post_type', $postTypes );
					
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- search is non-persistent
					if ( ! empty( $_GET['et_pb_search_cat'] ) ) {
						// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- search is non-persistent
						$categories_array = explode( ',', sanitize_text_field($_GET['et_pb_search_cat']) );
						$query->set( 'category__not_in', $categories_array );
					}
					
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- search is non-persistent
					if ( isset( $_GET['et-posts-count'] ) ) {
						// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- search is non-persistent
						$query->set( 'posts_per_page', (int) $_GET['et-posts-count'] );
					}
				}
			}


			function before_woocommerce_init() {
				class_exists('Automattic\WooCommerce\Utilities\FeaturesUtil') && Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__);
			}



		}


		global $ags_divi_wc;


		/**
		 * Creates the extension's main class instance.
		 *
		 * @since 1.0.0
		 */
		function agswcc_initialize_extension() {
			// woocommerce-carousel-for-divi\woocommerce-carousel-for-divi.php
			if ( function_exists('WC') ) {
				require_once plugin_dir_path( __FILE__ ) . 'includes/extension.php';
			}
		}

		$ags_divi_wc = new AGS_divi_wc();

	}
	
	
add_action('init', function() {
	if (class_exists('WC_Checkout')) {
	class DSWCP_Validation_Checkout extends WC_Checkout {
		public function check_fields($fields) {
			$fields['ship_to_different_address'] = !empty($fields['ship_to_different_address']);
			$errors = new WP_Error();
			$this->validate_posted_data($fields, $errors);
			return $errors->has_errors() ? $errors : true;
		}
	}
	}
	
	class DSWCP_LibXML_Errror_Suppression {
		private $lastState;
		function __construct($filterName, $filterPriority=10) {
			add_filter($filterName, [$this, 'enable'], $filterPriority - 1);
			add_filter($filterName, [$this, 'disable'], $filterPriority + 1);
		}
		function enable($var) {
			$this->lastState = libxml_use_internal_errors(true);
			return $var;
		}
		function disable($var) {
			libxml_use_internal_errors($this->lastState);
			return $var;
		}
	}
	
	new DSWCP_LibXML_Errror_Suppression('wp_nav_menu');
});