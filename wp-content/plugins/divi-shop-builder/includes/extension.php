<?php
class AGSDiviWC_Extension extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'divi-shop-builder';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'divi-shop-builder';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = AGS_divi_wc::PLUGIN_VERSION ;

	/**
	 * DSWCP_DiviWoocommercePages constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'divi-woocommerce-pages', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		// includes plugin files
		$this->includes();

		parent::__construct( $name, $args );
	}

	/**
	 * includes plugin files
	 *
	 */
	public function includes(){
		include_once $this->plugin_dir . '../vendor/autoload.php';
		include_once $this->plugin_dir . 'helpers.php';
		include_once $this->plugin_dir . 'WoocommerceOverrides.php';
	}

	/**
	 * Overriding parent method to add
	 * @see parent::wp_hook_enqueue_scripts
	 *
	 */
	public function wp_hook_enqueue_scripts(){
		
		if ( et_core_is_fb_enabled() ) {
			$this->_builder_js_data = apply_filters( 'dswcp_builder_js_data', $this->common_localized_scripts() );
		}

		$this->_frontend_js_data = apply_filters( 'dswcp_frontend_js_data', [
			'ajaxUrl' => admin_url('admin-ajax.php')
		]);

		parent::wp_hook_enqueue_scripts();
		
		global $wp_scripts, $wp_styles;
		foreach ([$this->name . '-builder-bundle', $this->name . '-frontend-bundle'] as $scriptId) {
			if (isset($wp_scripts->registered[$scriptId])) {
				$wp_scripts->registered[$scriptId]->src = $this->add_edition_to_filename($wp_scripts->registered[$scriptId]->src);
			}
		}
		foreach ([$this->name . '-styles', $this->name . '-backend-styles'] as $styleId) {
			if (isset($wp_styles->registered[$styleId])) {
				$wp_styles->registered[$styleId]->src = $this->add_edition_to_filename($wp_styles->registered[$styleId]->src);
			}
		}

		wp_add_inline_script( $this->name . '-builder-bundle', 'var dswcp_pre__ = window._;', 'before' );
		wp_add_inline_script( $this->name . '-builder-bundle', 'window._ = dswcp_pre__;' );
		wp_add_inline_script( $this->name . '-frontend-bundle', 'var dswcp_pre__ = window._;', 'before' );
		wp_add_inline_script( $this->name . '-frontend-bundle', 'window._ = dswcp_pre__;' );
		$realPageId = $this->get_real_builder_page_id();
		
		if ( !$realPageId || $realPageId != wc_get_page_id( 'myaccount' ) ) {
			wp_add_inline_script( $this->name . '-builder-bundle', 'window.ags_divi_wc_notAccountPage = true;' );
		}
		if ( !$realPageId || $realPageId != wc_get_page_id( 'shop' ) ) {
			wp_add_inline_script( $this->name . '-builder-bundle', 'window.ags_divi_wc_notShopPage = true;' );
		}
		if ( !$realPageId || $realPageId != wc_get_page_id( 'cart' ) ) {
			wp_add_inline_script( $this->name . '-builder-bundle', 'window.ags_divi_wc_notCartPage = true;' );
		}
		if ( !$realPageId || $realPageId != wc_get_page_id( 'checkout' ) ) {
			wp_add_inline_script( $this->name . '-builder-bundle', 'window.ags_divi_wc_notCheckoutPage = true;' );
		}
		if ( !$realPageId || $realPageId != get_option( 'woocommerce_thankyou_page_id', - 1 ) ) {
			wp_add_inline_script( $this->name . '-builder-bundle', 'window.ags_divi_wc_notThankYouPage = true;' );
		}
		if ( 'yes' !== get_option( 'woocommerce_enable_myaccount_registration' ) ) {
			wp_add_inline_script( $this->name . '-builder-bundle', 'window.ags_divi_wc_notRegistrationEnabled = true;' );
		}
	}
	
	private function add_edition_to_filename($url) {
		$filenameStart = strrpos($url, '/');
		if ($filenameStart) {
			$filenameDot = strpos($url, '.', $filenameStart);
			if ($filenameDot) {
				$url = substr($url, 0, $filenameDot).'-'.AGS_divi_wc::PLUGIN_EDITION.substr($url, $filenameDot);
			}
		}
		return $url;
	}
	
	private function get_real_builder_page_id() {
		global $post;
		
		if (!empty($post)) {
			switch ($post->post_type) {
				case 'page':
					return $post->ID;
				case ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE:
				case ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE:
				case ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE:
					$templates = get_posts([
						'post_status' => 'publish',
						'post_type' => ET_THEME_BUILDER_TEMPLATE_POST_TYPE,
						'nopaging' => true,
						'ignore_sticky_posts' => true,
						'fields' => 'ids',
						'meta_key' => '_'.$post->post_type.'_id',
						'meta_value' => $post->ID
					]);
					
					
					$pageId = 0;
					foreach ($templates as $templateId) {
						$useOn = get_post_meta($templateId, '_et_use_on');
						if (!$useOn) {
							return 0;
						}
						
						foreach ($useOn as $condition) {
							$newPageId = 0;
							if ($condition) {
								$condition = explode(':', $condition);
								switch ($condition[0]) {
									case 'singular':
										if (count($condition) == 5 && $condition[1] == 'post_type' && $condition[2] == 'page' && $condition[3] == 'id') {
											$newPageId = (int) $condition[4];
										}
										break;
									case 'woocommerce':
										if (count($condition) == 2) {
											switch ($condition[1]) {
												case 'shop':
												case 'cart':
												case 'checkout':
													$newPageId = wc_get_page_id($condition[1]);
													break;
												case 'my_account':
													$newPageId = wc_get_page_id('myaccount');
													break;
											}
										}
								}
							}
							
							if ($newPageId && (!$pageId || $pageId == $newPageId)) {
								$pageId = $newPageId;
							} else {
								return 0;
							}
						}
						
					}
					return $pageId;
			}
		}
		return 0;
	}


