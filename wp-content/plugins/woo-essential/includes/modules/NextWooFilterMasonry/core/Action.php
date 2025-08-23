<?php
/**
 * Return filtered data
 */
namespace DNWoo_Essential\Includes\Modules\NextWooFilterMasonry;

defined( 'ABSPATH' ) || die();

require_once DNWOO_ESSENTIAL_PATH . '/includes/modules/NextWooFilterMasonry/core/Templates.php';
class Action {

	public function init() {
		$callback = array( 'get_filtered_data' );
		if ( ! empty( $callback ) ) {
			foreach ( $callback as $key => $value ) {
				add_action( 'wp_ajax_nopriv_' . $value, array( $this, $value ) );
				add_action( 'wp_ajax_' . $value, array( $this, $value ) );
			}
		}
	}

	public function get_filtered_data() {
		$query                 = filter_input_array( INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS );
		$query['request_from'] = 'ajax-call';
		if ( ! empty( $query['rating'] ) ) {
			$query['meta_query'] = array(
				array(
					'key'     => '_wc_average_rating',
					'value'   => $query['rating'],
					'compare' => '=',
					'type'    => 'NUMERIC',
				),
			);
		}
		// attribute
		if ( ! empty( $query['taxonomies'] ) ) {
			$query['tax_query'] = array();
			foreach ( $query['taxonomies'] as $key => $attribute ) {
				foreach ($attribute as $index => $item) {
					$taxonomy = array(
						'taxonomy' => $item['taxonomy'],
						'field'    => 'id',
						'terms'    => $item['term_id'],
					);
					array_push( $query['tax_query'] , $taxonomy );
				}
			}

		}

		$products = dnwoo_query_products( $query );
		$results  = $this->render_html( $products, $query );
		wp_send_json_success(
			array(
				'products' 		=> $results['products'],
				'pagination' 	=> $results['pagination'],
				'total'    		=> $products['total'],
				'pages'    		=> $products['pages'],
			)
		);
		wp_die();
	}

	public function render_html( $products, $query ) {
		if ( empty( $products['products'] ) ) {
			$no_item_found = esc_html__( 'No item found', 'dnwooe' );
			return array(
				'products' 		=> sprintf('<div class="no_result">%1$s</div>',$no_item_found),
				'pagination' 	=> ''
			);
		}

		$templates     = new Templates();
		$products_html = $templates->products_html( $products['products'], $query );
		$pagination    = $templates->pagination(
			array(
				'pages'    => $products['pages'],
				'offset'   => (int) ( $query['offset'] == 0 ? 1 : $query['offset'] ),
				'alingment_class' => $query['pagination_alignment'],
				'template' => $query['show_pagination'],
			)
		);
		return array(
			'products' 		=> sprintf('<div class="grid-sizer"></div><div class="gutter-sizer"></div>%1$s',$products_html),
			'pagination' 	=> $pagination
		);
	}

}
