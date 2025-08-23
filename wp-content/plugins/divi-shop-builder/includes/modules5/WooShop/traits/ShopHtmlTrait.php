<?php
namespace WPZone\DiviShopBuilder\Modules\WooShopModule\Traits;

defined('ABSPATH') || exit;

trait ShopHtmlTrait {
	
	function get_shop( $args = array(), $conditional_tags = array(), $current_page = array() ) {
		
		$orderClass = isset($args['_order_class']) ? $args['_order_class'] : $this->get_module_order_class($this->slug);
		
		if ( !apply_filters( 'ags_woo_shop_plus_before_print_shop', true, $this->props, $orderClass ) ) {
			return;
		}
		
		global $dswcp_query_vars;

		foreach ( $args as $arg => $value ) {
			$this->props[ $arg ] = $value;
		}
		
		$renderCount = method_exists($this, 'render_count') ? $this->render_count() : (int) substr(strstr($orderClass, '_'), 1) + 1;
		
		$shopOrderVar = $dswcp_query_vars['shopOrder'].($renderCount ? $renderCount + 1 : '');

		$props 			   = wp_parse_args( array( 'layout' => $this->props['layout'] === 'both' ? 'grid' : $this->props['layout']  ), $this->props );
		$agsImplementation = new \AGS_Divi_WC_Implementation('module', $props, $this);
		$agsImplementation->implement();

		$post_id            = isset( $current_page['id'] ) ? (int) $current_page['id'] : 0;
		$type               = 'on' === $this->props['use_current_loop'] ? '' : $this->props['type'];
		$layout             = empty($this->props['layout']) ? 'grid' : $this->props['layout'];
		$posts_number       = $this->props['posts_number'];
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- shop order is non-persistent
		if (isset($_GET[$shopOrderVar]) && $_GET[$shopOrderVar] != 'menu_order') {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- shop order is non-persistent
			$orderbyQs = sanitize_text_field($_GET[$shopOrderVar]);
		}
		if (!isset($orderbyQs)) {
			$orderby        = $this->props['orderby'];
		} else if ($orderbyQs == 'date') {
			$orderby = 'date-desc';
		} else {
			$orderby = $orderbyQs;
		}
		$order              = 'ASC';
		$product_categories = array();
		$use_current_loop   = 'on' === $this->props['use_current_loop'];
		$use_current_loop   = $use_current_loop && ( is_post_type_archive( 'product' ) || is_search() || et_is_product_taxonomy() );
		$product_attribute  = '';
		$product_terms      = array();

		if ( $use_current_loop ) {

			if ( is_product_category() ) {
				$product_categories = [(int) get_queried_object_id()];
			} elseif ( is_product_tag() ) {
				$product_tags = array( get_queried_object()->slug );
			} elseif ( is_product_taxonomy() ) {
				$term = get_queried_object();

				$custom_taxonomy = $term->taxonomy;
				$custom_taxonomy_terms[]   = $term->term_id;
			} else if ( is_search() ) {
				add_filter('woocommerce_shortcode_products_query', [__CLASS__, 'add_search_to_products_query']);
			}
		} else if ('product_category' == $type) {
			$product_categories = $this->props['include_categories'] ? array_map('absint', explode(',', $this->props['include_categories'])) : [];
		} else if ('product_tag' == $type) {
			$product_tags = $this->props['include_tags'] ? array_map('absint', explode(',', $this->props['include_tags'])) : [];
			$product_tags_field = 'term_id';
		} 

		/*
		if ( 'product_category' === $type || ( $use_current_loop && is_product_category() ) ) {
			$all_shop_categories     = et_builder_get_shop_categories();
			$all_shop_categories_map = array();
			$raw_product_categories  = self::filter_include_categories( $this->props['include_categories'], $post_id, 'product_cat' );

			foreach ( $all_shop_categories as $term ) {
				if ( is_object( $term ) && is_a( $term, 'WP_Term' ) ) {
					$all_shop_categories_map[ $term->term_id ] = $term->slug;
				}
			}

			$product_categories = array_values( $all_shop_categories_map );

			if ( ! empty( $raw_product_categories ) ) {
				$product_categories = array_intersect_key(
					$all_shop_categories_map,
					array_flip( $raw_product_categories )
				);
			}
		}
		*/

		if ( 'default' === $orderby ) {
			// Leave the attribute empty to allow WooCommerce to take over and use the default sorting.
			$orderby = '';
		}
		
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- shop order is non-persistent
		if ( 'latest' === $type && !isset($orderbyQs) ) {
			$orderby = 'date-desc';
		}

		if ( in_array( $orderby, array( 'price-desc', 'date-desc' ) ) ) {
			// Supported orderby arguments (as defined by WC_Query->get_catalog_ordering_args() ):
			// rand | date | price | popularity | rating | title
			$orderby = str_replace( '-desc', '', $orderby );
			// Switch to descending order if orderby is 'price-desc' or 'date-desc'
			$order = 'DESC';
		} else if (in_array($orderby, ['popularity', 'rating'])) {
			$order = 'DESC';
		}

		$wc_custom_view  = '';
		$wc_custom_views = array(
			'sale'         => array( 'on_sale', 'true' ),
			'best_selling' => array( 'best_selling', 'true' ),
			'top_rated'    => array( 'top_rated', 'true' ),
			'featured'     => array( 'visibility', 'featured' ),
		);

		$classes = apply_filters('ags_divi_wc_module_shop_classes', []);

		$shortcodeArgs = [
			'paginate' => true,
			'cache' => false,
			'limit' => (int) $posts_number,
			'orderby' => $orderby,
			'order' => $order,
		];
		
		if ( et_()->includes( array_keys( $wc_custom_views ), $type ) ) {
			$custom_view_data = $wc_custom_views[ $type ];
			$shortcodeArgs[$custom_view_data[0]] = $custom_view_data[1];
		}
		
		if ($product_categories) {
			$shortcodeArgs['category'] = implode( ',', $product_categories );
		} else if (isset($product_tags)) {
			$shortcodeArgs['tag'] = implode( ',', $product_tags );
			if (isset($product_tags_field)) {
				$shortcodeArgs['tag_field'] = $product_tags_field;
			}
		} else if (isset($custom_taxonomy)) {
			$shortcodeArgs['custom_taxonomy'] = $custom_taxonomy;
			$shortcodeArgs['custom_taxonomy_terms'] = $custom_taxonomy_terms;
		}
		
		if ($classes) {
			$shortcodeArgs['class'] = implode( ' ', $classes );
		}
		
		if ($layout == 'list') {
			$shortcodeArgs['columns'] = 1;
		}
		
		$shortcodeArgs = apply_filters('dswcp_woo_shop_shortcode_args', $shortcodeArgs, $this->props, $type, 'shop');

		$this->setup_pagination();

		do_action( 'et_pb_shop_before_print_shop' );

		if ( isset($this->props['filter_target']) && $this->props['filter_target'] == 'on' ) {
			add_filter('posts_clauses', [$this, 'getPriceRange']);
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- shop order is non-persistent
		if (isset($orderbyQs)) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- shop order is non-persistent
			if (isset($_GET['orderby'])) {
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- shop order is non-persistent
				$prevOrderBy = sanitize_text_field($_GET['orderby']);
			}
			$_GET['orderby'] = $orderbyQs;
		}
		
		require_once(__DIR__.'/shortcode.php');
		
		if ( !empty($shortcodeArgs['on_sale']) ) {
			$shortcodeType = 'sale_products';
		} else if ( !empty($shortcodeArgs['best_selling']) ) {
			$shortcodeType = 'best_selling_products';
		} else if ( !empty($shortcodeArgs['top_rated']) ) {
			$shortcodeType = 'top_rated_products';
		} else {
			$shortcodeType = 'products';
		}
		
		$shop = (new \DSWCP_Shortcode_Products($shortcodeArgs, $shortcodeType))->get_content();
		
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- shop order is non-persistent
		if (isset($orderbyQs)) {
			if (isset($prevOrderBy)) {
				$_GET['orderby'] = $prevOrderBy;
			} else {
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- shop order is non-persistent
				unset($_GET['orderby']);
			}
		}
		
		if ( isset($this->props['filter_target']) && $this->props['filter_target'] == 'on' ) {
			remove_filter('posts_clauses', [$this, 'getPriceRange']);
		}
		
		remove_filter('woocommerce_shortcode_products_query', [__CLASS__, 'add_search_to_products_query']);

		if( $layout === 'both' ){

			$agsImplementation->deimplement();

			$agsImplementationNew = new \AGS_Divi_WC_Implementation('module', wp_parse_args( [ 'layout' => 'list' ], $this->props ), $this);
			$agsImplementationNew->implement();
			
			$shortcodeArgs['class'] = implode( ' ', apply_filters('ags_divi_wc_module_shop_classes', []) );

			$shop .= (new \DSWCP_Shortcode_Products($shortcodeArgs))->get_content();

			$shop = $this->get_multiview_actions() . $this->get_processed_shop($shop);

			$agsImplementationNew->deimplement();

			$agsImplementation->implement();
		}
		
		do_action( 'ags_woo_shop_plus_after_print_shop' );
		do_action( 'et_pb_shop_after_print_shop' );

		$this->unset_pagination();

		$is_shop_empty = preg_match( '/<div class="woocommerce columns-([0-9 ]+)"><\/div>+/', $shop );

		if ( $is_shop_empty ) {
			$shop = self::get_no_results_template();
		}

		$agsImplementation->deimplement();
		
		return apply_filters('ags_woo_shop_html', $shop, $orderClass);
	}

