<?php

defined( 'ABSPATH' ) || exit;

/**
 * Get cart table columns
 *
 * @return Array
 *
 */
function dswcp_get_cart_columns(){

	return apply_filters( 'dswcp_cart_columns', array(
		'remove' 	=> '',
		'thumbnail' => '',
		'name' 		=> esc_html__( 'Product', 'woocommerce' ),
		'price' 	=> esc_html__( 'Price', 'woocommerce' ),
		'quantity' 	=> esc_html__( 'Quantity', 'woocommerce' ),
		'subtotal' 	=> esc_html__( 'Subtotal', 'woocommerce' ),
	) );

}

/**
 * Get decoded icon character
 *
 * @return String
 *
 */
function dswcp_decoded_et_icon( $icon ){
	//return '\\'.str_replace( ';', '', str_replace( '&#x', '', html_entity_decode( et_pb_process_font_icon( $icon ) ) ) );
	return str_replace( ';', '', str_replace( '&#x', '', html_entity_decode( et_pb_process_font_icon( $icon ) ) ) );
}


/**
 * Get if the endpoint is valid accoount type
 *
 */
function dswcp_is_account_endpoint( $type = '' ){
	return ( ( !empty( $type ) && is_wc_endpoint_url( $type ) ) || ( $type === '' && is_account_page() ) ) && $type === WC()->query->get_current_endpoint();
}

require_once(__DIR__.'/modules5/WooShop/traits/shortcode.php');

class AGS_WC_Shortcode_Products_Count_Simulator extends DSWCP_Shortcode_Products {
	protected $wpq;
	private $needsSearchFilter = false;

	function __construct($attributes=[], $type='products', $forPost=null) {
		parent::__construct(
			array_merge(
				$attributes,
				[
					'cache' => false,
					'paginate' => false
				],
				$this->getCountAttributes($forPost)
			)
		);
		$this->wpq = new WP_Query();
	}
	
	function getCountAttributes($forPost=null) {
		$countAttributes = dscwp_ags_filters_get_count_attributes($forPost);
		$attributes = [];
		if ($countAttributes) {
			$use_current_loop = isset($countAttributes['use_current_loop']) && $countAttributes['use_current_loop'] === 'on';
			
			
			if ( $use_current_loop ) {
				if ( is_product_category() ) {
					$attributes['category'] = (string) absint(get_queried_object_id());
				} elseif ( is_product_tag() ) {
					$attributes['tag'] = get_queried_object()->slug;
				} elseif ( is_product_taxonomy() ) {
					$term = get_queried_object();
					$attributes['custom_taxonomy'] = $term->taxonomy;
					$attributes['custom_taxonomy_terms'] = (string) $term->term_id;
				} else if ( is_search() ) {
					$this->needsSearchFilter = true;
				}
			} else if (isset($countAttributes['type'])) {
				switch ($countAttributes['type']) {
					case 'product_category':
						if (!empty($countAttributes['include_categories'])) {
							$attributes['category'] = implode(',', array_map('absint', explode(',', $countAttributes['include_categories'])));
						}
						break;
					case 'product_tag':
						$attributes['tag'] = isset($countAttributes['include_tags']) ? implode(',', array_map('absint', explode(',', $countAttributes['include_tags']))) : '';
						$attributes['tag_field'] = 'term_id';
						break;
					case 'sale':
						$attributes['on_sale'] = 'true';
						break;
					case 'best_selling':
						$attributes['best_selling'] = 'true';
						break;
					case 'top_rated':
						$attributes['top_rated'] = 'true';
						break;
					case 'featured':
						$attributes['visibility'] = 'featured';
						break;
				}
			}
			
		}
		
		
		return apply_filters('dswcp_woo_shop_shortcode_args', $attributes, $countAttributes, ($use_current_loop || !isset($countAttributes['type'])) ? '' : $countAttributes['type'], 'counts');
	}
	
	static function add_search_to_products_query($queryParams) {
		$queryParams['s'] = get_query_var('s');
		return $queryParams;
	}

	function getSimulatedCount($filter=null, $value=null) {
		global $dswcp_query_vars;
		if ($filter) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- value is not used, only saved for later restoration
			if (isset($_GET[$filter])) {
				// phpcs:ignore ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.NonceVerification.Recommended -- value is not used, only saved for later restoration
				$originalValue = $_GET[$filter];
			}

			$_GET[$filter] = $value;
		}
		
		
		// Custom query vars are not used for counts
		if (isset($dswcp_query_vars)) {
			$queryVarsBefore = $dswcp_query_vars;
		}
		$dswcp_query_vars = [
			'shopCategory' => 'shopCategory',
			'shopTag' => 'shopTag',
			'shopSearch' => 'shopSearch',
			'shopRating' => 'shopRating',
			'shopPrice' => 'shopPrice',
			'shopSale' => 'shopSale',
			'shopStockStatus' => 'shopStockStatus',
			'shopAttribute' => 'shopAttribute_%s',
			'shopTaxonomy' => 'shopTaxonomy_%s'
		];

		dscwp_ags_filters_hooks();
		add_filter('posts_fields', [$this, 'filterQueryFields'], 9999);
		add_filter('posts_groupby', '__return_empty_string', 9999);
		
