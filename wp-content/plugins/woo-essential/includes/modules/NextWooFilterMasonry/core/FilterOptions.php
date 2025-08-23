<?php
/**
 * Filtering Options
 */
namespace DNWoo_Essential\Includes\Modules\NextWooFilterMasonry;

defined( 'ABSPATH' ) || die();

class FilterOptions {


	public function filter_attribute( $args ) {
		extract($args);// phpcs:ignore
		$html = '';
		if ( $control == 'no' ) {
			return $html;
		}

		if (!empty($title)) {
			$html .= '<h3 class="dnwoo_product_filter_sidebar_heading">'.$title.'</h3>';
		}

		$get_attr = get_attributes( $type  );
		
		if ( ! empty( $get_attr['terms'] ) ) {
			$html .='<div class="options-section options-wrapper">';
			foreach ( $get_attr['terms'] as $key => $value ) {
				if ( ! empty( $value->name ) ) {
					$html .= '
						<div class="attribute-item" title="'.esc_attr( $value->name ).'"
							data-term_id="'.esc_attr( $value->term_id ).'"
							data-taxonomy="'.esc_attr( $value->taxonomy ).'"
							data-name="'.esc_attr( $value->name ).'"
							data-slug="'.esc_attr( $value->slug ).'"
							style="background-color: '.esc_attr( strtolower( $value->name ) ).'">
							'.esc_html($value->name).'
						</div>';
						
				}
			}
			$html .='</div>'.$this->reset_html($show_reset, $reset_text);
		}

		return $html;
	}

	/**
	 * single reset of reset_html
	 * @param mixed $show_reset
	 * @return string
	 */
	public function reset_html($show_reset, $reset_text = 'Reset') {
		return $show_reset == 'on' ? '<div class="filter-reset d-none">'.$reset_text.'</div>' : '';
	}

	/**
	 * Category Filter Options
	 *
	 * @param mixed $settings
	 * @param mixed $show_sub_categories
	 * @return string
	 */
	public function category_filter( $args ) {
		extract($args);// phpcs:ignore
		$category_html = '';
		$show_filter_all_text ='';
		if ( $show_all_text_field == 'on') {
			if ($category_style == 'list' ) {
				$show_filter_all_text = 
				sprintf( '<li class="dnwo-'.esc_attr($category_style).' all_categories active" data-filter="all">
				<input type="checkbox"  id="'.esc_attr($order_class.'all_categories').'" >
				<label for="'.esc_attr($order_class.'all_categories').'">%1$s</lab></li>', 
				esc_html__( $dnwoo_category_all_text, 'dnwooe' ) ) ;
			}else{
				$show_filter_all_text = 
				sprintf( '<li class="all_categories active" data-filter="all">
				<input type="checkbox" id="'.esc_attr($order_class.'all_categories').'"/>
				<label class="" for="'.esc_attr($order_class.'all_categories').'">%1$s</lab></li>', 
				esc_html__( $dnwoo_category_all_text, 'dnwooe' ) ) ;
			}
		}
		
		$categories    = get_included_categories( 
			array('include_categories'=>$include_categories,
            'order'=>$order,'orderby'=>$orderby) );
		$categories_heading = '';
		$single_reset = '';
		if ($show_filter_menu !== 'default' ) {
			$single_reset = $this->reset_html($show_reset, $reset_text);
		}
		if('default' !== $show_filter_menu){
			$categories_heading = sprintf( '<h3 class="dnwoo_product_filter_sidebar_heading">%1$s %2$s</h3>',$dnwoo_category_title , $single_reset ); 
		}

		if (is_array($categories) && count( $categories ) > 0 ) {
			$category_html .= '
			<div class="category-wrapper">
			'.$categories_heading.'
			<ul class="options-section dnwoo_product_filter_menu" data-single="'.esc_attr($single).'">'.$show_filter_all_text;
				foreach ( $categories as $key => $value ) {
					if ($show_filter_menu == 'default' ) {
						$category_html .= sprintf(
							'<li data-filter=".%1$s" 
								data-id=' . esc_attr( $value->term_id ) . ' class="">
								<span class="'.esc_attr($category_style).' check-item">%2$s</span>
								</li>',
							esc_attr( urldecode( $value->slug ) ),
							esc_html( $value->name )
						);
	
					} else {
						$parent_class = ( 'on' == $show_sub_categories  && ! empty( $value->sub_categories ) ) ? 'parent ' : '';
						$category_html .= sprintf(
							'<li data-filter=".%1$s" 
						data-id=' . esc_attr( $value->term_id ) . ' class="' . esc_attr( $parent_class .'dnwo-'.$category_style ) . '">
						<input
							type="checkbox"
							id="' . esc_attr( $order_class.$value->slug ) . '"
						/>
						<label class="check-item" for="' . esc_attr( $order_class.$value->slug ) . '">%2$s</label>
						</li>',
							esc_attr( urldecode( $value->slug ) ),
							esc_html( $value->name )
						);
	
						if ( 'on' == $show_sub_categories ) {
							$child_html = '';
							if ( ! empty( $value->sub_categories ) ) {
								$child_html .= '<ul class="sub_categories">';
								foreach ( $value->sub_categories as $index => $chlild ) {
									$child_html .= '<li 
									data-filter=".' . esc_attr( urldecode( $chlild->slug ) ) . '"
									data-id="' . esc_attr( $chlild->term_id ) . '"
									data-parent=".' . esc_attr( $value->slug ) . '"
									class="' . esc_attr( 'dnwo-'.$category_style ) . '"
									>
									<input
										type="checkbox"
										id="sub-' . esc_attr( $order_class.$chlild->slug ) . '"
									/>
									<label  class="check-item" for="sub-' . esc_attr( $order_class.$chlild->slug ) . '">' . esc_html( $chlild->name ) . '</label>
									</li>';
								}
								$child_html .= '</ul>';
							}
	
							$category_html .= $child_html;
						}
					}
					

				}
			$category_html .= '</ul>';
		}

		return $category_html  . '</div>';
	}