protected function _set_bundle_dependencies() {
		parent::_set_bundle_dependencies();
		
		$this->_bundle_dependencies['builder'][] = 'wp-hooks';
		$this->_bundle_dependencies['builder'][] = 'wp-i18n';
	}

	/**
	 * Common localized scripts. So all the modules can share it
	 * @return Array
	 */
	private function common_localized_scripts(){
		
		$decimalSeparator = wc_get_price_decimal_separator();
		$thousandSeparator = wc_get_price_thousand_separator();
		
		// The visual builder modules crash if these are the same, so implement a fallback just in case
		if ($decimalSeparator == $thousandSeparator) {
			if ( strlen($decimalSeparator) ) {
				$thousandSeparator = '';
			} else {
				$decimalSeparator = '.';
			}
		}
		
		return array(
			'price_format' 	 => array(
				'currency'           => get_woocommerce_currency_symbol(),
				'decimal_separator'  => $decimalSeparator,
				'thousand_separator' => $thousandSeparator,
				'decimals'           => wc_get_price_decimals(),
				'price_format'       => get_woocommerce_price_format(),
			),
			'checkout_notice' => array(
				'heading' 			 => esc_html__( 'Checkout modules conflict', 'divi-shop-builder' ),
				'content' 			 => esc_html__( 'There are some modules conflict with Checkout modules. Please be ensure to place them on separate rows and not between checkout modules. Find the element by clicking below button', 'divi-shop-builder' ),
				'go_to_button' 		 => esc_html__( 'Go to Element', 'divi-shop-builder' ),
			)
		);
	}
}

// set the plugin instance as a global variable
// so we can use it later
$GLOBALS['dswcp'] = new AGSDiviWC_Extension;