		if ($this->needsSearchFilter) {
			add_filter('woocommerce_shortcode_products_query', [__CLASS__, 'add_search_to_products_query']);
		}
		
		$result = current($this->wpq->query(
			array_merge(
				apply_filters( 'woocommerce_shortcode_products_query', $this->query_args, $this->attributes, $this->type ),
				['fields' => 'ids']
			)
		));

		dscwp_ags_filters_hooks_remove();
		remove_filter('posts_fields', [$this, 'filterQueryFields'], 9999);
		remove_filter('posts_groupby', '__return_empty_string', 9999);
		
		if ($this->needsSearchFilter) {
			remove_filter('woocommerce_shortcode_products_query', [__CLASS__, 'add_search_to_products_query']);
		}
		
		if (isset($queryVarsBefore)) {
			$dswcp_query_vars = $queryVarsBefore;
		} else {
			unset($dswcp_query_vars);
		}

		if (isset($originalValue)) {
			$_GET[$filter] = $originalValue;
		} else if ($filter) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- unsetting
			unset($_GET[$filter]);
		}

		return (int) $result;
	}

	function filterQueryFields($fields) {
		global $wpdb;
		return 'COUNT(DISTINCT '.$wpdb->posts.'.ID)';
	}
}

// phpcs:disable WordPress.Security.NonceVerification -- read-only operation
if ( isset($_POST['ags_wc_filters_product_counts']) ) {
	
	add_action('wp', function() {
		
		// phpcs:ignore ET.Sniffs.ValidatedSanitizedInput.InputNotValidated -- false positive, isset() check wraps this line
		$request = json_decode( sanitize_text_field( wp_unslash($_POST['ags_wc_filters_product_counts']) ) );
		
		// Don't check if filters are allowed when doing counts (we haven't rendered content at this point)
		add_filter('dswcp_is_product_filter_allowed', '__return_true');
		
		$postId = null;
		if (!empty((int) $_POST['forPost'])) {
			$postId = (int) $_POST['forPost'];
		}

		$result = [];
		$simulator = new AGS_WC_Shortcode_Products_Count_Simulator([], 'products', $postId);

		foreach ($request as $countRequest) {
			if ( $countRequest->value != 'all' ) {
				$count = $simulator->getSimulatedCount( $countRequest->filter, $countRequest->value );
			} else {
				if (!isset($allCount)) {
					$allCount = $simulator->getSimulatedCount();
				}
				$count = $allCount;
			}

			$result[] = [
				'parent' => $countRequest->parent,
				'filter' => $countRequest->filter,
				'count' => $count
			];
		}

		wp_send_json($result);
	});
	
}
// phpcs:enable WordPress.Security.NonceVerification

add_filter( 'ags_woo_shop_plus_before_print_shop', 'dscwp_ags_filters_before_shop', 10, 3 );
add_action( 'ags_woo_shop_plus_after_print_shop', 'dscwp_ags_filters_after_shop' );
add_filter( 'ags_woo_shop_html', 'dscwp_ags_filters_shop_output', 10, 2 );

// phpcs:ignore WordPress.Security.NonceVerification.Missing -- just adding hooks, setting constant, etc. at this stage
if ( isset($_POST['ags_wc_filters_ajax_shop']) || !empty($_POST['ags_wc_filters_ajax_notices']) ) {
	
// based on wp-admin/admin-ajax.php
define( 'DOING_AJAX', true );

add_action( 'template_redirect', function() {
	// Divi's DoNotCachePage feature is enabled for ajax requests, but this may cause a fatal PHP error
	if (class_exists('ET_Builder_Do_Not_Cache_Page')) {
		remove_action( 'template_redirect', [ ET_Builder_Do_Not_Cache_Page::instance(), 'maybe_prevent_cache' ] );
	}
}, 9);

add_filter('et_builder_load_requests', function($requests) {
	// phpcs:ignore WordPress.Security.NonceVerification -- just setting the builder to load for the current request, non-persistent
	if ( isset($_POST['ags_wc_filters_ajax_shop']) ) {
		// phpcs:ignore WordPress.Security.NonceVerification, ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized -- just setting the builder to load for the current request, non-persistent; we do not want to sanitize here because Divi compares these values against the unsanitized values in $_REQUEST so they need to be the same
		$requests['ags_wc_filters_ajax_shop'] = [ $_POST['ags_wc_filters_ajax_shop'] ];
	}
	
	// phpcs:ignore WordPress.Security.NonceVerification -- just setting the builder to load for the current request, non-persistent
	if (!empty($_POST['ags_wc_filters_ajax_notices'])) {
		// phpcs:ignore WordPress.Security.NonceVerification, ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized -- just setting the builder to load for the current request, non-persistent; we do not want to sanitize here because Divi compares these values against the unsanitized values in $_REQUEST so they need to be the same
		$requests['ags_wc_filters_ajax_notices'] = $_POST['ags_wc_filters_ajax_notices'];
	}
	
	return $requests;
});

$modulesLoadHook = apply_filters( 'et_builder_modules_load_hook', 'wp' );
add_action($modulesLoadHook, function() use ($modulesLoadHook) {
	remove_action($modulesLoadHook, 'et_builder_load_frontend_builder');
}, 9);
	
// phpcs:ignore WordPress.Security.NonceVerification.Missing -- just a read-only flag
if ( isset($_POST['ags_wc_filters_ajax_shop']) ) {
	ob_start();
	add_filter('lazyload_is_enabled', '__return_false', 999);
	add_filter('wp_redirect', 'dswcp_handle_axax_shop_redirect', 999);
}

// phpcs:ignore WordPress.Security.NonceVerification.Missing -- just checking whether to add filter, not making any input-based persistent changes
if ( !empty($_POST['ags_wc_filters_ajax_notices']) ) {
	add_filter('ags_woo_notices_html', 'dswcp_ags_filters_notices_output', 10, 2);
}

}

