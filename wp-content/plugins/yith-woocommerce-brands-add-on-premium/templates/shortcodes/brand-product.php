<?php
/**
 * Brand Products shortcode.
 *
 * @author  YITH <plugins@yithemes.com>
 *
 * @package YITH\Brands\Templates
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

global $wpdb, $woocommerce, $woocommerce_loop;

?>

<div class="woocommerce yith-wcbr-product">
	<div class="yith-wcbr-title">
		<?php if ( ! empty( $title ) ) : ?>
			<h2><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>
	</div>

	<?php if ( 'yes' === $show_brand_box && isset( $brand ) && 'all' !== $brand ) : ?>
		<div class="yith-wcbr-brand-box">
			<h3>
				<?php
				/**
				 * APPLY_FILTERS: yith_wcbr_brands_box_title
				 *
				 * Filter the title in the Brand Product.
				 *
				 * @param string $title Title
				 *
				 * @return string
				 */
				echo esc_attr( apply_filters( 'yith_wcbr_brands_box_title', __( 'Products in Brands', 'yith-woocommerce-brands-add-on' ) ) );
				?>
			</h3>

			<p>
				<?php
				$brand_array = explode( ',', $brand );
				$brand_links = array();

				if ( ! empty( $brand_array ) ) {
					foreach ( $brand_array as $elem ) {
						$p_term = get_term_by( 'slug', $elem, YITH_WCBR::$brands_taxonomy );

						if ( ! is_wp_error( $p_term ) && $p_term ) {
							$brand_links[] = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $p_term, YITH_WCBR::$brands_taxonomy ) ), esc_html( $p_term->name ) );
						}
					}
				}

				echo implode( ', ', $brand_links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</p>
		</div>
	<?php endif; ?>

	<div class="yith-wcbr-product-list row">
		<?php if ( $products->have_posts() ) : ?>
			<ul class="products <?php echo ! empty( $cols ) ? 'columns-' . esc_attr( $cols ) : ''; ?>">
				<?php
				while ( $products->have_posts() ) :
					$products->the_post();

					wc_set_loop_prop( 'columns', $cols );
					wc_get_template( 'content-product.php', array( 'product_in_a_row' => $cols ) );
				endwhile; // end of the loop.
				?>
			</ul>
		<?php endif; ?>
	</div>

	<nav class="yith-wcbr-brands-pagination woocommerce-pagination">
		<?php
		if ( isset( $page_links ) ) {
			echo $page_links; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</nav>
</div>

<?php wp_reset_postdata(); ?>
