<?php
namespace WPZone\DiviShopBuilder\Modules\WooProductsFiltersChildModule\Traits;

defined('ABSPATH') || exit;

trait FilterHtmlTrait {
	
	function get_filter_html($attrs) {
		switch ( $attrs['choose_filter'] ) {
			case 'category':
				return $this->category_display($attrs);
			case 'tag':
				return $this->tag_display($attrs);
			case 'attribute':
				return $this->attribute_display($attrs);
			case 'taxonomy':
				return $this->taxonomy_display($attrs);
			case 'search':
				return $this->search_display($attrs);
			case 'rating':
				return $this->rating_display($attrs);
			case 'price':
				return $this->price_display($attrs);
			case 'stock_status':
				return $this->stock_status_display($attrs);
			case 'sale':
				return $this->sale_display($attrs);
			case 'sorting':	
				return $this->sorting_display($attrs);
		}
	}
	
	function filter_section_start($queryVar, $extraClass='') {
		global $dswcp_filters_layout, $dswcp_filters_active_count;
		
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- this only affects the output of the current request
		$isComputedPropertyRequest = (defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && $_REQUEST['action'] == 'et_pb_process_computed_property');
		
		$hasDynamicProductCounts = $this->props['show_number_of_products'] == 'on' && $this->props['dynamic_product_counts'] == 'on' && $queryVar && $queryVar != 'shopOrder';
		echo '<div class="ags-wc-filters-section'
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive; only fixed string and escaped value here
				.($queryVar == 'shopCategory' ? ' ags-wc-filters-children-'.esc_attr($this->props['show_children']) : '')
				.(($this->props['display_as_toggle'] == 'on' && !$this->props['toggle_default']) || $dswcp_filters_layout == 'horizontal' || $isComputedPropertyRequest ? ' ags-wc-filters-section-toggle-closed' : '')
				.($this->props['hide_zero_count'] == 'on' && !in_array($queryVar, ['shopSearch', 'shopRating', 'shopPrice', 'shopSale', 'shopOrder']) ? ' ags-wc-filters-hide-zero-count' : '')
		        .($this->props['expand_hierarchy'] == 'on' ? ' ags-wc-filters-expand-hierarchy' : '')
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive; only fixed strings and escaped value here
				.($extraClass ? ' '.esc_attr($extraClass) : '')
				.'"'
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive; only fixed strings and escaped values here
				.($queryVar ? ' data-ags-wc-filters-query-var="' . esc_attr($queryVar). '" data-ags-wc-filters-real-query-var="' . esc_attr($queryVar) . '"' : '')
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive; only fixed string and escaped value here
				.($hasDynamicProductCounts ? ' data-ags-wc-filters-dynamic-product-counts="' . esc_attr($queryVar) . '"' : '')
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive; only fixed string and escaped value here
				.($this->props['condition'] == 'always' ? '' : ' data-condition="'.esc_attr($this->props['condition']).'"')
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive; only fixed string and escaped value here
				.($this->props['condition'] == 'category' ? ' data-condition-categories="'.esc_attr($this->props['condition_categories']).'"' : '')
				. '>';
		if ( $this->props['display_filter_title'] == 'on' ) {
			echo '<div class="ags-wc-filters-section-title ' . (($this->props['display_as_toggle'] == 'on' || $dswcp_filters_layout == 'horizontal' || $isComputedPropertyRequest) ? 'ags-wc-filters-section-toggle' : '') . '">'
					.'<h4>' . esc_html($this->props['filter_title_text'])
			        .(($dswcp_filters_active_count || $isComputedPropertyRequest) && $queryVar != 'shopOrder' ? '<span class="ags-wc-filters-title-active-count"></span>' : '')
			        . '</h4>';
			if ($this->props['filter_clear'] == 'on') {
				echo '<a href="#" class="ags-wc-filters-filter-clear">'.esc_html($this->props['filter_clear_text']).'</a>';
			}
			echo '</div>';
		}
		echo '<div class="ags-wc-filters-section-inner-wrapper"><div class="ags-wc-filters-section-inner">';
	}

	function filter_section_end() {
		echo '</div></div></div>';
	}

	function display_options($type, $displayAs, $options, $productCounts, $childFunction, $isChild = false, $hideLabels = true, $displayInline = false, $attr_select_style = '1', $hide_tooltip = false, $defaultOption=null) {
		$renderCount = $this->render_count();

		if ( ! $isChild && $this->props['show_number_of_products'] == 'on' && ($displayAs == 'radio_buttons_list' || $displayAs == 'tagcloud' || $displayAs == 'dropdown_single_select' || $displayAs == 'dropdown_single_select_required') ) {
			
			if (dscwp_ags_filters_get_count_attributes()) {
				$totalProductsCount = (new \AGS_WC_Shortcode_Products_Count_Simulator())->getSimulatedCount();
			} else {
				$total_product_args = array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => - 1
				);
				$products_count     = new \WP_Query($total_product_args);
				$totalProductsCount = $products_count->found_posts;
			}
			
		}

