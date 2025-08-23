<?php
/**
 * Brand Select shortcode.
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

<div class="yith-wcbr-brand-select">
	<?php if ( ! empty( $title ) ) : ?>
		<h3><?php echo esc_html( $title ); ?></h3>
	<?php endif; ?>

	<div class="yith-wcbr-brands-list">
		<?php if ( ! empty( $terms ) ) : ?>
			<select class="yith-wcbr-select">
				<option value=""><?php esc_html_e( 'All', 'yith-woocommerce-brands-add-on' ); ?></option>
				<?php foreach ( $terms as $p_term ) : ?>
					<option data-href="<?php echo esc_url( get_term_link( $p_term ) ); ?>" value="<?php echo esc_attr( $p_term->term_id ); ?>">
						<?php echo esc_html( $p_term->name ); ?>
						<?php
						if ( 'yes' === $show_count ) :
							echo '(' . esc_attr( $p_term->count ) . ')';
						endif;
						?>
					</option>
				<?php endforeach; ?>
			</select>
		<?php endif; ?>
	</div>
</div>

<?php wp_enqueue_script( 'yith-wcbr' ); ?>