add_filter( 'save_post', 'dswcp_ags_filters_whitelist_filters', 10, 2 );
add_filter( 'wp_ajax_ags_wc_filters_search_suggestions', 'dswcp_ags_filters_search_suggestions' );
add_filter( 'wp_ajax_nopriv_ags_wc_filters_search_suggestions', 'dswcp_ags_filters_search_suggestions' );
add_filter( 'et_global_assets_list', 'dswcp_ags_filters_maybe_add_full_icons' );

function dswcp_ags_filters_notices_output($noticesHtml, $orderClass) {
	// phpcs:ignore WordPress.Security.NonceVerification.Missing -- no persistent changes, just output control for this request
	if (isset($_POST['ags_wc_filters_ajax_notices']) && in_array($orderClass, $_POST['ags_wc_filters_ajax_notices'])) {
		global $dswcp_ajax_notices_html, $dswcp_ajax_shop_html;
		
		if (!isset($dswcp_ajax_notices_html)) {
			$dswcp_ajax_notices_html = [];
		}
		
		$dswcp_ajax_notices_html[$orderClass] = $noticesHtml;
		
		// phpcs:ignore ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.NonceVerification.Missing -- false positive, we are sanitizing the value we are using; no persistent changes, just output control for this request
		if ( !empty($dswcp_ajax_shop_html) && $orderClass == sanitize_text_field(end($_POST['ags_wc_filters_ajax_notices'])) ) {
			dswcp_ags_filters_ajax_output();
		}
	}
}

function dswcp_ags_filters_ajax_output() {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- no persistent changes, just output control for this request
	if (isset($_REQUEST['add-to-cart'])) {
		add_filter('woocommerce_add_to_cart_fragments', '_dswcp_ags_filters_ajax_output', 999999);
		WC_Ajax::get_refreshed_fragments();
	} else {
		_dswcp_ags_filters_ajax_output();
	}
}

function _dswcp_ags_filters_ajax_output($wcFragments=null) {
	ob_end_clean();
	
	global $dswcp_ajax_notices_html, $dswcp_ajax_shop_html;
	
	$response = [
		'shop' => isset($dswcp_ajax_shop_html) ? $dswcp_ajax_shop_html : [],
		'notices' => isset($dswcp_ajax_notices_html) ? $dswcp_ajax_notices_html : []
	];
	
	if ($wcFragments) {
		$response['wc-fragments'] = $wcFragments;
		$response['wc-cart-hash'] = WC()->cart->get_cart_hash();
	}
	
	echo('/*agsdsb-json-start*/');
	wp_send_json($response);
}

function dswcp_handle_axax_shop_redirect($url) {
	if ($url) {
		ob_end_clean();
		echo('/*agsdsb-json-start*/');
		wp_send_json(['dswcpRedirect' => $url]);
	}
}

