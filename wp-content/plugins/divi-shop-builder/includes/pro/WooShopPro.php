<?php
defined('ABSPATH') || exit;

class DSWCP_Woo_Shop_Pro {
	
	static function setup() {
		add_filter('dswcp_woo_shop_module_fields', [__CLASS__, 'filterWooShopModuleFields']);
		add_filter('dswcp_woo_shop_shortcode_args', [__CLASS__, 'filterWooShopShortcodeArgs'], 10, 3);
		add_filter('dswcp_woo_shop_shortcode_args', [__CLASS__, 'filterWooShopWhitelistedCountAttributes'], 10, 2);
		add_filter('dswcp_woo_shop_item_types', [__CLASS__, 'filterWooShopItemTypes']);
		add_filter('dswcp_woo_shop_item_actions', [__CLASS__, 'filterWooShopItemActions']);
		add_filter('dswcp_woo_shop_child_order', [__CLASS__, 'filterWooShopChildOrder'], 10, 2);
	}
	
	static function filterWooShopModuleFields($fields) {
		$attributeOptions = array_column(wc_get_attribute_taxonomies(), 'attribute_label', 'attribute_id');

		$fields['type']['options']['product_attribute'] = esc_html__( 'Product Attribute', 'divi-shop-builder' );
		
		$newFields = [];
		foreach ($fields as $fieldId => $field) {
			$newFields[$fieldId] = $field;
			
			switch ($fieldId) {
				case 'include_tags':
					$newFields['include_attribute'] = [
						'label'            => esc_html__( 'Attribute', 'divi-shop-builder' ),
						'type'             => 'select',
						'options'          => $attributeOptions,
						'default'          => key($attributeOptions),
						'show_if'  => ['type' => 'product_attribute'],
						'description'      => esc_html__( 'Choose the product attribute from which you would like to select values for inclusion.', 'divi-shop-builder' ),
						'toggle_slug'      => 'wc_ags_archive',
						'computed_affects' => array(
							'__shop',
						),
					];
					$newFields['include_attribute_values'] = [
						'label'            => esc_html__( 'Attribute Values', 'divi-shop-builder' ),
						'type'             => 'WPZTermSelect-DSB',
						'attribute_field' => 'include_attribute',
						'show_if'  => ['type' => 'product_attribute'],
						'description'      => esc_html__( 'Select the values of the product attribute that products must have in order to be shown.', 'divi-shop-builder' ),
						'toggle_slug'      => 'wc_ags_archive',
						'computed_affects' => array(
							'__shop',
						),
					];
					break;
			}
		}
		
		return $newFields;
	}
	
	
	static function filterWooShopShortcodeArgs($args, $moduleProps, $viewType) {
		if ('product_attribute' === $viewType) {
			$args['custom_taxonomy'] = wc_attribute_taxonomy_name_by_id((int) $moduleProps['include_attribute'] ?? 0);
			$args['custom_taxonomy_terms'] = empty($moduleProps['include_attribute_values']) ? [] : array_map('absint', explode(',', $moduleProps['include_attribute_values']));
		}
		return $args;
	}
	
	static function filterWooShopWhitelistedCountAttributes($shortcodeAttributes, $countAttributes) {
		if ( (!isset($countAttributes['use_current_loop']) || $countAttributes['use_current_loop'] !== 'on') && isset($countAttributes['type']) && $countAttributes['type'] == 'product_attribute' ) {
			$shortcodeAttributes['type'] = 'product_attribute';
			$shortcodeAttributes['include_attribute'] = isset($countAttributes['include_attribute']) ? $countAttributes['include_attribute'] : '';
			$shortcodeAttributes['include_attribute_values'] = isset($countAttributes['include_attribute_values']) ? $countAttributes['include_attribute_values'] : '';
		}
		return $shortcodeAttributes;
	}
	
	static function filterWooShopItemTypes($types) {
		$types['attribute'] = esc_html__( 'Product Attribute', 'divi-shop-builder' );
		$types['taxonomy'] = esc_html__( 'Custom Product Taxonomy', 'divi-shop-builder' );
		return $types;
	}
	
	static function filterWooShopItemActions($itemActions) {
		$itemActions['attribute'] = [
			[ array( __CLASS__, 'ags_divi_wc_show_product_attribute' ) ]
		];
		$itemActions['taxonomy'] = [
			[ array( __CLASS__, 'ags_divi_wc_show_product_taxonomy' ) ]
		];
		return $itemActions;
	}
	
	static function ags_divi_wc_show_product_attribute($params) {
		if (isset($params['attribute'])) {
			self::_ags_divi_wc_show_product_taxonomy($params['attribute'], isset($params['separator']) ? $params['separator'] : ', ', isset($params['format']) ? $params['format'] : '%s');
		}
	}
	
	static function ags_divi_wc_show_product_taxonomy($params) {
		if (isset($params['taxonomy'])) {
			self::_ags_divi_wc_show_product_taxonomy($params['taxonomy'], isset($params['separator']) ? $params['separator'] : ', ', isset($params['format']) ? $params['format'] : '%s');
		}
	}
	
	private static function _ags_divi_wc_show_product_taxonomy($taxonomy, $separator, $format)
	{
		global $post;
		$terms = get_terms( ['taxonomy' => $taxonomy, 'object_ids' => $post->ID, 'hide_empty' => false, 'fields' => 'names'] );
		if (is_array($terms)) {
			echo '<span class="product-taxonomy product-taxonomy-'.esc_attr(sanitize_key($taxonomy)).'">' . esc_html(str_replace('%s', implode($separator, $terms), $format)) . '</span>';
		}
	}
	
	static function filterWooShopChildOrder($childOrder, $options) {
		if ( isset($options['layout']) && $options['layout'] == 'list' ) {

			$hasImage = isset( $options['thumbnail'] ) && $options['thumbnail'];

			$childOrder = ['row-start'];

			if ( isset( $options['sale_flash'] ) && $options['sale_flash'] ) {
				$childOrder[] = 'sale-badge';
			}

			if ( isset( $options['percentage_sale_flash'] ) && $options['percentage_sale_flash'] ) {
				$childOrder[] = 'percentage-sale-badge';
			}

			if ( isset( $options['new_badge'] ) && $options['new_badge'] ) {
				$childOrder[] = 'new-badge';
			}

			if ( $hasImage ) {

				$childOrder[] = 'image';

				$childOrder[] = 'column-break';

			} else {
				$itemActions['row-start'][0][0][1] = 'ags_divi_wc_reset_column_number_2';
			}


			$childOrder[] = 'title';

			if ( isset( $options['rating'] ) && $options['rating'] ) {
				$childOrder[] = 'ratings';
			}

			$childOrder[] = 'excerpt';

			if ( isset( $options['categories'] ) && $options['categories'] ) {
				$childOrder[] = 'categories';
			}

			$childOrder[] = 'column-break';

			if ( isset( $options['price'] ) && $options['price'] ) {
				$childOrder[] = 'price';
			}

			if ( isset( $options['stock'] ) && $options['stock'] ) {
				$childOrder[] = 'stock';
			}

			if ( isset( $options['quantity'] ) && $options['quantity'] ) {
				$childOrder[] = 'quantity';
			}

			if ( isset( $options['add_to_cart'] ) && $options['add_to_cart'] ) {
				$childOrder[] = 'button';
			}

			$childOrder[] = 'row-end';
		}
		
		return $childOrder;
	}
	
}

DSWCP_Woo_Shop_Pro::setup();