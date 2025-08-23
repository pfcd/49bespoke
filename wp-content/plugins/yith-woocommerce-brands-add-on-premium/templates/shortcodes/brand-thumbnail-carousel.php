<?php
/**
 * Brand Thumbnails Carousel shortcode.
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

<div class="woocommerce yith-wcbr-brand-thumbnail-carousel <?php echo esc_attr( $style ); ?> <?php echo esc_attr( $direction ); ?>">
	<div class="yith-wcbr-carousel-title">
		<?php if ( ! empty( $title ) ) : ?>
			<h3><?php echo esc_html( $title ); ?></h3>
		<?php endif; ?>
	</div>

	<?php if ( 'shadow' === $style ) : ?>
		<div class="yith-wcbr-carousel-pagination-wrapper">
			<?php if ( 'yes' === $pagination ) : ?>
				<div class="yith-wcbr-pagination <?php echo esc_attr( $pagination_style ); ?>"></div>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="yith-wcbr-thumbnail-list swiper-container" data-slidesperview="<?php echo esc_attr( $cols ); ?>" data-direction="<?php echo esc_attr( $direction ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>" data-loop="<?php echo esc_attr( $loop ); ?>">
		<?php if ( ! empty( $terms ) ) : ?>
			<ul class="swiper-wrapper">
			<?php
			foreach ( $terms as $p_term ) :
				?>
				<li class="swiper-slide">
					<?php
					$thumbnail_id = absint( yith_wcbr_get_term_meta( $p_term->term_id, 'thumbnail_id', true ) );

					if ( $thumbnail_id ) {
						/**
						 * APPLY_FILTERS: yith_wcbr_thumbnail_image
						 *
						 * Filter the array with the brand image data.
						 *
						 * @param array $img_data     Image data
						 * @param int   $thumbnail_id Brand thumbnail ID
						 *
						 * @return array
						 */
						$image = apply_filters( 'yith_wcbr_thumbnail_image', wp_get_attachment_image_src( $thumbnail_id, 'yith_wcbr_grid_logo_size' ), $thumbnail_id );

						if ( $image ) {
							$output = sprintf( '<a href="%s" title="%s"><img src="%s" width="%d" height="%d" alt="%s"/>', get_term_link( $p_term ), $p_term->name, $image[0], $image[1], $image[2], $p_term->name );

							if ( 'yes' === $show_name || 'yes' === $show_rating ) {
								$output .= '<div class="brand-info">';

								if ( 'yes' === $show_name ) {
									$output .= $p_term->name;
								}

								if ( 'yes' === $show_rating ) {
									$output .= YITH_WCBR_Premium()->get_average_term_rating_html( $p_term->term_id );
								}

								$output .= '</div>';
							}

							$output .= '</a>';

							echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
						do_action( 'yith_wcbr_no_brand_logo', $p_term->term_id, $p_term, 'yith_wcbr_grid_logo_size', 'yes' === $show_name, 'yes' === $show_rating );
					} else {
						?>
						<a href="<?php echo esc_url( get_term_link( $p_term ) ); ?>">
							<?php echo esc_html( $p_term->name ); ?>

							<?php if ( 'yes' === $show_name || 'yes' === $show_rating ) : ?>
								<div class="brand-info">
									<?php if ( 'yes' === $show_name ) : ?>
										<?php echo esc_html( $p_term->name ); ?>
									<?php endif; ?>

									<?php if ( 'yes' === $show_rating ) : ?>
										<?php echo YITH_WCBR_Premium()->get_average_term_rating_html( $p_term->term_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</a>
						<?php
					}
					?>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

	<?php if ( 'shadow' !== $style ) : ?>
		<div class="yith-wcbr-carousel-pagination-wrapper">
			<?php if ( 'yes' === $prev_next && 'background' === $style ) : ?>
				<div class="yith-wcbr-button-prev <?php echo esc_attr( $prev_next_style ); ?>"></div>
			<?php endif; ?>

			<?php if ( 'yes' === $pagination ) : ?>
				<div class="yith-wcbr-pagination <?php echo esc_attr( $pagination_style ); ?>"></div>
			<?php endif; ?>

			<?php if ( 'yes' === $prev_next && 'background' === $style ) : ?>
				<div class="yith-wcbr-button-next <?php echo esc_attr( $prev_next_style ); ?>"></div>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if ( 'yes' === $prev_next && 'background' !== $style ) : ?>
		<div class="yith-wcbr-button-wrapper">
			<div class="yith-wcbr-button-prev <?php echo esc_attr( $prev_next_style ); ?>"></div>
			<div class="yith-wcbr-button-next <?php echo esc_attr( $prev_next_style ); ?>"></div>
		</div>
	<?php endif; ?>
</div>

<?php wp_enqueue_script( 'yith-wcbr' ); ?>