function dswcp_ags_filters_whitelist_filters($postId, $post) {
	$allowedFilters = [];
	
	if (strpos($post->post_content, '[ags_woo_products_filters_child') !== false) {
		
		preg_match_all(
			'/'.get_shortcode_regex(['ags_woo_products_filters_child']).'/',
			$post->post_content,
			$shortcodeMatches
		);
		
		foreach ($shortcodeMatches[0] as $shortcode) {
			
			if (preg_match('/\\schoose\\_filter="([[:alpha:]\\_]+)"/', $shortcode, $filterTypeMatch)) {
				
				// Note: Maintain list of GET vars in WooShop.php render() method
				
				switch ( $filterTypeMatch[1] ) {
					case 'category':
						$allowedFilters[] = 'shopCategory';
						break;
					case 'tag':
						$allowedFilters[] = 'shopTag';
						break;
					case 'attribute':
						if (preg_match('/\\sattribute="(.+)"/U', $shortcode, $attributeMatch)) {
							$allowedFilters[] = 'shopAttribute_'.$attributeMatch[1];
						}
						break;
					case 'taxonomy':
						if (preg_match('/\\staxonomy="(.+)"/U', $shortcode, $attributeMatch)) {
							$allowedFilters[] = 'shopTaxonomy_'.$attributeMatch[1];
						}
						break;
					case 'search':
						$allowedFilters[] = 'shopSearch';
						break;
					case 'rating':
						$allowedFilters[] = 'shopRating';
						break;
					case 'price':
						$allowedFilters[] = 'shopPrice';
						break;
					case 'stock_status':
						$allowedFilters[] = 'shopStockStatus';
						break;
					case 'sale':
						$allowedFilters[] = 'shopSale';
						break;
				}
			}
		}
		
	}
	
	
	if (strpos($post->post_content, '[ags_woo_shop_plus') !== false) {
		
		preg_match_all(
			'/'.get_shortcode_regex(['ags_woo_shop_plus']).'/',
			$post->post_content,
			$shortcodeMatches
		);
		
		foreach ($shortcodeMatches[0] as $index => $shortcodeAttributes) {
			if (strpos($shortcodeAttributes, ' filter_target="on"') !== false) {
				$shortcodeAttributes = shortcode_parse_atts($shortcodeAttributes);
				$countAttributes = [];
				
				if ($shortcodeAttributes['use_current_loop'] === 'on') {
					$countAttributes['use_current_loop'] = 'on';
				} else if (isset($shortcodeAttributes['type'])) {
					switch ($shortcodeAttributes['type']) {
						case 'featured':
							$countAttributes['type'] = 'featured';
							break;
						case 'sale':
							$countAttributes['type'] = 'sale';
							break;
						case 'best_selling':
							$countAttributes['type'] = 'best_selling';
							break;
						case 'top_rated':
							$countAttributes['type'] = 'top_rated';
							break;
						case 'product_category':
							$countAttributes['type'] = 'product_category';
							$countAttributes['include_categories'] = isset($shortcodeAttributes['include_categories']) ? $shortcodeAttributes['include_categories'] : '';
							break;
						case 'product_tag':
							$countAttributes['type'] = 'product_tag';
							$countAttributes['include_tags'] = isset($shortcodeAttributes['include_tags']) ? $shortcodeAttributes['include_tags'] : '';
							break;
					}
				}
				
				$countAttributes = apply_filters('dswcp_woo_shop_whitelisted_count_attributes', $countAttributes, $shortcodeAttributes);
			}
		}
	
	}
	
	
	if ($allowedFilters) {
		update_post_meta($post->ID, '_ags_wc_filters_allowed', $allowedFilters);
	} else {
		delete_post_meta($post->ID, '_ags_wc_filters_allowed');
	}
	
	if (empty($countAttributes)) {
		delete_post_meta($post->ID, '_ags_wc_filters_count_attributes');
	} else {
		update_post_meta($post->ID, '_ags_wc_filters_count_attributes', $countAttributes);
	}
}
	
function dscwp_ags_filters_before_shop($shouldRender, $props, $orderClass) {
	// phpcs:ignore WordPress.Security.NonceVerification.Missing -- just a flag to enable some hooks
	if ( isset($_POST['ags_wc_filters_ajax_shop']) && $orderClass != $_POST['ags_wc_filters_ajax_shop'] ) {
		return false;
	}
	add_filter( 'woocommerce_pagination_args', 'dswcp_ags_filters_strip_unwanted_pagination_url_params', 999 );
	
	if ($props['filter_target'] == 'on') {
		if (!wp_doing_ajax()) {
			dswcp_ags_fix_query_vars();
		}
		dscwp_ags_filters_hooks();
		add_filter( 'term_link', 'dswcp_ags_filters_transform_category_urls', 10, 2 );
		add_filter( 'term_links-product_cat', 'dswcp_ags_filters_transform_category_links' );
	}
	
	return $shouldRender;
}

function dscwp_ags_filters_after_shop() {
	remove_filter( 'woocommerce_pagination_args', 'dswcp_ags_filters_strip_unwanted_pagination_url_params', 999 );
	dscwp_ags_filters_hooks_remove();
}

function dswcp_ags_fix_query_vars() {
	static $queryVarsFixed = false;
	global $dswcp_query_vars;
	
	if (!$queryVarsFixed) {
		if (!empty($_SERVER['QUERY_STRING'])) {
			$queryVars = [];
			foreach ( explode('&', sanitize_text_field($_SERVER['QUERY_STRING'])) as $querySegment ) {
				wp_parse_str($querySegment, $querySegment);
				foreach ($querySegment as $var => $value) {
					if (in_array($var, $dswcp_query_vars) && isset($queryVars[$var])) {
						$queryVars[$var] .= ','.$value;
					} else {
						$queryVars[$var] = $value;
					}
				}
			}
			
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- we're just adding to $_GET, not using the variables at this time
			$_GET = array_merge($_GET, $queryVars);
		}
		
		$queryVarsFixed = true;
	}
}

function dscwp_ags_filters_hooks() {
	global $dswcp_query_vars;
	
	$productsQueryFilters = [
		'shopCategory' => 'dswcp_ags_filters_categories',
		'shopTag' => 'dswcp_ags_filters_tags',
		'shopSearch' => 'dswcp_ags_filters_search',
		'shopRating' => 'dswcp_ags_filters_rating',
		'shopPrice' => 'dswcp_ags_filters_price',
		'shopStockStatus' => 'dswcp_ags_filters_stock_status'
	];
	
	
	foreach ($dswcp_query_vars as $filterType => $queryVar) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only operation
		if ( !empty($_GET[$queryVar]) && dscwp_ags_filters_is_filter_allowed($filterType) ) {
			if ($filterType == 'shopSale') {
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only operation
				if ($_GET[$queryVar] == 'onsale') {
					$GLOBALS['ags_wc_filters_sale_filter'] = new AGS_WC_Filters_Sale_Filter();
				}
			} else if (isset($productsQueryFilters[$filterType])) {
				add_filter( 'woocommerce_shortcode_products_query', $productsQueryFilters[$filterType] );
				if ($filterType == 'shopSearch') {
					add_filter('posts_search', 'dswcp_ags_filters_search_sql_filtering');
				}
			}
		}
	}
	
	add_filter( 'woocommerce_shortcode_products_query', 'dswcp_ags_filters_attributes' );
	add_filter( 'woocommerce_shortcode_products_query', 'dswcp_ags_filters_taxonomy' );
}