		if ( $displayAs == 'radio_buttons_list' || $displayAs == 'tagcloud' ) {

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- only fixed strings are used in conditionals
			echo '<ul class="' . ($isChild ? 'ags-wc-filters-list-child' : 'ags-wc-filters-list ' . ($displayAs == 'tagcloud' ? 'ags-wc-filters-tagcloud' : 'ags-wc-filters-radio-button-list')) . '">';

			if ($this->props['show_option_all'] == 'on') {
				$allText = $this->props[ $type == 'rating' ? 'rating_text_all' : 'all_categories_option_text' ];
				if ( ! $isChild ) {
					echo '<li><input type="radio" id="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_all" name="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '" value="all" data-label="' . esc_attr($allText) . '" checked><label for="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_all">' . esc_html($allText)
						 . (
							 // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive
						 $productCounts
							 ? '&nbsp;<span class="ags-wc-filters-product-count">' . ((int) $totalProductsCount) . '</span>'
							 // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive
							 : ""
						 ) . '</label></li>';
				}
			}

			foreach ( $options as $optionId => $optionLabel ) {
				if ( $childFunction && $this->props['show_children'] == 'hierarchical' ) {
					$children = $childFunction($optionId);
				}

				$isExpandable = $this->props['expand_hierarchy'] === 'on' && !empty($children['options']);

				echo '<li'.(empty($children['options']) ? '' : ' class="ags-wc-filters-has-children"').'>
						<input type="radio" id="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_' . sanitize_key($optionId) . '" name="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '" value="' . esc_attr($optionId) . '" data-label="' . esc_attr($optionLabel) . '">
						<label for="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_' . sanitize_key($optionId) . '">'
				     . (strpos($optionLabel, self::STAR) === false
						? esc_html($optionLabel)
						: et_core_intentionally_unescaped(str_replace(
							                                  [
								                                  self::STAR,
								                                  self::STAR_EMPTY,
								                                  ' <span',
								                                  '</span> '
							                                  ],
							                                  [
								                                  '<span class="ags-wc-filters-star-filled">' . self::STAR . '</span>',
								                                  '<span class="ags-wc-filters-star-empty">' . self::STAR . '</span>',
								                                  '&nbsp;<span',
								                                  '</span>&nbsp;'
							                                  ],
							                                  preg_replace(
								                                  '/((' . preg_quote(self::STAR_EMPTY, '/') . '|' . preg_quote(self::STAR, '/') . '){5})/',
								                                  '<span class="ags-wc-filters-stars">$1</span>',
								                                  esc_html($optionLabel)
							                                  )
						                                  ), 'html')
				     )
				     // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped via (int) cast
				     . (isset($productCounts[ $optionId ]) ? '&nbsp;<span class="ags-wc-filters-product-count">' . ((int) $productCounts[ $optionId ]) . '</span>' : "")
				     . ($isExpandable ? '<a href="#" class="ags-wc-filters-expanded-toggle ags-wc-filters-expand_hierarchy "></a>' : '')
				     . '</label>';

					if (!empty($children['options'])) {
						$this->display_options($type, $this->props['display_as'], $children['options'], $children['productCounts'], $childFunction, true);
					}

				echo '</li>';
			}

			echo '</ul>';

		} elseif ( $displayAs == 'dropdown_single_select' || $displayAs == 'dropdown_single_select_required' ) {

			if ($displayAs == 'dropdown_single_select') {
				$allText = $this->props[ $type == 'rating' ? 'rating_text_all' : 'all_categories_option_text' ];
			}

			if ( ! $isChild ) {
				echo '<div class="ags-wc-filters-dropdown-single">';
				echo '<div class="ags-wc-filters-active">';
				echo '<a href="#"><span>' . esc_html($displayAs == 'dropdown_single_select' ? $allText : $options[$defaultOption]) . '</span></a>';
				echo '</div>';
				echo '<div class="ags-wc-filters-dropdown-single-options ags-wc-filters-hide-on-click">';
			}

			echo '<ul class="' . ($isChild ? 'ags-wc-filters-list-child' : 'ags-wc-filters-list ags-wc-filters-dropdown-single-options-wrapper') . '">';

			if ( ! $isChild ) {
				echo '<div class="ags-wc-filters-dropdown-toggle"></div>';

				if ($displayAs == 'dropdown_single_select') {
				echo '<li><a id="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_all" href="#" data-id="all" data-label="' . esc_attr($allText) . '" class="ags-wc-filters-active"><span>' . esc_html($allText)
				     . (

					     // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive
				     $productCounts
					     ? '<span class="ags-wc-filters-product-count">' . ((int) $totalProductsCount) . '</span>'
					     // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive
					     : ""
				     ) . '</span></a></li>';
				}
			}

			foreach ( $options as $optionId => $optionLabel ) {
				echo '<li>
							<a id="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_' . sanitize_key($optionId) . '" href="#" data-id="' . esc_attr($optionId) . '" data-label="' . esc_attr($optionLabel) . '"'.($defaultOption !== null && $optionId == $defaultOption ? ' class="ags-wc-filters-active"' : '').'>
								<span>'
				     . (strpos($optionLabel, self::STAR) === false
						? esc_html($optionLabel)
						: et_core_intentionally_unescaped(str_replace(
							[
								self::STAR,
								self::STAR_EMPTY,
								' <span',
								'</span> '
							],
							[
								'<span class="ags-wc-filters-star-filled">' . self::STAR . '</span>',
								'<span class="ags-wc-filters-star-empty">' . self::STAR . '</span>',
								'&nbsp;<span',
								'</span>&nbsp;'
							],
							preg_replace(
								'/((' . preg_quote(self::STAR_EMPTY, '/') . '|' . preg_quote(self::STAR, '/') . '){5})/',
								'<span class="ags-wc-filters-stars">$1</span>',
								esc_html($optionLabel)
							)
						), 'html')
				     )
				     // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped via (int) cast
				     . (isset($productCounts[ $optionId ]) ? '<span class="ags-wc-filters-product-count">' . ((int) $productCounts[ $optionId ]) . '</span>' : "")
				     . '</span>
							</a>';

				if ( $childFunction && $this->props['show_children'] == 'hierarchical' ) {
					$children = $childFunction($optionId);
					$this->display_options($type, $this->props['display_as'], $children['options'], $children['productCounts'], $childFunction, true);
				}

				echo '</li>';
			}

			echo '</ul>';

			if ( ! $isChild ) {
				echo '</div>';
				echo '</div>';
			}

		} elseif ( $displayAs == 'dropdown_multi_select' ) {
			if ( ! $isChild ) {
				echo '<div class="ags-wc-filters-dropdown-multi" data-placeholder-text="' . esc_attr($this->props['select_placeholder_text']) . '">';
				echo '<div class="ags-wc-filters-active">';
				echo '<span>' . esc_html($this->props['select_placeholder_text']) . '</span>';
				echo '</div>';
			}

			echo '<ul class="' . ($isChild ? 'ags-wc-filters-list-child' : 'ags-wc-filters-list ags-wc-filters-dropdown-multi-options ags-wc-filters-hide-on-click') . '" style="display:none">';

			if ( ! $isChild ) {
				echo '<div class="ags-wc-filters-dropdown-toggle"></div>';
			}

			foreach ( $options as $optionId => $optionLabel ) {
				echo '<li>
				<a>
					<input type="checkbox" id="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_' . sanitize_key($optionId) . '" value="' . esc_attr($optionId) . '" data-label="' . esc_attr($optionLabel) . '">
					<label for="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_' . sanitize_key($optionId) . '">'
				     . esc_html($optionLabel)
				     // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped via (int) cast
				     . (isset($productCounts[ $optionId ]) ? '<span class="ags-wc-filters-product-count">' . ((int) $productCounts[ $optionId ]) . '</span>' : "")
				     . '</label>
				</a>';

				if ( $childFunction && $this->props['show_children'] == 'hierarchical' ) {
					$children = $childFunction($optionId);
					$this->display_options($type, $this->props['display_as'], $children['options'], $children['productCounts'], $childFunction, true);
				}
				echo '</li>';
			}

			echo '</ul>';

			if ( ! $isChild ) {
				echo '</div>';
			}

		} else if ( $displayAs == 'colors' ) {
			echo '<ul class="ags-wc-filters-list ags-wc-filters-colors'.($hideLabels ? ' ags-wc-filters-labels-hide' : '') . ' ags-wc-filters-swatch-'.esc_attr($attr_select_style)  .'">';
			foreach ( $options as $optionId => $option ) {
				echo('<li>
						<input id="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_' . sanitize_key($optionId) . '" type="checkbox" value="'.((int) $optionId).'" >
						<label for="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_' . sanitize_key($optionId) . '" title="'.esc_attr($option['label']).'">
							<div class="ags_wc_filters_color_wrap">
								<span class="ags_wc_filters_color"' . ' style="background-color:'.esc_attr($option['color']) . '"></span>');
				if (!$hide_tooltip) {
					echo('<span class="ags_wc_filters_tooltip"><span>'.esc_html($option['label']));
					if ($productCounts) {
						echo(' (<span class="ags-wc-filters-product-count">'. ((int) $productCounts[ $optionId ]) . '</span>)');
					}
					echo('</span></span>');
				}
				echo('</div>');
				
				if (!$hideLabels) {
					echo('<span class="ags-wc-filters-product-att-name">'.esc_html($option['label']).'</span>');
				}
				
				if ($productCounts) {
					echo('<span class="ags-wc-filters-product-count">' . ((int) $productCounts[ $optionId ]) . '</span>');
				}
				
				echo('</label></li>');
			}
			echo '</ul>';
		} else if ( $displayAs == 'images' ) {
			echo '<ul class="ags-wc-filters-list ags-wc-filters-images'.($hideLabels ? ' ags-wc-filters-labels-hide' : '').($displayInline ? ' ags-wc-filters-inputs-inline' : '') . ' ags-wc-filters-swatch-'.esc_attr($attr_select_style)  .'">';
			foreach ( $options as $optionId => $option ) {
				if (is_array($option)) {
					echo('<li>
							<input id="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_' . sanitize_key($optionId) . '" type="checkbox" value="'.((int) $optionId).'">
							<label class="ags_wc_filters_label_image" for="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_' . sanitize_key($optionId) . '" title="'.esc_attr($option['label']).'">'.wp_get_attachment_image($option['image']).
							'<span class="ags-wc-filters-product-att-label">');

							if (!$hideLabels) {
								echo('<span class="ags-wc-filters-product-att-name">'.esc_html($option['label']).'</span>');
							}

							if ($productCounts) {
								echo('(<span class="ags-wc-filters-product-count">' . ((int) $productCounts[ $optionId ]) . '</span>)');
							}

							echo('</span>');

							if (!$hide_tooltip) {
								echo('<span class="ags_wc_filters_tooltip"><span>'  .esc_html($option['label']));
								if ($productCounts) {
									echo(' (<span class="ags-wc-filters-product-count">'. ((int) $productCounts[ $optionId ]) . '</span>)');
								}
								echo('</span></span>');
							}
							echo('</label>
						</li>');
				}
			}
			echo '</ul>';
		} else {
			echo '<ul class="' . ($isChild ? 'ags-wc-filters-list-child' : 'ags-wc-filters-list ags-wc-filters-checkbox-list') . '">';
			foreach ( $options as $optionId => $optionLabel ) {
				if ( $childFunction && $this->props['show_children'] == 'hierarchical' ) {
					$children = $childFunction($optionId);
				}
				$isExpandable = $this->props['expand_hierarchy'] === 'on' && !empty($children['options']);

				echo '<li'.(empty($children['options']) ? '' : ' class="ags-wc-filters-has-children"').'>
						<input type="checkbox" id="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_' . sanitize_key($optionId) . '" value="' . esc_attr($optionId) . '" data-label="' . esc_attr($optionLabel) . '">
						<label for="ags_wc_filters_' . ((int) $renderCount) . '_' . esc_attr($type) . '_' . sanitize_key($optionId) . '">'
				     . (strpos($optionLabel, self::STAR) === false
						? esc_html($optionLabel)
						: et_core_intentionally_unescaped(str_replace(
							                                  [
								                                  self::STAR,
								                                  self::STAR_EMPTY,
								                                  ' <span',
								                                  '</span> '
							                                  ],
							                                  [
								                                  '<span class="ags-wc-filters-star-filled">' . self::STAR . '</span>',
								                                  '<span class="ags-wc-filters-star-empty">' . self::STAR . '</span>',
								                                  '&nbsp;<span',
								                                  '</span>&nbsp;'
							                                  ],
							                                  preg_replace(
								                                  '/((' . preg_quote(self::STAR_EMPTY, '/') . '|' . preg_quote(self::STAR, '/') . '){5})/',
								                                  '<span class="ags-wc-filters-stars">$1</span>',
								                                  esc_html($optionLabel)
							                                  )
						                                  ), 'html')
				     )
				     // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped via (int) cast
				     . (isset($productCounts[ $optionId ]) ? '<span class="ags-wc-filters-product-count">' . ((int) $productCounts[ $optionId ]) . '</span>' : "")
				     . ($isExpandable ? '<a href="#" class="ags-wc-filters-expanded-toggle ags-wc-filters-expand_hierarchy "></a>' : '')
				     . '</label>';

				if (!empty($children['options'])) {
					$this->display_options($type, $this->props['display_as'], $children['options'], $children['productCounts'], $childFunction, true);
				}
				echo '</li>';
			}

			echo '</ul>';

		}
	}
	
	function sorting_display() {
		ob_start();
		$this->filter_section_start('shopOrder');
		
		// baesd on woocommerce/includes/wc-template-functions.php
		$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) );
		$catalog_orderby_options = apply_filters(
			'woocommerce_catalog_orderby',
			array(
				'menu_order' => __( 'Default sorting', 'woocommerce' ),
				'popularity' => __( 'Sort by popularity', 'woocommerce' ),
				'rating'     => __( 'Sort by average rating', 'woocommerce' ),
				'date'       => __( 'Sort by latest', 'woocommerce' ),
				'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
				'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
			)
		);

