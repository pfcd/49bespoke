<?php
/**
 * Brand Products Carousel shortcode.
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

add_filter( 'post_class', 'yith_wcbr_add_slider_post_class' );

?>

<div class="woocommerce yith-wcbr-product-carousel <?php echo esc_attr( $style ); ?>">
	<div class="yith-wcbr-carousel-title">
		<?php if ( ! empty( $title ) ) : ?>
			<h2><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>
	</div>

	<?php if ( 'yes' === $show_brand_box && ! empty( $brand ) && 'all' !== $brand ) : ?>
		<div class="yith-wcbr-carousel-brand-box">
			<h3>
				<?php
				/**
				 * APPLY_FILTERS: yith_wcbr_brands_box_title
				 *
				 * Filter the title in the Brands Product Carousel.
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

						if ( ! $p_term || is_wp_error( $p_term ) ) {
							continue;
						}
						$brand_links[] = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $p_term, YITH_WCBR::$brands_taxonomy ) ), esc_html( $p_term->name ) );
					}
				}

				echo implode( ', ', $brand_links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</p>
		</div>
	<?php endif; ?>

	<div class="yith-wcbr-product-list swiper-container row" data-slidesperview="<?php echo esc_attr( $cols ); ?>" data-direction="<?php echo esc_attr( $direction ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>" data-loop="<?php echo esc_attr( $loop ); ?>">
		<?php if ( $products->have_posts() ) : ?>
			<ul class="products swiper-wrapper <?php echo ! empty( $cols ) ? 'columns-' . esc_attr( $cols ) : ''; ?>">
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

	<?php if ( 'yes' === $pagination ) : ?>
		<div class="yith-wcbr-carousel-pagination-wrapper">
			<div class="yith-wcbr-pagination <?php echo esc_attr( $pagination_style ); ?>"></div>
		</div>
	<?php endif; ?>

	<?php if ( 'yes' === $prev_next ) : ?>
		<div class="yith-wcbr-button-wrapper">
			<div class="yith-wcbr-button-prev <?php echo esc_attr( $prev_next_style ); ?>"></div>
			<div class="yith-wcbr-button-next <?php echo esc_attr( $prev_next_style ); ?>"></div>
		</div>
	<?php endif; ?>
</div>

<?php
remove_filter( 'post_class', 'yith_wcbr_add_slider_post_class' );
wp_reset_postdata();
wp_enqueue_script( 'yith-wcbr' );
