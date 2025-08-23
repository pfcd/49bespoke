<?php
/**
 * Brand Grid Loop shortcode.
 *
 * @author  YITH <plugins@yithemes.com>
 *
 * @package YITH\Brands\Templates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

?>

<li style="width: <?php echo esc_attr( $cols_width ); ?>%" class="<?php echo esc_attr( $classes ); ?>" data-categories="<?php echo esc_attr( wp_json_encode( isset( $brand_category ) ? $brand_category : array() ) ); ?>" >
	<?php
	$term_link = get_term_link( $p_term );

	if ( 'category' === $show_filtered_by && 'yes' === $use_filtered_urls && $filter ) {
		$category  = get_term( $filter, 'product_cat' );
		$term_link = add_query_arg( 'product_cat', $category->slug, $term_link );
	}

	if ( 'yes' === $show_image ) {
		$thumbnail_id = absint( yith_wcbr_get_term_meta( $p_term->term_id, 'thumbnail_id', true ) );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, 'yith_wcbr_grid_logo_size' );

			if ( $image ) {
				echo sprintf( '<a href="%s" title="%s"><img src="%s" width="%d" height="%d" alt="%s"/></a>', esc_url( $term_link ), esc_attr( $p_term->name ), esc_attr( $image[0] ), esc_attr( $image[1] ), esc_attr( $image[2] ), esc_attr( $p_term->name ) );
			}
		} elseif ( 'yes' === get_option( 'yith_wcbr_use_logo_default' ) ) {
			/**
			 * DO_ACTION: yith_wcbr_no_brand_logo
			 *
			 * Allows to render some content or fire some action when the brand has no logo.
			 *
			 * @param int     $term_id         Term ID
			 * @param WP_Term $term            Term object
			 * @param string  $image_size      Image size
			 * @param bool    $show_term_name  Whether to show the brand name
			 * @param bool    $show_avg_rating Whether to show the brand rating
			 */
			do_action( 'yith_wcbr_no_brand_logo', $p_term->term_id, $p_term, 'yith_wcbr_grid_logo_size', false, false );
		} else {
			echo sprintf( '<a href="%s">%s</a>', esc_url( $term_link ), esc_html( $p_term->name ) );
		}
	}

	if ( 'yes' === $show_name ) {
		$name = sprintf( '<a href="%s">%s', esc_url( $term_link ), $p_term->name );

		if ( 'yes' === $show_count ) {
			$name .= sprintf( ' (%d)', $p_term->count );
		}

		$name .= '</a>';

		echo $name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	?>
</li>