	/**
	 * Get shop HTML for shop module
	 *
	 * @param array   arguments that affect shop output
	 * @param array   passed conditional tag for update process
	 * @param array   passed current page params
	 * @return string HTML markup for shop module
	 */
	static function get_shop_html( $args = array(), $conditional_tags = array(), $current_page = array() ) {
		$shop = new self();

		do_action( 'et_pb_get_shop_html_before' );

		$shop->props = $args;

		// Force product loop to have 'product' class name. It appears that 'product' class disappears
		// when $this->get_shop() is being called for update / from admin-ajax.php
		add_filter( 'post_class', array( $shop, 'add_product_class_name' ) );

		// Get product HTML
		$output = $shop->get_shop(
			class_exists('ET\Builder\Packages\ModuleUtils\ModuleUtils')
				? array('_order_class' => \ET\Builder\Packages\ModuleUtils\ModuleUtils::get_module_order_class_name('wpzone/agswooshopplus'))
				: [],
		array(), $current_page );

		// Remove 'product' class addition to product loop's post class
		remove_filter( 'post_class', array( $shop, 'add_product_class_name' ) );

		do_action( 'et_pb_get_shop_html_after' );

		return $output;
	}
	

	/**
	 * Setup pagination overrides
	 *
	 */
	private function setup_pagination(){
		add_filter( 'woocommerce_pagination_args', array( $this, 'set_products_pagination_args' ), 99, 1 );
		add_filter( 'woocommerce_shortcode_products_query', array( $this, 'set_products_query' ), 99, 3 );
	}