	/**
	 * Review Filter Options
	 *
	 * @param mixed $settings
	 * @param mixed $show_reviews
	 * @return string
	 */
	public function review_filter( $show_reset, $show_reviews, $reset_text, $rating_text) {
		if ( $show_reviews == 'off' ) {
			return '';
		}

		$single_reset = $this->reset_html($show_reset, $reset_text);
		$review_html  = '<h3 class="dnwoo_product_filter_sidebar_heading">' . $rating_text . $single_reset . '</h3>';
		$review_html .= '
		<ul class="options-section ratings">';
		for ( $i = 5; $i >= 1; $i-- ) {
			$review_html .= $this->rating_html( $i, 1 );
		}
		$review_html .= '</ul>';

		return $review_html;
	}

	/**
	 * Admin pages array
	 */
	public function rating_html( $star, $template = '1' ) {
		$rating       = '
		<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="15" height="15" viewBox="0 0 256 256" xml:space="preserve">
			<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
				<path class="rating" d="M 47.755 3.765 l 11.525 23.353 c 0.448 0.907 1.313 1.535 2.314 1.681 l 25.772 3.745 c 2.52 0.366 3.527 3.463 1.703 5.241 L 70.42 55.962 c -0.724 0.706 -1.055 1.723 -0.884 2.72 l 4.402 25.667 c 0.431 2.51 -2.204 4.424 -4.458 3.239 L 46.43 75.47 c -0.895 -0.471 -1.965 -0.471 -2.86 0 L 20.519 87.588 c -2.254 1.185 -4.889 -0.729 -4.458 -3.239 l 4.402 -25.667 c 0.171 -0.997 -0.16 -2.014 -0.884 -2.72 L 0.931 37.784 c -1.824 -1.778 -0.817 -4.875 1.703 -5.241 l 25.772 -3.745 c 1.001 -0.145 1.866 -0.774 2.314 -1.681 L 42.245 3.765 C 43.372 1.481 46.628 1.481 47.755 3.765 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
			</g>
		</svg>
		';
		$rating_light = '
		<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="15" height="15" viewBox="0 0 256 256" xml:space="preserve">
			<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
				<path class="rating_light" d="M 47.755 3.765 l 11.525 23.353 c 0.448 0.907 1.313 1.535 2.314 1.681 l 25.772 3.745 c 2.52 0.366 3.527 3.463 1.703 5.241 L 70.42 55.962 c -0.724 0.706 -1.055 1.723 -0.884 2.72 l 4.402 25.667 c 0.431 2.51 -2.204 4.424 -4.458 3.239 L 46.43 75.47 c -0.895 -0.471 -1.965 -0.471 -2.86 0 L 20.519 87.588 c -2.254 1.185 -4.889 -0.729 -4.458 -3.239 l 4.402 -25.667 c 0.171 -0.997 -0.16 -2.014 -0.884 -2.72 L 0.931 37.784 c -1.824 -1.778 -0.817 -4.875 1.703 -5.241 l 25.772 -3.745 c 1.001 -0.145 1.866 -0.774 2.314 -1.681 L 42.245 3.765 C 43.372 1.481 46.628 1.481 47.755 3.765 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
			</g>
		</svg>
		';

		$html = '<li data-id=' . $star . "><span class='rating_block rate_" . $template . "'>";
		for ( $i = 0; $i < 5; $i++ ) {
			if ( $star == 5 ) {
				$html .= $rating;
			}
			if ( $star == 4 ) {
				if ( $i > 3 ) {
					$html .= $rating_light;
				} else {
					$html .= $rating;
				}
			}
			if ( $star == 3 ) {
				if ( $i > 2 ) {
					$html .= $rating_light;
				} else {
					$html .= $rating;
				}
			}
			if ( $star == 2 ) {
				if ( $i > 1 ) {
					$html .= $rating_light;
				} else {
					$html .= $rating;
				}
			}
			if ( $star == 1 ) {
				if ( $i > 0 ) {
					$html .= $rating_light;
				} else {
					$html .= $rating;
				}
			}
		}
		$html .= '</span>
		</li>';

		return $html;
	}
}
