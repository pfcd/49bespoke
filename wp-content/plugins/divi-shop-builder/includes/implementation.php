<?php

class AGS_Divi_WC_Implementation {

	private static $contexts = [
		'page' => [

		],
		'module' => [
			'body_class' => 'ags_divi_wc_module_shop_classes'
		]
	];
	private $options, $contextMap, $filtersAdd, $filtersRemove, $actionsAdd, $actionsRemove, $columnNumber, $module;

	function __construct($context, $options, $module = null) {

		if ( !isset( self::$contexts[ $context ] ) ) {
			throw new Exception( esc_html__( 'The specified context is invalid.', 'divi-shop-builder' ) );
		}
		$this->contextMap = self::$contexts[ $context ];
		$this->options = $this->normalize_options($options);
		$this->module = $module;

	}

	function normalize_options($options) {
		global $ags_divi_wc;
		$settingDefs = $ags_divi_wc->get_settings();

		foreach ($options as $optionId => &$optionValue) {
			if ( isset( $settingDefs[$optionId] ) ) {
				switch ( $settingDefs[$optionId]['type'] ) {
					case 'checkbox':
						$optionValue = ($optionValue === 'on' || $optionValue === true);
						break;
				}
			}
		}

		return $options;
	}

	function implement() {

		// Clear everything
		$this->filtersAdd = [];
		$this->filtersRemove = [];
		$this->actionsAdd = [];
		$this->actionsRemove = [];

		// Build the customizations
		$this->ags_divi_wc_fire_customisations();

		// Add and remove hooks
		foreach ($this->filtersAdd as $filter) {
			call_user_func_array('add_filter', $filter);
		}
		foreach ($this->filtersRemove as &$filter) {
			if ( !call_user_func_array('remove_filter', $filter) ) {
				$filter = false;
			}
		}
		foreach ($this->actionsRemove as &$action) {
			if ( !call_user_func_array('remove_action', $action) ) {
				$action = false;
			}
		}
		foreach ($this->actionsAdd as $action) {
			call_user_func_array('add_action', $action);
		}

	}

	function deimplement() {

		// Add and remove hooks (reverse)
		foreach ($this->filtersAdd as $filter) {
			call_user_func_array('remove_filter', $filter);
		}
		foreach ($this->filtersRemove as $filter) {
			if ($filter) {
				call_user_func_array('add_filter', $filter);
			}
		}
		foreach ($this->actionsAdd as $action) {
			call_user_func_array('remove_action', $action);
		}
		foreach ($this->actionsRemove as $action) {
			if ($action) {
				call_user_func_array('add_action', $action);
			}
		}

	}

	function addAction($hook) {
		$action = func_get_args();
		if (isset($this->contextMap[$hook])) {
			$action[0] = $this->contextMap[$hook];
		}
		$this->actionsAdd[] = $action;
	}

	function removeAction($hook) {
		$action = func_get_args();
		if (isset($this->contextMap[$hook])) {
			$action[0] = $this->contextMap[$hook];
		}
		$this->actionsRemove[] = $action;
	}

	function removeAllActions($hook) {
		if (isset($this->contextMap[$hook])) {
			$hook = $this->contextMap[$hook];
		}

		global $wp_filter;
		if ( isset( $wp_filter[$hook] ) ) {
			foreach ( $wp_filter[$hook] as $priority => $actions ) {
				foreach ( $actions as $action ) {
					$this->actionsRemove[] = [
						$hook,
						$action['function'],
						$priority,
						$action['accepted_args']
					];
				}
			}
		}

	}

	function addFilter($hook) {
		$filter = func_get_args();
		if (isset($this->contextMap[$hook])) {
			$filter[0] = $this->contextMap[$hook];
		}
		$this->filtersAdd[] = $filter;
	}

	function removeFilter($hook) {
		$filter = func_get_args();
		if (isset($this->contextMap[$hook])) {
			$filter[0] = $this->contextMap[$hook];
		}
		$this->filtersRemove[] = $filter;
	}