function dscwp_ags_filters_hooks_remove() {
	remove_filter( 'woocommerce_shortcode_products_query', 'dswcp_ags_filters_categories' );
	remove_filter( 'woocommerce_shortcode_products_query', 'dswcp_ags_filters_tags' );
	remove_filter( 'woocommerce_shortcode_products_query', 'dswcp_ags_filters_search' );
	remove_filter( 'woocommerce_shortcode_products_query', 'dswcp_ags_filters_rating' );
	remove_filter( 'woocommerce_shortcode_products_query', 'dswcp_ags_filters_price' );
	remove_filter( 'woocommerce_shortcode_products_query', 'dswcp_ags_filters_stock_status' );
	remove_filter('posts_search', 'dswcp_ags_filters_search_sql_filtering');
	if (isset($GLOBALS['ags_wc_filters_sale_filter'])) {
		$GLOBALS['ags_wc_filters_sale_filter']->unhook();
		unset($GLOBALS['ags_wc_filters_sale_filter']);
	}
	remove_filter( 'woocommerce_shortcode_products_query', 'dswcp_ags_filters_attributes' );
	remove_filter( 'woocommerce_shortcode_products_query', 'dswcp_ags_filters_taxonomy' );
	
	global $dswcp_active_attribute_filters;
	unset($dswcp_active_attribute_filters);
}

function dscwp_ags_filters_is_filter_allowed($filter) {
	$result = false;
	
	$postIdToCheck = dswcp_get_module_post_id();
	
	if ($postIdToCheck) {
		$allowed = get_post_meta($postIdToCheck, '_ags_wc_filters_allowed', true);
		$result = is_array($allowed) && in_array($filter, $allowed);
	}
	
	return apply_filters('dswcp_is_product_filter_allowed', $result, $filter);
}

function dscwp_ags_filters_get_count_attributes($postIdToCheck=null) {
	global $post;
	
	if ($postIdToCheck === null) {
		$postIdToCheck = dswcp_get_module_post_id();
	}
	
	if ($postIdToCheck) {
		$attributes = get_post_meta($postIdToCheck, '_ags_wc_filters_count_attributes', true);
		if (!empty($attributes)) {
			return $attributes;
		}
	}
	
	return [];
}

function dswcp_get_module_post_id() {
	global $post;
	$postIdToCheck = ET_Builder_Element::get_theme_builder_layout_id();
	if ( !$postIdToCheck && isset($post) ) {
		$postIdToCheck = $post->ID;
	}
	return $postIdToCheck;
}


function dswcp_ags_filters_maybe_add_full_icons($assets) {
	if ( ( dscwp_ags_filters_is_filter_allowed('shopRating') || et_core_is_fb_enabled() ) && isset($assets['et_icons_base']['css']) ) {
		$assets['et_icons_all'] = $assets['et_icons_base'];
		unset($assets['et_icons_base']);
		$assets['et_icons_all']['css'] = substr( $assets['et_icons_all']['css'], 0, strrpos($assets['et_icons_all']['css'], '/') ).'/icons_all.css';
	}
	return $assets;
}


function dscwp_ags_filters_shop_output($shopHtml, $orderClass) {
	remove_filter( 'term_link', 'dswcp_ags_filters_transform_category_urls', 10, 2 );
	remove_filter( 'term_links-product_cat', 'dswcp_ags_filters_transform_category_links' );
	
	// phpcs:ignore WordPress.Security.NonceVerification.Missing -- just a flag to enable some hooks
	if ( isset($_POST['ags_wc_filters_ajax_shop']) ) {
	
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- no persistent changes, just output control
		if ( $orderClass == $_POST['ags_wc_filters_ajax_shop'] ) {
			global $dswcp_ajax_notices_html, $dswcp_ajax_shop_html;
			
			if (!isset($dswcp_ajax_shop_html)) {
				$dswcp_ajax_shop_html = [];
			}
			
			$dswcp_ajax_shop_html[$orderClass] = $shopHtml;
			
			// phpcs:ignore WordPress.Security.NonceVerification.Missing -- no persistent changes, just output control
			if ( empty($_POST['ags_wc_filters_ajax_notices']) || ( isset($dswcp_ajax_notices_html) && count($dswcp_ajax_notices_html) == count($_POST['ags_wc_filters_ajax_notices']) ) ) {
				dswcp_ags_filters_ajax_output();
			}
		}
		return '';
	}
	
	return $shopHtml;
}

