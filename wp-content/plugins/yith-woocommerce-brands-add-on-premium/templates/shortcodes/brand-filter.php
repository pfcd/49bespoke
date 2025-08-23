<?php
/**
 * Brand Filter shortcode.
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

<div class="yith-wcbr-brand-filter <?php echo esc_attr( $style ); ?>" data-has_more="<?php echo esc_attr( $pagination ); ?>" data-shortcode_options="<?php echo esc_attr( wp_json_encode( $args ) ); ?>" >
	<?php if ( ! empty( $title ) ) : ?>
		<h3><?php echo esc_html( $title ); ?></h3>
	<?php endif; ?>

	<?php if ( 'yes' === $show_filter && ! empty( $available_filters ) ) : ?>
		<div class="yith-wcbr-brand-filters-wrapper">
			<div class="yith-wcbr-brand-filters" <?php echo ( 'highlight' === $style && ! empty( $highlight_color ) ) ? "style='background-color: " . esc_attr( $highlight_color ) . "'" : ''; ?> >
				<?php if ( 'yes' === $show_reset ) : ?>
					<?php
					/**
					 * APPLY_FILTERS: yith_wcbr_filter_reset_label
					 *
					 * Filter the reset label in the Brands Filter.
					 *
					 * @param string $label Label
					 *
					 * @return string
					 */
					?>
					<a href="#" data-toggle="all" class="<?php echo ( empty( $name_like ) || 'all' === $name_like ) ? 'active' : ''; ?> reset"><?php echo esc_html( apply_filters( 'yith_wcbr_filter_reset_label', __( 'All', 'yith-woocommerce-brands-add-on' ) ) ); ?></a>
					<span class="reset-separator"></span>
				<?php endif; ?>
				<?php
				$first = true;

				foreach ( $stack as $letter ) :
					if ( empty( $name_like ) || 'all' === $name_like ) {
						$class = ( $first && 'yes' !== $show_reset ) ? 'active' : '';
					} else {
						$class = $name_like === $letter ? 'active' : '';
					}
					?>
					<a href="#" data-toggle="<?php echo esc_attr( $letter ); ?>" class="<?php echo esc_attr( $class ); ?>"><?php echo esc_attr( $letter ); ?></a>
					<?php
					$first = false;
				endforeach;
				?>
			</div>
		</div>
	<?php endif; ?>

	<div class="yith-wcbr-brands-list">
		<?php if ( ! empty( $terms ) ) : ?>
			<ul>
				<?php foreach ( $terms as $p_term ) : ?>
					<li data-heading="<?php echo isset( $p_term->heading ) ? esc_attr( $p_term->heading ) : ''; ?>">
						<a href="<?php echo esc_url( get_term_link( $p_term ) ); ?>">
							<?php echo esc_html( $p_term->name ); ?>
							<?php if ( 'yes' === $show_count ) : ?>
								<span class="brand-count" <?php echo ( 'highlight' === $style && ! empty( $highlight_color ) ) ? "style='background-color:" . esc_attr( $highlight_color ) . "'" : ''; ?> ><?php echo esc_html( $p_term->count ); ?></span>
							<?php endif; ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

	<?php if ( isset( $page_links ) ) : ?>
		<nav class="yith-wcbr-brands-pagination woocommerce-pagination">
			<?php echo $page_links; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</nav>
	<?php endif; ?>
</div>

<?php wp_enqueue_script( 'yith-wcbr' ); ?>
