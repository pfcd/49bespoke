<?php
defined('ABSPATH') || die();

class DSWCP_Shortcode_Products extends WC_Shortcode_Products {
	
	protected function parse_attributes( $attributes ) {
		$attributes = $this->parse_legacy_attributes( $attributes );

		$attributes = shortcode_atts(
			array(
				'limit'          => '-1',      // Results limit.
				'columns'        => '',        // Number of columns.
				'rows'           => '',        // Number of rows. If defined, limit will be ignored.
				'orderby'        => '',        // menu_order, title, date, rand, price, popularity, rating, or id.
				'order'          => '',        // ASC or DESC.
				'ids'            => '',        // Comma separated IDs.
				'skus'           => '',        // Comma separated SKUs.
				'category'       => '',        // Comma separated category slugs or ids.
				'cat_operator'   => 'IN',      // Operator to compare categories. Possible values are 'IN', 'NOT IN', 'AND'.
				'attribute'      => '',        // Single attribute slug.
				'terms'          => '',        // Comma separated term slugs or ids.
				'terms_operator' => 'IN',      // Operator to compare terms. Possible values are 'IN', 'NOT IN', 'AND'.
				'tag'            => '',        // Comma separated tag slugs.
				'tag_field'      => '',        // Change the field to use for tag lookup.
				'tag_operator'   => 'IN',      // Operator to compare tags. Possible values are 'IN', 'NOT IN', 'AND'.
				'visibility'     => 'visible', // Product visibility setting. Possible values are 'visible', 'catalog', 'search', 'hidden'.
				'class'          => '',        // HTML class.
				'page'           => 1,         // Page for pagination.
				'paginate'       => false,     // Should results be paginated.
				'cache'          => true,      // Should shortcode output be cached.
				
				'custom_taxonomy' => '',       // Single custom taxonomy slug.
				'custom_taxonomy_terms' => '', // Comma separated term IDs.
				'custom_taxonomy_terms_operator' => 'IN', // Operator to compare terms. Possible values are 'IN', 'NOT IN', 'AND'.
			),
			$attributes,
			$this->type
		);

		if ( ! absint( $attributes['columns'] ) ) {
			$attributes['columns'] = wc_get_default_products_per_row();
		}

		return $attributes;
	}
	
	// Hijack this function to also process custom taxonomy args
	protected function set_tags_query_args( &$query_args ) {
		parent::set_tags_query_args( $query_args );
		
		if (!empty($this->attributes['tag']) && !empty($this->attributes['tag_field'])) {
			$lastTaxQuery = array_pop($query_args['tax_query']);
			$lastTaxQuery['field'] = $this->attributes['tag_field'];
			array_push($query_args['tax_query'], $lastTaxQuery);
		}
		
		if ( ! empty( $this->attributes['custom_taxonomy'] ) && in_array($this->attributes['custom_taxonomy_terms_operator'], ['IN', 'NOT IN', 'AND']) ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => sanitize_text_field($this->attributes['custom_taxonomy']),
				'terms'    => array_map( 'absint', is_array($this->attributes['custom_taxonomy_terms']) ? $this->attributes['custom_taxonomy_terms'] : explode( ',', $this->attributes['custom_taxonomy_terms'] ) ),
				'field'    => 'term_id',
				'operator' => $this->attributes['custom_taxonomy_terms_operator'], // must be IN, NOT IN, or AND per the check above
			);
		}
	}
	
}