	/**
	 * Remove pagination overrides
	 *
	 */
	private function unset_pagination(){
		remove_filter( 'woocommerce_pagination_args', array( $this, 'set_products_pagination_args' ), 99 );
		remove_filter( 'woocommerce_shortcode_products_query', array( $this, 'set_products_query' ), 99 );
	}


	/**
	 * Filter the pagination args based on instance
	 *
	 * @return Array
	 */
	public function set_products_pagination_args( $args ){

		global $wp_query;

		$query_array 		 = array();
		$index 				 = $this->render_count();
		$pageVar			 = 'shopPage'.($index ? $index + 1 : '');
		
		// phpcs:disable WordPress.Security.NonceVerification -- read-only use of paging request info
		if ( isset( $_GET[ $pageVar ] ) ) {
			$args['current'] =  max( 1, (int) $_GET[ $pageVar ] );
		} else if( isset( $_GET['dsb-product-page'][$index]['page']) ){ // backwards compatibility
			$args['current'] =  max( 1, (int) $_GET['dsb-product-page'][$index]['page'] );
		}
		// phpcs:enable WordPress.Security.NonceVerification

		
		$args['base'] = esc_url_raw(
			add_query_arg(
				$pageVar,
				'%#%'
			)
		);

		return $args;
	}

	/**
	 * Filter the product query based on instance
	 *
	 * @return Array
	 */
	public function set_products_query( $query, $attributes, $type ){
		
		$index = method_exists($this, 'render_count') ? $this->render_count() : (int) substr(strstr($orderClass, '_'), 1) + 1;
		
		// phpcs:disable WordPress.Security.NonceVerification -- read-only use of paging request info
		$pageVar = 'shopPage'.($index ? $index + 1 : '');
		
		if ( isset( $_GET[ $pageVar ] ) ) {
			$query['paged'] =  max( 1, (int) $_GET[ $pageVar ] );
		} else if( isset( $_GET['dsb-product-page'][$index]['page'] ) ){ // backwards compatibility
			$query['paged'] =  max( 1, (int) $_GET['dsb-product-page'][$index]['page'] );
		}
		// phpcs:enable WordPress.Security.NonceVerification

		return $query;
	}