function dswcp_ags_filters_strip_unwanted_pagination_url_params($paginationArgs) {
	$baseUrl = $paginationArgs['base'];
	$queryStart = strrpos($baseUrl, '?');
	parse_str( substr($baseUrl, $queryStart + 1), $query );
	
	unset($query['add-to-cart']);
	
	$paginationArgs['base'] = substr($baseUrl, 0, $queryStart + 1).preg_replace( '/(shopPage[\\d]*\\=)%25%23%25/', '$1%#%', http_build_query($query) );
	
	return $paginationArgs;
}

function dswcp_ags_filters_transform_category_urls( $url, $categoryTerm ) {
	if ( $categoryTerm->taxonomy == 'product_cat' ) {
		return $url.'#agsWcCategoryFilter='.urlencode(add_query_arg('shopCategory', $categoryTerm->term_id));
	}
	return $url;
}

function dswcp_ags_filters_transform_category_links( $links ) {
	foreach ($links as &$link) {
		if (strpos($link, '#agsWcCategoryFilter=') !== false) {
			$link = str_replace('#agsWcCategoryFilter=', '" data-filter-url="', $link);
		}
	}
	
	return $links;
}

function dswcp_ags_filters_categories($query) {
	global $dswcp_query_vars;
	
	if (empty($query['tax_query'])) {
		$query['tax_query'] = [];
	} else {
		$query['tax_query']['relation'] = 'AND';
	}
	
	$query['tax_query'][] = [
		'taxonomy' => 'product_cat',
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended, ET.Sniffs.ValidatedSanitizedInput.InputNotValidated, ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized -- read-only operation; GET field existence is checked before this function is hooked; sanitized with absint function
		'terms' => array_map( 'absint', explode(',', $_GET[$dswcp_query_vars['shopCategory']]) )
	];
	
	return $query;
}

function dswcp_ags_filters_tags($query) {
	global $dswcp_query_vars;
	
	if (empty($query['tax_query'])) {
		$query['tax_query'] = [];
	} else {
		$query['tax_query']['relation'] = 'AND';
	}
	
	$query['tax_query'][] = [
		'taxonomy' => 'product_tag',
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended, ET.Sniffs.ValidatedSanitizedInput.InputNotValidated, ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized -- read-only operation; GET field existence is checked before this function is hooked; sanitized with absint function
		'terms' => array_map( 'absint', explode(',', $_GET[$dswcp_query_vars['shopTag']]) )
	];
	
	return $query;
}

function dswcp_ags_filters_search($query) {
	global $dswcp_query_vars;
	
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended, ET.Sniffs.ValidatedSanitizedInput.InputNotValidated -- read-only operation; GET field existence is checked before this function is hooked
	$query['s'] = sanitize_text_field($_GET[$dswcp_query_vars['shopSearch']]);
	return $query;
}

function dswcp_ags_filters_search_sql_filtering($sql) {
	global $dswcp_query_vars;
	// phpcs:ignore ET.Sniffs.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.NonceVerification.Recommended -- GET field existence is checked before this function is hooked; read-only operation
	return dswcp_ags_filters_search_sql($sql, sanitize_text_field($_GET[$dswcp_query_vars['shopSearch']]));
}

function dswcp_ags_filters_search_sql_suggesting($sql) {
	// phpcs:ignore ET.Sniffs.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.NonceVerification.Missing -- POST field existence is checked before this function is hooked; read-only operation
	return dswcp_ags_filters_search_sql($sql, sanitize_text_field($_POST['query']));
}


function dswcp_ags_filters_search_sql($sql, $search) {
	global $wpdb;
	if ($sql) {
		$sql = trim($sql);
		if (substr($sql, -2) == '))') {
			$sql = substr($sql, 0, -1)
					.$wpdb->prepare(' OR EXISTS (SELECT 1 FROM '.$wpdb->postmeta.' pm_sku WHERE pm_sku.post_id='.$wpdb->posts.'.ID AND pm_sku.meta_key="_sku" AND LOWER(pm_sku.meta_value)=%s)', strtolower($search))
					.')';
		}
		$sql = ' '.$sql.' ';
	}
	
	return $sql;
}

function dswcp_ags_filters_rating($query) {
	global $dswcp_query_vars;
	
	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only operation
	
	if (empty($query['meta_query'])) {
		$query['meta_query'] = [];
	} else {
		$query['meta_query']['relation'] = 'AND';
	}
	
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended, ET.Sniffs.ValidatedSanitizedInput.InputNotValidated -- read-only operation; GET field existence is checked before this function is hooked
	$filterValue = sanitize_text_field($_GET[$dswcp_query_vars['shopRating']]);
	
	// phpcs:ignore ET.Sniffs.ValidatedSanitizedInput.InputNotValidated, ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized -- GET field existence is checked before this function is hooked; checking input right here
	if ( strlen($filterValue) == 2 && (int) $filterValue[0] >= 1 && (int) $filterValue[0] <= 5 && $filterValue[1] == '+' ) {
		// phpcs:ignore ET.Sniffs.ValidatedSanitizedInput.InputNotValidated -- GET field existence is checked before this function is hooked
		$value = (int) $filterValue[0];
		
		if (!empty($value)) {
			$query['meta_query'][] = [
				'key' => '_wc_average_rating',
				'value' => $value,
				'compare' => '>=',
				'type' => 'DECIMAL(20,2)'
			];
		}
	} else {
		$compare = 'IN';
		$value = array_filter(
					// phpcs:ignore ET.Sniffs.ValidatedSanitizedInput.InputNotValidated, ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized -- GET field existence is checked before this function is hooked; sanitized by absint()
					array_map('absint', explode(',', $filterValue)),
					function($value) {
						return $value >= 1 && $value <= 5;
					}
		);
		
		$ratingSubQuery = [];
		
		foreach ($value as $singleValue) {
			$ratingSubQuery[] = [
				[
					'key' => '_wc_average_rating',
					'value' => $singleValue,
					'compare' => '>=',
					'type' => 'DECIMAL(20,2)'
				],
				[
					'key' => '_wc_average_rating',
					'value' => $singleValue + 1,
					'compare' => '<',
					'type' => 'DECIMAL(20,2)'
				],
				'relation' => 'AND'
			];
		}
		
		if ($ratingSubQuery) {
			if (count($ratingSubQuery) > 1) {
				$ratingSubQuery['relation'] = 'OR';
			}
			$query['meta_query'][] = $ratingSubQuery;
		}
		
	}
	
	return $query;
	// phpcs:enable WordPress.Security.NonceVerification.Recommended
}