	function ags_divi_wc_loop_product_image_flip() {
		global $product;
		
		$gallery = $product->get_gallery_image_ids();

		woocommerce_template_loop_product_link_open();

		if (count($gallery)) {

			// Product has more than one image
			$imageFlipStyle = isset( $this->options['image_flip_style'] ) ? $this->options['image_flip_style'] : 'transition';

            echo('<span class="ags-divi-wc-image-flip ags-divi-wc-image-flip-' . esc_attr($imageFlipStyle). '"><span class="et_shop_image"><span class="ags-divi-wc-image-flip-inner">');

			echo et_core_intentionally_unescaped(woocommerce_get_product_thumbnail(), 'html');
			echo wp_get_attachment_image($gallery[0], apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' ));

			echo('</span></span></span>');

		} else {
			// Product has only one image or none
			woocommerce_template_loop_product_thumbnail();
		}
		woocommerce_template_loop_product_link_close();
	}


	/**
	 * Action our customisations
	 *
	 * @return void
	 */
	function ags_divi_wc_fire_customisations()
	{

		// Classes
		$this->addFilter( 'body_class', array( $this, 'ags_divi_wc_fire_customisation_styles' ) );

		// Columns
		$this->addFilter( 'loop_shop_columns', array( $this, 'ags_divi_wc_products_row' ) );

		// Remove filters from Divi and Divi Ecommerce Child Theme
		$this->removeFilter( 'loop_shop_columns', 'et_modify_shop_page_columns_num', 20 );

		// No products found
		$this->addAction( 'woocommerce_shortcode_products_loop_no_results', [ $this, 'ags_divi_wc_no_products_found' ] );

		// Result Count.
		if ( isset( $this->options['product_count'] ) ) {

			if ( $this->options['product_count'] === 'hide' || $this->options['product_count'] === 'below' ) {
				$this->removeAction( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			}

			if ( $this->options['product_count'] === 'below' || $this->options['product_count'] === 'abovebelow' ) {
				$this->addAction( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
			}

		}

		// Product Ordering.
		if ( isset( $this->options['product_sorting'] ) ) {

			if ( $this->options['product_sorting'] === 'hide' || $this->options['product_sorting'] === 'below' ) {
				$this->removeAction( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}

			if ( $this->options['product_sorting'] === 'below' || $this->options['product_sorting'] === 'abovebelow' ) {
				$this->addAction( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}
		}

		// Pagination.
		if ( isset( $this->options['pagination'] ) ) {

			if ( $this->options['pagination'] === 'hide' || $this->options['pagination'] === 'above' ) {
				$this->removeAction( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
			}

			if ( $this->options['pagination'] === 'above' || $this->options['pagination'] === 'abovebelow' ) {
				$this->addAction( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 10 );
			}
		}
		
		if (isset($this->options['filtered_variation_image']) && $this->options['filtered_variation_image'] === 'on') {
			$this->addFilter( 'woocommerce_product_get_image', [$this, 'filter_product_image'], 10, 5 );
		}
		
		// Image flip
		$hasImageFlip = isset( $this->options['image_flip'] ) && $this->options['image_flip'] === 'on';

		/** Definitions **/
		$itemActions = apply_filters('dswcp_woo_shop_item_actions', array(
			'sale-badge'   => [
				[ array( $this, 'ags_divi_wc_show_product_loop_sale_badge' ) ]
			],
			'percentage-sale-badge'   => [
				[ array( $this, 'ags_divi_wc_show_product_loop_percentage_sale_badge' ) ]
			],
			'new-badge'   => [
				[ array( $this, 'ags_divi_wc_show_product_loop_new_badge' ) ]
			],
			'image' => $hasImageFlip
				? [ [ [$this, 'ags_divi_wc_loop_product_image_flip'] ] ]
				: [
					[ 'woocommerce_template_loop_product_link_open' ],
					[ 'woocommerce_template_loop_product_thumbnail' ],
					[ 'woocommerce_template_loop_product_link_close' ]
				],
			// woocommerce\includes\wc-template-hooks.php
			'title'          => [
				[ 'woocommerce_template_loop_product_link_open' ],
				['woocommerce_template_loop_product_title'],
				[ 'woocommerce_template_loop_product_link_close' ]
			],
			'sku'          => [
				[ [__CLASS__, 'ags_divi_wc_show_product_loop_sku'] ],
			],
			'ratings'        => [
				[ 'woocommerce_template_loop_rating' ]
			],
			'quantity'          => [
				[ array( $this, 'ags_divi_wc_show_product_loop_quantity' ) ]
			],
			'price'          => [
				[ 'woocommerce_template_loop_price' ]
			],
			'button'           => [
				[ 'woocommerce_template_loop_add_to_cart' ]
			],
			'categories'           => [
				[ array( $this, 'ags_divi_wc_show_product_categories' ) ]
			],
			'stock'           => [
				[ array( $this, 'ags_divi_wc_show_product_stock' ) ]
			],
			'excerpt'           => [
				[ array( $this, 'ags_divi_wc_show_product_excerpt' ) ]
			],
			'row-start'           => [
				[ array( $this, 'ags_divi_wc_reset_column_number' ) ],
				[ array( $this, 'ags_divi_wc_column_start' ) ]
			],
			'column-break'           => [
				[ array( $this, 'ags_divi_wc_column_end' ) ],
				[ array( $this, 'ags_divi_wc_column_start' ) ]
			],
			'row-end'           => [
				[ array( $this, 'ags_divi_wc_column_end' ) ]
			]
		));

		/** Reset **/
		$this->removeAllActions( 'woocommerce_before_shop_loop_item_title' );
		$this->removeAllActions( 'woocommerce_shop_loop_item_title' );
		$this->removeAllActions( 'woocommerce_after_shop_loop_item_title' );
		// woocommerce\includes\wc-template-hooks.php
		$this->removeAction( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		$this->removeAction( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		$this->removeAction( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 ); // Add to cart

		if ( isset($this->options['child_order']) ) {

			$childOrder = explode(',', $this->options['child_order']);

		} else {

			$childOrder = [];

			if ( isset( $this->options['sale_flash'] ) && $this->options['sale_flash'] ) {
				$childOrder[] = 'sale-badge';
			}

			if ( isset( $this->options['percentage_sale_flash'] ) && $this->options['percentage_sale_flash'] ) {
				$childOrder[] = 'percentage-sale-badge';
			}

			if ( isset( $this->options['new_badge'] ) && $this->options['new_badge'] ) {
				$childOrder[] = 'new-badge';
			}

			if ( isset( $this->options['thumbnail'] ) && $this->options['thumbnail'] ) {
				$childOrder[] = 'image';
			}

			$childOrder[] = 'title';

			if ( isset( $this->options['price'] ) && $this->options['price'] ) {
				$childOrder[] = 'price';
			}

			if ( isset( $this->options['rating'] ) && $this->options['rating'] ) {
				$childOrder[] = 'ratings';
			}

			if ( isset( $this->options['stock'] ) && $this->options['stock'] ) {
				$childOrder[] = 'stock';
			}

			if ( isset( $this->options['quantity'] ) && $this->options['quantity'] ) {
				$childOrder[] = 'quantity';
			}

			if ( isset( $this->options['add_to_cart'] ) && $this->options['add_to_cart'] ) {
				$childOrder[] = 'button';
			}

			if ( isset( $this->options['categories'] ) && $this->options['categories'] ) {
				$childOrder[] = 'categories';
			}

			if ( isset( $this->options['excerpt'] ) && $this->options['excerpt'] ) {
				$childOrder[] = 'excerpt';
			}

		}
		
		$childOrder = apply_filters('dswcp_woo_shop_child_order', $childOrder, $this->options);

		$itemsToInsert = [];
		if ( isset( $this->options['new_badge_pos'] ) && $this->options['new_badge_pos'] != 'no_overlay' ) {

			$newBadgePos = array_search('new-badge', $childOrder);
			if ($newBadgePos !== false) {
				$itemsToInsert 	 = array_merge($itemsToInsert, $itemActions['new-badge']);
				array_splice($childOrder, $newBadgePos, 1);
			}
		}

		if( isset( $this->options['sale_badge_pos'] ) && $this->options['sale_badge_pos'] != 'no_overlay' ) {

			$saleBadgePos = array_search('sale-badge', $childOrder);
			if ($saleBadgePos !== false) {
				$itemsToInsert 	 = array_merge($itemsToInsert, $itemActions['sale-badge']);
				array_splice($childOrder, $saleBadgePos, 1);
			}
		}

		if( isset( $this->options['sale_percentage_badge_pos'] ) && $this->options['sale_percentage_badge_pos'] != 'no_overlay' ) {

			$saleBadgePos = array_search('percentage-sale-badge', $childOrder);
			if ($saleBadgePos !== false) {
				$itemsToInsert 	 = array_merge($itemsToInsert, $itemActions['percentage-sale-badge']);
				array_splice($childOrder, $saleBadgePos, 1);
			}
		}

		array_splice($itemActions['image'], 1, 0, $itemsToInsert);

		$titleIndex = array_search('title', $childOrder);
		if ($titleIndex === false) {
			$titleIndex = -1;
		}

		foreach ($childOrder as $i => $item) {
			if ($item && $item[strlen($item) - 1] != '}' || strpos($item, '{') === false) {
				unset($actionParams);
			} else {
				// Handle parameterized actions
				$paramsStartPos = strpos($item, '{');
				$actionParams = substr($item, $paramsStartPos + 1, -1);
				$actionParams = json_decode(base64_decode($actionParams), true);
				$item = substr($item, 0, $paramsStartPos);
			}
			
			if ( isset( $itemActions[$item] ) ) {

				foreach ($itemActions[$item] as $action) {
					
					if (isset($actionParams)) {
						$action[0] = [new DSWCP_Parameterized_Action($action[0], $actionParams), 'execute'];
					}

					if ( $i < $titleIndex ) {
						$hook = 'woocommerce_before_shop_loop_item_title';
						$priority = $i;
					} else if ( $i > $titleIndex ) {
						$hook = 'woocommerce_after_shop_loop_item_title';
						$priority = 0;
					} else { // this is the title
						$hook = 'woocommerce_shop_loop_item_title';
						$priority = $i - $titleIndex - 1;
					}

					array_unshift( $action, $hook );

					if ( count($action) < 3 ) {
						$action[2] = 10 + $priority;
					}

					call_user_func_array( [ $this, 'addAction' ], $action );

				}
			}
		}

		if ( isset( $this->options['button_style_icon'] ) && in_array('button', $childOrder) ) {
			$this->addFilter( 'woocommerce_loop_add_to_cart_args', array( $this, 'ags_divi_wc_add_button_icon' ) );
		}


		// Description category page
		/* implementation of this option to be completed later

		if ( isset( $this->options['description'] ) && $this->options['description']  === true )
		{
			remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10, 0);
			add_action('woocommerce_after_shop_loop', array( $this, 'ags_divi_wc_bottom_description' ) , 20);
		}

		*/

	}
	
	function filter_product_image($imageHtml, $product, $size, $attr, $placeholder) {
		global $dswcp_active_attribute_filters;
		
		if ($product->get_type() == 'variable' && !empty($dswcp_active_attribute_filters)) {
			$requiredAttributes = [];
			foreach ($product->get_variation_attributes() as $attributeTaxonomy => $attributeValues) {
				if (isset($dswcp_active_attribute_filters[$attributeTaxonomy])) {
					foreach (explode(',', $dswcp_active_attribute_filters[$attributeTaxonomy]) as $termId) {
						$termSlug = get_term($termId)->slug;
						if (in_array($termSlug, $attributeValues)) {
							if (isset($requiredAttributes[$attributeTaxonomy])) {
								$requiredAttributes[$attributeTaxonomy][] = $termId;
							} else {
								$requiredAttributes[$attributeTaxonomy] = [$termId];
							}
						}
					}
				}
			}
			
			foreach ($product->get_children() as $variationId) {
				if (get_post_meta($variationId, '_thumbnail_id', true)) {
					
					foreach ($requiredAttributes as $variationAttribute => $attributeTermIds) {
						foreach ($attributeTermIds as $termId) {
							if (has_term($termId, $variationAttribute, $variationId)) {
								continue 2; // next attribute
							}
						}
						continue 2; // next variation (attribute didn't match)
						
					}
					
					// We have a match with an image!
					$variation = wc_get_product($variationId);
					if ($variation) {
						return $variation->get_image($size, $attr, $placeholder);
					}
					
				}
				
			}
		}
			
		return $imageHtml;
	}

	/**
	 * Some plugins or themes may have already customized the hooks
	 * We'll add body classes to the page and hide elements with CSS as a fall back
	 *
	 * @return $body_classes
	 * @since 1.0.4
	 * @see https://github.com/jameskoster/woocommerce-product-archive-customiser/issues/22
	 */
	function ags_divi_wc_fire_customisation_styles( $body_classes )
	{

		$layout = ( empty( $this->options['layout'] ) ? 'grid' : $this->options['layout'] );
		$ags_divi_wc_body_classes = array(
			'ags-divi-wc-layout-'.esc_attr($layout)
		);

		//if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {

			// Badges position
			$ags_divi_wc_body_classes[] = 'ags-divi-wc-new-badge-'.(isset( $this->options['new_badge_pos'] ) ? esc_attr($this->options['new_badge_pos']) : 'no_overlay');
			$ags_divi_wc_body_classes[] = 'ags-divi-wc-sale-badge-'.(isset( $this->options['sale_badge_pos'] ) ? esc_attr($this->options['sale_badge_pos']) : 'no_overlay');
			$ags_divi_wc_body_classes[] = 'ags-divi-wc-percentage-sale-badge-'.(isset( $this->options['sale_percentage_badge_pos'] ) ? esc_attr($this->options['sale_percentage_badge_pos']) : 'no_overlay');


			// Sale flash.
			if ( isset( $this->options['sale_flash'] ) && $this->options['sale_flash'] === false ) {
				$ags_divi_wc_body_classes[] = 'ags-divi-wc-hide-sale-flash';
			}

			// Result Count.
			if ( isset( $this->options['product_count'] ) && $this->options['product_count'] === false ) {
				$ags_divi_wc_body_classes[] = 'ags-divi-wc-hide-product-count';
			}

			// Product Ordering.
			if ( isset( $this->options['product_sorting'] ) &&  $this->options['product_sorting'] === false ) {
				$ags_divi_wc_body_classes[] = 'ags-divi-wc-hide-product-sorting';
			}

			// Add to cart button.
			if ( isset( $this->options['add_to_cart'] ) && $this->options['add_to_cart'] === false ) {
				$ags_divi_wc_body_classes[] = 'ags-divi-wc-hide-add-to-cart';
			}

			// Thumbnail.
			if ( isset( $this->options['thumbnail'] ) && $this->options['thumbnail'] === false ) {
				$ags_divi_wc_body_classes[] = 'ags-divi-wc-hide-thumbnail';
			}

			// Price.
			if ( isset( $this->options['price'] ) && $this->options['price'] === false ) {
				$ags_divi_wc_body_classes[] = 'ags-divi-wc-hide-price';
			}

			// Rating.
			if ( isset( $this->options['rating'] ) && $this->options['rating'] === false ) {
				$ags_divi_wc_body_classes[] = 'ags-divi-wc-hide-rating';
			}

			if ( $layout == 'grid' ) {

				// Product columns.

				if ( isset( $this->options['columns'] ) ) {
					$ags_divi_wc_body_classes[] = 'product-columns-' . (int) $this->options['columns'];
				}
				if ( !empty( $this->options['columns_tablet'] ) ) {
					$ags_divi_wc_body_classes[] = 'product-columns-tablet-' . (int) $this->options['columns_tablet'];
				}
				if ( !empty( $this->options['columns_phone'] ) ) {
					$ags_divi_wc_body_classes[] = 'product-columns-phone-' . (int) $this->options['columns_phone'];
				}

			}


		//}


		// Add the body classes to the body
		return array_merge( $body_classes, $ags_divi_wc_body_classes );
	}

	static function ags_divi_wc_show_product_loop_sku() {
		global $product;
		if (isset($product)) {
			$sku = $product->get_sku();
			if (!empty($sku)) {
				echo('<span class="ags-divi-wc-sku">');
				woocommerce_template_loop_product_link_open();
				echo esc_html($sku) ;
				woocommerce_template_loop_product_link_close();
				echo('</span>');
			}
		}
	}

	/**
	 * Return the desired products per row
	 *
	 * @return int product columns
	 */
	function ags_divi_wc_products_row()
	{
		if (isset($this->options['columns'])) {
			$columns = (int) $this->options['columns'];
			if ( $columns < 1 || $columns > 6 ) {
				$columns = 4;
			}
		} else {
			$columns = 4;
		}

		return $columns;
	}


	/**
	 * Display the new badge
	 *
	 * @return void
	 */
	function ags_divi_wc_show_product_loop_new_badge()
	{
		$postdate 		= get_the_time( 'Y-m-d' );			 // Post date.
		$postdatestamp 	= strtotime( $postdate );			 // Timestamped post date.
		$newness 		= isset($this->options['newness']) ? $this->options['newness'] : 28; // Newness in days as defined by option.

		// If the product was published within the newness time frame display the new badge.
		if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) {
			$absolute_layout = isset( $this->options['new_badge_pos'] ) && $this->options['new_badge_pos'] !== 'no_overlay';
			$badge 			 =  sprintf('<span class="wc-new-badge"><span>%s</span></span>',
				isset($this->options['new_badge_custom_text'] ) ? esc_html($this->options['new_badge_custom_text']) :  esc_html__( 'New', 'divi-shop-builder' )
			);

			echo $absolute_layout ? '<span class="ags-divi-wc-new-badge">'.et_core_esc_previously($badge).'</span>' : et_core_esc_previously($badge);
		}
	}

	/**
	 * Display the sale badge
	 *
	 * @return void
	 */
	function ags_divi_wc_show_product_loop_sale_badge() {
		global $product;
		if ($product->is_on_sale()) {
			echo '<span class="ags-divi-wc-sale-badge"><span class="onsale">' . ( isset($this->options['sale_badge_custom_text']) ? esc_html($this->options['sale_badge_custom_text']) : esc_html__('Sale', 'divi-shop-builder') ) . '</span></span>';
		}
	}
	/**
	 * Display the sale badge with percentages
	 *
	 * @return void
	 */
	function ags_divi_wc_show_product_loop_percentage_sale_badge() {
		global $product;

		if ( $product->is_on_sale() ) {
			$text                  = isset( $this->options['sale_badge_custom_text'] ) ? $this->options['sale_badge_custom_text'] : __( 'Sale', 'divi-shop-builder' );
			$text_after_percentage = isset( $this->options['sale_badge_percentage_custom_text'] ) ? $this->options['sale_badge_percentage_custom_text'] : __( '% OFF', 'divi-shop-builder' );
			$min_value = isset( $this->options['percentage_sale_min_value'] ) ? (int)str_replace('%', '', trim($this->options['percentage_sale_min_value'])) : 5 ;
			$product_type          = $product->get_type();

			if ( $product_type == 'variable' ) {

				// Get all variation prices
				$prices      = $product->get_variation_prices();
				$percentages = [];
				$product_sale = 0;


				// Loop through variation prices
				foreach ( $prices['price'] as $key => $price ) {


					// Only on sale variations
					if ( $prices['regular_price'][ $key ] > $price ) {

						if ($prices['regular_price'][$key] > 0) { // Check if the regular price is greater than zero

							// Calculate and set in the array the percentage for each variation on sale
							$percentages[] = round((($prices['regular_price'][$key] - $price) / $prices['regular_price'][$key]) * 100);

						} else {
							$percentages[] = 0; // Set default value if the regular price is zero
						}

					}
				}
				// We keep the highest value
				if ( $percentages ) {
					$product_sale = max( $percentages );
				}

			} else {
				$regular_price = $product->get_regular_price();
				$sale_price    = $product->get_sale_price();

				if (floatval($regular_price) > 0) {
					$product_sale = round(((floatval($regular_price) - floatval($sale_price)) / floatval($regular_price)) * 100);
				} else {
					$product_sale = 0; // Set default value if the regular price is zero
				}
			}
			if ( $product_sale >= $min_value ) {

				// Display % sale only if larger than min value
				echo '<span class="ags-divi-wc-sale-badge ags-divi-wc-percentage-sale-badge"><span class="onsale">' . esc_html(str_replace('#',  $product_sale, $text_after_percentage )) . '</span></span>';
			} else {
				echo '<span class="ags-divi-wc-sale-badge"><span class="onsale">' . esc_html( $text ) . '</span></span>';
			}
		}
	}


	/**
	 * Display the product categories
	 *
	 * @return void
	 */
	function ags_divi_wc_show_product_categories()
	{
		global $post;
		$terms_as_links = get_the_term_list( $post->ID, 'product_cat', '', ', ', '' );
		echo '<span class="categories"><small>' . wp_kses_post( $terms_as_links ) . '</small></span>';
	}

	/**
	 * Display the product excerpt
	 *
	 * @return void
	 */
	function ags_divi_wc_show_product_excerpt()
	{   global $post;
		$description_type	= isset( $this->options['description_type']) ? $this->options['description_type'] : 'short_description'; // Newness in days as defined by option.
 		$custom_text = esc_html( $post-> ags_divi_wc_description );
		$description_text = ( $description_type === 'short_description' ) ? get_the_excerpt() : $custom_text;

		$attrs 	 = '';
		if ( isset($this->options['excerpt_limit']) && $this->options['excerpt_limit'] == 'off') {
			$length = null;
		} else {
		$length  = max( intval( $this->options['excerpt_length'] ), 55 );
		}

		if( $this->module instanceof ET_Builder_Element ) {

			$multiview = et_pb_multi_view_options( $this->module );
			$values    = $multiview->get_values( 'excerpt_length' );
			$limit    = $multiview->get_values( 'excerpt_limit' );
			$contents  = array();
			
			if ( isset($limit['desktop']) && $limit['desktop'] == 'off' ) {
				$contents['desktop'] = $description_text;
				$length = null;
			} else if( !empty( $values['desktop'] ) ){
				$contents['desktop'] = wp_trim_words( $description_text, intval( $values['desktop'] ), '...' );
				$length 			 = intval( $values['desktop'] );
			}

			if ( isset($limit['tablet']) && $limit['tablet'] == 'off' ) {
				$contents['tablet'] = $description_text;
			} else if( !empty( $values['tablet'] ) ){
				$contents['tablet'] = wp_trim_words( $description_text, intval( $values['tablet'] ), '...' );
			}

			if ( isset($limit['phone']) && $limit['phone'] == 'off' ) {
				$contents['phone'] = $description_text;
			} else if( !empty( $values['phone'] ) ){
				$contents['phone'] = wp_trim_words( $description_text, intval( $values['phone'] ), '...' );
			}

			if( count( $contents ) > 1 ){
				$attrs = $multiview->render_attrs(
					array(),
					false,
					array(
						'content' => $contents
					)
				);
			}
		}

		echo sprintf(
			'<span class="ags-divi-wc-product-excerpt" %s>%s</span>',
			et_core_esc_previously($attrs), // render_attrs() wraps the returned variable in this same function
			et_core_esc_previously( $length === null ? $description_text : wp_trim_words( $description_text, $length, '...' ) ) // either uses post_excerpt, which should contain safe HTML, or the custom text, which has esc_html() applied above
		);
	}

	/**
	 * Display the product excerpt
	 *
	 * @return void
	 */
	function ags_divi_wc_column_start()
	{
		echo '<span class="ags-divi-wc-list-column-'.((int) $this->columnNumber).'">';
	}

	/**
	 * Display the product excerpt
	 *
	 * @return void
	 */
	function ags_divi_wc_column_end()
	{
		echo '</span>';
		++$this->columnNumber;
	}

	/**
	 * Display the product excerpt
	 *
	 * @return void
	 */
	function ags_divi_wc_badges_start()
	{
		echo '<span class="ags-divi-wc-badges">';
	}

	/**
	 * Display the product excerpt
	 *
	 * @return void
	 */
	function ags_divi_wc_badges_end()
	{
		echo '</span>';
	}

	/**
	 * Display the product excerpt
	 *
	 * @return void
	 */
	function ags_divi_wc_reset_column_number()
	{
		$this->columnNumber = 1;
	}

	/**
	 * Display the product excerpt
	 *
	 * @return void
	 */
	function ags_divi_wc_reset_column_number_2()
	{
		$this->columnNumber = 2;
	}

	/**
	 * Display the product excerpt
	 *
	 * @return void
	 */
	function ags_divi_wc_add_button_icon($args)
	{
		$icon 			= !empty( $this->options['button_style_icon'] ) ? $this->options['button_style_icon'] : '%%20%%';
		$view_cart_icon = !empty( $this->options['button_view_cart_icon'] ) ? $this->options['button_view_cart_icon'] : '%%20%%';
		$args['attributes']['data-icon'] = et_pb_process_font_icon( $icon );
		$args['attributes']['data-view_cart_icon'] = et_pb_process_font_icon( $view_cart_icon );
		return $args;
	}

	/**
	 * Display the product stock
	 *
	 * @return void
	 */
	function ags_divi_wc_show_product_stock()
	{
		global $product;
		$product_availability = $product->get_availability();
		$isInStock = $product->is_in_stock();

		if (!empty( $product_availability['availability'] ) ) {
			$availability_text = $product_availability['availability'];
		} else if ( $isInStock ) {
			$availability_text = empty($this->options['in_stock_text']) ? __('In stock', 'divi-shop-builder') : $this->options['in_stock_text'];
		} else {
			$availability_text = '';
		}

		if ( $isInStock ) {
			echo '<span class="stock in-stock"><small>' . esc_html( $availability_text ) . '</small></span>';
		} else {
			echo '<span class="stock out-of-stock"><small>' . esc_html( $availability_text ) . '</small></span>';
		}
	}

	/**
	 * Show an archive description on taxonomy archives.
	 */
	function ags_divi_wc_bottom_description()
	{
		if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
			$term = get_queried_object();

			if ( $term && ! empty( $term->description ) ) {
				echo '<div class="term-description">' . et_core_intentionally_unescaped( wc_format_content( $term->description ), 'html' ) . '</div>';
			}
		}
	}


	/**
	 * Show a quantity input to add to cart
	 */
	function ags_divi_wc_show_product_loop_quantity(){

		global $product;

		if( !$product->is_purchasable() || !$product->is_in_stock() ) {
			return;
		}

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset($this->options['default_quantity']) ? $this->options['default_quantity'] : 1
			)
		);
	}
	
	/**
	 * Show a "no products found" message - also exists in WooShop.jsx
	 */
	function ags_divi_wc_no_products_found() {
?>
	<div class="ags-divi-wc-no-products-found">
		<?php if (!empty($this->options['no_products_heading_text'])) { ?><h4><?php echo(esc_html($this->options['no_products_heading_text'])); ?></h4><?php } ?>
		<?php if (!empty($this->options['no_products_text'])) { ?><p><?php echo(esc_html($this->options['no_products_text'])); ?></p><?php } ?>
	</div>
<?php
	}

}

class DSWCP_Parameterized_Action {
	private $cb, $params;
	function __construct($cb, $params) {
		$this->cb = $cb;
		$this->params = $params;
	}
	function execute() {
		call_user_func($this->cb, $this->params);
	}
}