	function add_product_class_name( $classes ) {
		$classes[] = 'product';

		return $classes;
	}
	
	static function add_search_to_products_query($queryParams) {
		$queryParams['s'] = get_query_var('s');
		return $queryParams;
	}

	private function get_processed_shop( $shop ){
		$dom 		  = new \simplehtmldom\HtmlDocument();
		$content_html = $dom->load( $shop );
		$default_view = $this->get_default_multi_view();

		foreach( $content_html->find('.ags-divi-wc-layout-grid, .ags-divi-wc-layout-list') as $view ){ //[class^='ags-divi-wc-layout-'] doesnt work here
			if( strpos( $view->getAttribute('class'), 'ags-divi-wc-layout-'.$default_view ) === false ){
				$view->setAttribute( 'style', 'display:none;' );
			}
		}

		return $content_html->outertext;
	}
	
	private function get_multiview_actions(){
		$default_view = $this->get_default_multi_view();
		$views 		  = array( 'grid', 'list' );

		$actions = '<div class="ags_woo_shop_plus_multiview">';
		foreach( $views as $view ){
			$actions .= sprintf( '<button class="%s-view %s"></button>', $view, $view === $default_view ? 'active' : '' );
		}
		$actions .= '</div>';

		return $actions;
	}
	
	
	private function get_default_multi_view(){
		$post_id 	 = apply_filters( 'et_is_ab_testing_active_post_id', get_the_ID() ); // Divi page id
		$cookie_name = 'ags_woo_shop_plus_'.$post_id.'_'.( $this->render_count() );
		// phpcs:ignore ET.Sniffs.ValidatedSanitizedInput.InputNotSanitized -- sanitization occurs via in_array() check below
		$cookie 	 = !empty( $_COOKIE[$cookie_name] ) ? $_COOKIE[$cookie_name] : '';

		return in_array( $cookie, array( 'grid', 'list' ) ) ?
				$cookie :
				( !empty( $this->props['deafault_view'] ) ? $this->props['deafault_view'] : 'grid' );
	}
	
	public function getPriceRange($sqlParts) {
		global $wpdb;
		
		$priceQuerySqlParts = $sqlParts;
		$priceQuerySqlParts['join'] .= ' JOIN '.$wpdb->postmeta.' AS agsdwc_meta_price ON(agsdwc_meta_price.post_id='.$wpdb->posts.'.ID AND agsdwc_meta_price.meta_key="_price")';
		$priceQuerySqlParts['where'] = preg_replace('/\\(\\s*\\(\\s*[^\\s\\.]+\\.meta_key\\s*\\=\\s*[\'"]_price[\'"].*\\)\\s*\\)/U',
													'(TRUE OR $0)',
													str_replace(["\n", "\r"], ' ', $priceQuerySqlParts['where'])
		); // this should remove any price filtering
		
		$results = $wpdb->get_row('SELECT MIN(CAST(agsdwc_meta_price.meta_value AS SIGNED)) AS minPrice, MAX(CAST(agsdwc_meta_price.meta_value AS SIGNED)) AS maxPrice
									FROM '.$wpdb->posts.' '
									// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared -- constructing query from SQL parts created by WordPress
									.$priceQuerySqlParts['join']
									// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared -- constructing query from SQL parts created by WordPress
									.' WHERE 1=1 '.$priceQuerySqlParts['where'],
		ARRAY_N);
		
		list($this->minPrice, $this->maxPrice) = $results ? $results : [null, null];
		
		add_action('woocommerce_shortcode_before_products_loop', [$this, 'outputPriceRange']);
		add_action('woocommerce_shortcode_products_loop_no_results', [$this, 'outputPriceRange']);
		
		return $sqlParts;
	}
	
	public function outputPriceRange() {
		echo('<span class="ags-divi-wc-query-price-range" data-min="'.((float) $this->minPrice).'" data-max="'.((float) $this->maxPrice).'"></span>');
		remove_action('woocommerce_shortcode_before_products_loop', [$this, 'outputPriceRange']);
		remove_action('woocommerce_shortcode_products_loop_no_results', [$this, 'outputPriceRange']);
		$this->minPrice = null;
		$this->maxPrice = null;
	}
	
}