function dswcp_ags_filters_price($query) {
	global $dswcp_query_vars;
	
	if (empty($query['meta_query'])) {
		$query['meta_query'] = [];
	} else {
		$query['meta_query']['relation'] = 'AND';
	}
	
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended, ET.Sniffs.ValidatedSanitizedInput.InputNotValidated, ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized -- read-only operation; GET field existence is checked before this function is hooked; input parts will be sanitized via (int) casts below
	$values = explode('-', $_GET[$dswcp_query_vars['shopPrice']]);
	
	if (strlen($values[0])) {
		$query['meta_query'][] = [
			'key' => '_price',
			'value' => (int) $values[0],
			'compare' => '>=',
			'type' => 'DECIMAL(20,2)'
		];
	}
	
	if (strlen($values[1])) {
		$query['meta_query'][] = [
			'key' => '_price',
			'value' => (int) $values[1],
			'compare' => '<=',
			'type' => 'DECIMAL(20,2)'
		];
	}
	
	return $query;
}

function dswcp_ags_filters_stock_status($query) {
	global $dswcp_query_vars;
	if (empty($query['meta_query'])) {
		$query['meta_query'] = [];
	} else {
		$query['meta_query']['relation'] = 'AND';
	}
	
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended, ET.Sniffs.ValidatedSanitizedInput.InputNotValidated, ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized -- read-only operation; GET field existence is checked before this function is hooked; array is sanitized
	$values = array_map('sanitize_text_field', explode(',', $_GET[$dswcp_query_vars['shopStockStatus']]));
	
	if ($values) {
		$query['meta_query'][] = [
			'key' => '_stock_status',
			'value' => $values
		];
	}
	
	return $query;
}

function dswcp_get_active_attribute_filters() {
	global $dswcp_query_vars;
	
	$activeFilters = [];
	
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- filtering is a non-persistent operation
	foreach ($_GET as $field => $value) {
		if (preg_match('/^'.implode('(.+)', array_map('preg_quote', explode('%s', $dswcp_query_vars['shopAttribute']))).'$/', $field, $result) && dscwp_ags_filters_is_filter_allowed('shopAttribute_'.$result[1])) {
			$activeFilters[ $result[1] ] = $value;
		}
	}
	
	return $activeFilters;
}

function dswcp_ags_filters_attributes($query) {
	global $dswcp_active_attribute_filters;
	$dswcp_active_attribute_filters = dswcp_get_active_attribute_filters();
	
	foreach ($dswcp_active_attribute_filters as $attribute => $value) {
	
		if (empty($query['tax_query'])) {
			$query['tax_query'] = [];
		} else {
			$query['tax_query']['relation'] = 'AND';
		}
		
		if (strpos($value, '-') !== false) {
			$termsArgs = [
				'fields' => 'ids',
				'taxonomy' => $attribute,
				'meta_query' => [
					[
						'key' => '_dswcp_filter_number',
						'type' => 'DECIMAL'
					]
				]
			];
			
			list($min, $max) = explode('-', $value);
			if ($min === '') {
				$termsArgs['meta_query'][0]['compare'] = '<=';
				$termsArgs['meta_query'][0]['value'] = (float) $max;
			} else if ($max === '') {
				$termsArgs['meta_query'][0]['compare'] = '>=';
				$termsArgs['meta_query'][0]['value'] = (float) $min;
			} else {
				$termsArgs['meta_query'][0]['compare'] = 'BETWEEN';
				$termsArgs['meta_query'][0]['value'] = [(float) $min, (float) $max];
			}
			
			$terms = get_terms($termsArgs);
			
		} else {
			$terms = array_map( 'absint', explode(',', $value) );
		}
		
		$query['tax_query'][] = [
			'taxonomy' => $attribute,
			'terms' => $terms
		];
	}
	
	return $query;
}