		$default_orderby = apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );

		if ( ! $show_default_orderby ) {
			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( ! wc_review_ratings_enabled() ) {
			unset( $catalog_orderby_options['rating'] );
		}

		if ( ! array_key_exists( $default_orderby, $catalog_orderby_options ) ) {
			$default_orderby = current( array_keys( $catalog_orderby_options ) );
		}

		$this->display_options(
			'sorting',
			'dropdown_single_select_required',
			$catalog_orderby_options,
			null,
			null,
			false,
			true,
			false,
			'1',
			false,
			$default_orderby
		);

		/*
		wc_get_template(
			'loop/orderby.php',
			array(
				'catalog_orderby_options' => $catalog_orderby_options,
				'orderby'                 => $orderby,
				'show_default_orderby'    => $show_default_orderby,
			)
		);
		*/

		$this->filter_section_end();
		return ob_get_clean();
	}

	function category_display() {
		ob_start();

		$this->filter_section_start('shopCategory');

		$args = array(
			'hierarchical'     => 1,
			'show_option_none' => '',
			'hide_empty'       => 0,
			'taxonomy'         => 'product_cat'
		);

		if ( $this->props['show_children'] != 'nonhierarchical' ) {
			$args['parent'] = 0;
		}

		$subcats = get_categories($args);

		if ( ! empty($subcats) ) {
			if ($this->props['display_as'] == 'images') {
				$options = [];
				foreach ($subcats as $subcat) {
					$image = get_term_meta($subcat->term_id, 'thumbnail_id', true);
					if ($image) {
						$options[$subcat->term_id] = [
							'label' => $subcat->name,
							'image' => $image
						];
					}
				}
			} else {
				$options = array_column($subcats, 'name', 'term_id');
			}
			
			if ($this->props['show_number_of_products'] == 'on') {
				if (dscwp_ags_filters_get_count_attributes()) {
					$simulator = new \AGS_WC_Shortcode_Products_Count_Simulator();
					foreach ($subcats as $term) {
						$productCounts[$term->term_id] = $simulator->getSimulatedCount('shopCategory', $term->term_id);
					}
				} else {
					$productCounts = array_intersect_key(array_column($subcats, 'count', 'term_id'), $options);
				}
			} else {
				$productCounts = null;
			}


			$this->display_options(
				'category',
				$this->props['display_as'],
				$options,
				$productCounts,
				$this->props['display_as'] == 'images'
					? null
					: function($parentId) {
						$args    = array(
							'hierarchical'     => 1,
							'show_option_none' => '',
							'hide_empty'       => 0,
							'parent'           => $parentId,
							'taxonomy'         => 'product_cat'
						);
						$subcats = get_categories($args);

						return [
							'options'       => array_column($subcats, 'name', 'term_id'),
							'productCounts' => array_column($subcats, 'count', 'term_id')
						];
					},
					false,
					$this->props['hide_labels'] == 'on',
					$this->props['display_inline'] == 'on',
					'1',
					$this->props['hide_tooltip'] == 'on'
			);
		}

		$this->filter_section_end();

		return ob_get_clean();

	}

	function tag_display() {
		ob_start();

		$this->filter_section_start('shopTag');

		$args = array(
			'hierarchical'     => 1,
			'show_option_none' => '',
			'hide_empty'       => 0,
			'taxonomy'         => 'product_tag'
		);

		$tags = get_terms($args);
		
		if ($this->props['show_number_of_products'] == 'on') {
			if (dscwp_ags_filters_get_count_attributes()) {
				$simulator = new \AGS_WC_Shortcode_Products_Count_Simulator();
				foreach ($tags as $term) {
					$productCounts[$term->term_id] = $simulator->getSimulatedCount('shopTag', $term->term_id);
				}
			} else {
				$productCounts = array_column($tags, 'count', 'term_id');
			}
		} else {
			$productCounts = null;
		}

		if ( ! empty($tags) ) {
			$this->display_options(
				'tag',
				$this->props['display_as'],
				array_column($tags, 'name', 'term_id'),
				$productCounts,
				null
			);
		}

		$this->filter_section_end();

		return ob_get_clean();

	}

	function attribute_display() {
		if ( $this->props['attribute'] == 'none' ) {
			return '';
		}

		ob_start();

		$this->filter_section_start('shopAttribute_' . $this->props['attribute']);

		$attributeTerms = [];

		$attribute = new \WC_Product_Attribute();
		$attribute->set_id(wc_attribute_taxonomy_id_by_name($this->props['attribute']));
		$attribute->set_name($this->props['attribute']);

		$attribute_taxonomy = $attribute->get_taxonomy_object();

		switch ($this->props['display_as_attribute']) {
			case 'numeric_slider':
			case 'numeric_inputs':
			case 'numeric_slider_inputs':
				$this->display_numeric_range( substr($this->props['display_as_attribute'], 8), $this->props['range_min_attribute'], $this->props['range_max_attribute'] );
				break;
			case 'colors':
				$displaySingular = substr($this->props['display_as_attribute'], 0, -1);
				$args = array(
					'taxonomy'   => sanitize_title($attribute->get_taxonomy()),
					'orderby'    => 'none',
					'hide_empty' => 0,
					'meta_key' => '_dswcp_filter_'.$displaySingular, // $displaySingular must be either "color" or "image", so it's safe
				);
				$all_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', $args));
				if ( is_array($all_terms) ) {
					$terms = [];
					
					if ($this->props['show_number_of_products'] == 'on') {
						if (dscwp_ags_filters_get_count_attributes()) {
							$simulator = new \AGS_WC_Shortcode_Products_Count_Simulator();
							foreach ($all_terms as $term) {
								$productCounts[$term->term_id] = $simulator->getSimulatedCount('shopAttribute_'.$this->props['attribute'], $term->term_id);
							}
						} else {
							$productCounts = array_column($all_terms, 'count', 'term_id');
						}
					} else {
						$productCounts = null;
					}
					
					foreach ($all_terms as &$term) {
						$terms[$term->term_id] = [
							$displaySingular => get_term_meta($term->term_id, '_dswcp_filter_'.$displaySingular, true),
							'label' => $term->name
						];
					}
					$this->display_options(
						'attribute_' . $this->props['attribute'],
						$this->props['display_as_attribute'],
						$terms,
						$productCounts,
						null,
						false,
						$this->props['hide_labels'] == 'on',
						false ,
						$this->props['attr_select_style'],
						$this->props['hide_tooltip'] == 'on'
					);
				}
				break;
			case 'images':
				$displaySingular = substr($this->props['display_as_attribute'], 0, -1);
				$args = array(
					'taxonomy'   => sanitize_title($attribute->get_taxonomy()),
					'orderby'    => 'none',
					'hide_empty' => 0,
					'meta_key' => '_dswcp_filter_'.$displaySingular, // $displaySingular must be either "color" or "image", so it's safe
				);
				$all_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', $args));
				if ( is_array($all_terms) ) {
					$terms = [];
					
					if ($this->props['show_number_of_products'] == 'on') {
						if (dscwp_ags_filters_get_count_attributes()) {
							$simulator = new \AGS_WC_Shortcode_Products_Count_Simulator();
							foreach ($all_terms as $term) {
								$productCounts[$term->term_id] = $simulator->getSimulatedCount('shopAttribute_'.$this->props['attribute'], $term->term_id);
							}
						} else {
							$productCounts = array_column($all_terms, 'count', 'term_id');
						}
					} else {
						$productCounts = null;
					}
					
					foreach ($all_terms as &$term) {
						$terms[$term->term_id] = [
							$displaySingular => get_term_meta($term->term_id, '_dswcp_filter_'.$displaySingular, true),
							'label' => $term->name
						];
					}
					
					$this->display_options(
						'attribute_' . $this->props['attribute'],
						$this->props['display_as_attribute'],
						$terms,
						$productCounts,
						null,
						false,
						$this->props['hide_labels'] == 'on',
						$this->props['display_inline'] == 'on',
						$this->props['attr_select_style'],
						$this->props['hide_tooltip'] == 'on'
					);
				}
				break;
			default:
				$args = array(
					'taxonomy'   => sanitize_title($attribute->get_taxonomy()),
					'orderby'    => ! empty($attribute_taxonomy->attribute_orderby) ? sanitize_title($attribute_taxonomy->attribute_orderby) : 'name',
					'hide_empty' => 0,
				);
				$all_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', $args));
					
				if ( is_array($all_terms) ) {
					
					if ($this->props['show_number_of_products'] == 'on') {
						if (dscwp_ags_filters_get_count_attributes()) {
							$simulator = new \AGS_WC_Shortcode_Products_Count_Simulator();
							foreach ($all_terms as $term) {
								$productCounts[$term->term_id] = $simulator->getSimulatedCount('shopAttribute_'.$this->props['attribute'], $term->term_id);
							}
						} else {
							$productCounts = array_column($all_terms, 'count', 'term_id');
						}
					} else {
						$productCounts = null;
					}
					
					$this->display_options(
						'attribute_' . $this->props['attribute'],
						$this->props['display_as_attribute'],
						array_column($all_terms, 'name', 'term_id'),
						$productCounts,
						null
					);
				}
		}

		$this->filter_section_end();

		return ob_get_clean();

	}
	
	function taxonomy_display() {
		if ( $this->props['taxonomy'] == 'none' ) {
			return '';
		}

		ob_start();

		$this->filter_section_start('shopTaxonomy_' . $this->props['taxonomy']);
		
		$all_terms = get_terms($this->props['taxonomy'], [
			'orderby'    => 'name',
			'hide_empty' => 0,
		]);

		if ( is_array($all_terms) ) {
			
			if ($this->props['show_number_of_products'] == 'on') {
				if (dscwp_ags_filters_get_count_attributes()) {
					$simulator = new \AGS_WC_Shortcode_Products_Count_Simulator();
					foreach ($all_terms as $term) {
						$productCounts[$term->term_id] = $simulator->getSimulatedCount('shopTaxonomy_'.$this->props['taxonomy'], $term->term_id);
					}
				} else {
					$productCounts = array_column($all_terms, 'count', 'term_id');
				}
			} else {
				$productCounts = null;
			}

			
			$this->display_options(
				'taxonomy_' . $this->props['taxonomy'],
				$this->props['display_as'],
				array_column($all_terms, 'name', 'term_id'),
				$productCounts,
				null
			);
		}

		$this->filter_section_end();

		return ob_get_clean();

	}
	
	function search_display() {
		ob_start();

		$this->filter_section_start('shopSearch');

		$classes = ['ags-wc-filters-search-container'];

		if ( $this->props['search_suggestions'] == 'on' ) {
			$classes[] = 'ags-wc-filters-search-with-suggestions';
		}

		if ( $this->props['search_icon'] == 'on' ) {
			$classes[] = 'ags-wc-filters-search-with-icon';
		}

		echo('<div class="' . implode(' ', $classes) . '">
				<div class="ags-wc-filters-search-input-wrapper">
					<input type="search"' . ($this->props['search_placeholder'] == 'on' ? ' placeholder="' . esc_attr($this->props['search_placeholder_text']) . '"' : '') . '">
				</div>
			</div>');

		$this->filter_section_end();

		return ob_get_clean();

	}

	function rating_display() {
		ob_start();

		$this->filter_section_start('shopRating');

		if ( $this->props['display_as_rating'] == 'stars' || $this->props['display_as_rating'] == 'stars_only' ) {

			$starsHtml = '<span class="ags-wc-filters-stars">';
			for ( $i = 0; $i < 5; ++ $i ) {
				$starsHtml .= '<span class="ags-wc-filters-star-empty">' . esc_html(self::STAR) . '</span>';
			}
			$starsHtml .= '</span>';

			echo('<div class="ags-wc-filters-stars-control' . ($this->props['display_as_rating'] == 'stars_only' ? ' ags-wc-filters-stars-control-only' : '') . '" data-value="0">');

			echo(et_core_intentionally_unescaped(str_replace(
				                                     '*****',
				                                     $starsHtml,
				                                     esc_html($this->props[ $this->props['display_as_rating'] == 'stars' ? 'rating_text_and_up' : 'rating_text_only' ])
			                                     ), 'html'));

			echo('</div>');

		} else {
			switch ( $this->props['display_as_rating'] ) {
				case 'radio_stars':
					$displayAs = 'radio_buttons_list';
					$options   = $this->get_rating_options();
					break;
				case 'radio_text':
					$displayAs = 'radio_buttons_list';
					$options   = $this->get_rating_options(false);
					break;
				case 'checkboxes_stars':
					$displayAs = 'checkboxes_list';
					$options   = $this->get_rating_options(true, false);
					break;
				case 'checkboxes_text':
					$displayAs = 'checkboxes_list';
					$options   = $this->get_rating_options(false, false);
					break;
				case 'dropdown_stars':
					$displayAs = 'dropdown_single_select';
					$options   = $this->get_rating_options();
					break;
				case 'dropdown_text':
					$displayAs = 'dropdown_single_select';
					$options   = $this->get_rating_options(false);
					break;
			}

			$this->display_options(
				'rating',
				$displayAs,
				$options,
				null,
				null
			);

		}

		$this->filter_section_end();

		return ob_get_clean();

	}

	function get_rating_options($stars = true, $andUp = true) {
		$options = [];

		for ( $i = 1; $i <= 5; ++ $i ) {
			if ( $stars ) {
				$option = '';
				for ( $j = 0; $j < $i; ++ $j ) {
					$option .= self::STAR;
				}
				for ( ; $j < 5; ++ $j ) {
					$option .= self::STAR_EMPTY;
				}
				if ( $andUp ) {
					$option = str_replace(
						'*****',
						$option,
						$this->props[ $i === 5 ? 'rating_text_only' : 'rating_text_and_up' ]
					);
				}
			} else {
				$option = $this->props[ 'rating_text_' . $i . ($andUp && $i !== 5 ? '_up' : '') ];
			}

			$options[ $i . (($andUp && $i != 5) ? '+' : '') ] = $option;
		}

		return $options;
	}

	function price_display() {
		ob_start();

		$this->filter_section_start('shopPrice');

		$currencySymbol = get_woocommerce_currency_symbol();

		$this->display_numeric_range( $this->props['show_range'], $this->props['range_min'], $this->props['range_max'], $currencySymbol, $this->props['range_min_mode'], $this->props['range_max_mode'] );

		$this->filter_section_end();

		return ob_get_clean();

	}
	
	private function display_numeric_range($style, $min, $max, $currencySymbol=null, $minMode='fallback', $maxMode='fallback') {
		echo('<div class="ags-wc-filters-number-range-container ags-wc-filters-number-range-' . esc_attr($style) . '"'.($currencySymbol ? ' data-currency-symbol="' . esc_attr($currencySymbol) . '"' : '').'>');

		if ( $style != 'inputs' ) {
			echo('<input class="ags-wc-filters-slider">');
		}

		if ( $style == 'slider' ) {
			echo(
				'<input type="number" min="' . ((int) $min) . '" max="' . ((int) $max) . '"'
					.($minMode == 'fallback' ? '' : ' data-min-mode="'.esc_attr($minMode).'"')
					.($maxMode == 'fallback' ? '' : ' data-max-mode="'.esc_attr($maxMode).'"')
					.' class="ags-wc-filters-hidden"><input type="number" class="ags-wc-filters-hidden">'
			);

		} else {

			echo('<div class="ags-wc-filters-number-inputs-wrapper"><label>');
			if ($currencySymbol) {
				echo('<span>' . esc_html($currencySymbol) . '</span>');
			}
			echo(   '<input type="number" min="' . ((int) $min) . '" max="' . ((int) $max) . '"'.($minMode == 'fallback' ? '' : ' data-min-mode="'.esc_attr($minMode).'"').($maxMode == 'fallback' ? '' : ' data-max-mode="'.esc_attr($maxMode).'"').' step="1" title="' . esc_attr__('Minimum value', 'divi-shop-builder') . '">
				</label>
				<span>-</span>
				<label>');
			if ($currencySymbol) {
				echo('<span>' . esc_html($currencySymbol) . '</span>');
			}
			echo(   '<input type="number" min="' . ((int) $min) . '" max="' . ((int) $max) . '"'.' step="1" title="' . esc_attr__('Maximum value', 'divi-shop-builder') . '">
				</label></div>');
		}

		echo('</div>');
	}

	function stock_status_display() {
		ob_start();

		$this->filter_section_start('shopStockStatus');

		$stockStatuses = wc_get_product_stock_status_options();
		
		
		if ($this->props['show_number_of_products'] == 'on') {
			if (dscwp_ags_filters_get_count_attributes()) {
				$simulator = new \AGS_WC_Shortcode_Products_Count_Simulator();
				foreach ($stockStatuses as $statusId => $status) {
					$productCounts[$statusId] = $simulator->getSimulatedCount('shopStockStatus', $statusId);
				}
			} else {
				$productCounts = $stockStatuses;
				array_walk($productCounts, function(&$v, $statusId) {

					$q = new \WP_Query([
										  'post_type'      => 'product',
										  'meta_key'       => '_stock_status',
										  'meta_value'     => $statusId,
										  'fields'         => 'ids',
										  'posts_per_page' => 1
									  ]);

					$v = $q->found_posts;
				});
			}
		} else {
			$productCounts = null;
		}
		
		$this->display_options(
			'stock_status',
			$this->props['display_as'],
			$stockStatuses,
			$productCounts,
			null
		);

		$this->filter_section_end();

		return ob_get_clean();
	}

	function sale_display() {
		ob_start();

		$this->filter_section_start('shopSale');

		$this->display_options(
			'stock_status',
			'checkboxes_list',
			['onsale' => $this->props['sale_text']],
			null,
			null
		);

		$this->filter_section_end();

		return ob_get_clean();
	}
	
}