function dswcp_ags_filters_taxonomy($query) {
	global $dswcp_query_vars;
	
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- filtering is non-persistent
	foreach ($_GET as $field => $value) {
		
		if (preg_match('/^'.implode('(.+)', array_map('preg_quote', explode('%s', $dswcp_query_vars['shopTaxonomy']))).'$/', $field, $result) && dscwp_ags_filters_is_filter_allowed('shopTaxonomy_'.$result[1])) {
			if (empty($query['tax_query'])) {
				$query['tax_query'] = [];
			} else {
				$query['tax_query']['relation'] = 'AND';
			}
			
			$query['tax_query'][] = [
				'taxonomy' => $result[1],
				'terms' => array_map( 'absint', explode(',', $value) )
			];
		}
	}
	
	return $query;
}


function dswcp_ags_filters_search_suggestions() {
	// phpcs:ignore WordPress.Security.NonceVerification.Missing -- read-only operation
	if (!empty($_POST['query'])) {
		
		add_filter('posts_search', 'dswcp_ags_filters_search_sql_suggesting');
		$products = get_posts([
			'post_type' => 'product',
			// phpcs:ignore WordPress.Security.NonceVerification.Missing -- read-only operation
			's' => sanitize_text_field($_POST['query']),
			'posts_per_page' => 5,
		]);
		remove_filter('posts_search', 'dswcp_ags_filters_search_sql_suggesting');
		
		$result = [];
		foreach ($products as $product) {
			$result[] = [
				'label' => $product->post_title,
				'link' => get_permalink($product->ID)
			];
		}
		
		wp_send_json_success($result);
	}
	
	wp_send_json_error();
}

function dswcp_capture_query_vars($props, $attrs, $moduleSlug) {
	if ($moduleSlug == 'ags_woo_shop_plus') {
		global $dswcp_query_vars;
		
		$dswcp_query_vars = [
			'shopCategory' => null,
			'shopTag' => null,
			'shopAttribute' => null,
			'shopTaxonomy' => null,
			'shopSearch' => null,
			'shopRating' => null,
			'shopPrice' => null,
			'shopStockStatus' => null,
			'shopSale' => null,
			'shopOrder' => null
		];
		
		foreach ($dswcp_query_vars as $queryVar => &$value) {
			$queryVarLc = strtolower($queryVar);
			$value = empty($attrs['query_var_'.$queryVarLc])
				? ($queryVar == 'shopAttribute' || $queryVar == 'shopTaxonomy' ? $queryVar.'_%s' : $queryVar)
				: $attrs['query_var_'.$queryVarLc];
		}
	}
	
	return $props;
}
add_filter('et_pb_module_shortcode_attributes', 'dswcp_capture_query_vars', 10, 3);

function dswcp_get_product_taxonomies() {
	global $wpdb;
	static $taxonomies;
	
	if (!isset($taxonomies)) {
		$taxonomies = $wpdb->get_col(
			'SELECT DISTINCT taxonomy FROM '.$wpdb->term_taxonomy.'
			JOIN '.$wpdb->term_relationships.' USING (term_taxonomy_id)
			JOIN '.$wpdb->posts.' ON ID=object_id
			WHERE post_type="product"'
		);
	}
		
	return $taxonomies;
}


class AGS_WC_Filters_Sale_Filter {
	
	private $page, $pageLength, $result = [], $query;
	
	function __construct() {
		add_filter( 'woocommerce_shortcode_products_query', [$this, 'filterQuery'], 99 );
		add_filter( 'woocommerce_shortcode_products_query_results', [$this, 'filterResult'] );
	}

	function unhook() {
		remove_filter( 'woocommerce_shortcode_products_query', [$this, 'filterQuery'], 99 );
		remove_filter( 'woocommerce_shortcode_products_query_results', [$this, 'filterResult'] );
	}
	
	function filterQuery($query) {
		
		$this->page = isset($query['paged']) ? $query['paged'] : 1;
		$this->pageLength = $query['posts_per_page'];
		
		$query['paged'] = 1;
		$query['fields'] = 'ids';
		
		// Performance optimization - can only apply if any existing meta query uses the AND relation implicitly or explicitly, and if nothing is hooked that might change on sale status
		if ((empty($query['meta_query']['relation']) || !strcasecmp($query['meta_query']['relation'], 'AND')) && !has_filter('woocommerce_product_is_on_sale')) {
			if (empty($query['meta_query'])) {
				$query['meta_query'] = [];
			} else {
				$query['meta_query']['relation'] = 'AND';
			}
			$query['meta_query'][] = [
				'key' => '_sale_price',
				'value' => '',
				'compare' => '!='
			];
		}
		
		$this->query = $query;
		
		return $query;
	}
	
	function filterResult($result) {
		$ids = $result->ids;
		
		while ( $this->processResult($ids) ) {
			++$this->query['paged'];
			$ids = get_posts($this->query);
		}
		
		$result->ids = array_slice($this->result, ($this->page - 1) * $this->pageLength, $this->pageLength);
		$result->total = count($this->result);
		$result->total_pages = ceil( $result->total / $this->pageLength );
		
		return $result;
	}
	
	// true = need more results; false = done
	function processResult($result) {
		if (!$result) {
			return false;
		}
		
		foreach ($result as $productId) {
			$product = wc_get_product($productId);
			if ($product && $product->is_on_sale()) {
				$this->result[] = $productId;
			}
		}
		
		if (count($result) < $this->pageLength) {
			return false;
		}
		
		return true;
	}
	
}
