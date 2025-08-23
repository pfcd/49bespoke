<?php
/**
 * Brand Grid shortcode.
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

<div class="yith-wcbr-brand-grid <?php echo esc_attr( $category_filter_style ); ?>">
	<?php if ( ! empty( $title ) ) : ?>
		<h3><?php echo esc_html( $title ); ?></h3>
	<?php endif; ?>

	<?php if ( 'name' === $show_filtered_by && $show_category_filter && ! empty( $categories ) ) : ?>
		<div class="yith-wcbr-brand-filters-wrapper">
			<div class="yith-wcbr-brand-filters <?php echo esc_attr( $category_filter_type ); ?>">
				<?php
				if ( 'multiselect' === $category_filter_type ) :
					foreach ( $categories as $category ) :
						?>
						<a href="#" <?php echo ! $category->term_id ? 'class="reset active"' : ''; ?> data-term_id="<?php echo esc_attr( $category->term_id ); ?>" >
							<?php echo esc_attr( $category->name ); ?>
						</a>
						<?php
					endforeach;
				elseif ( 'dropdown' === $category_filter_type ) :
					?>
					<select class="yith-wcbr-category-dropdown" style="max-width: 300px">
						<?php
						foreach ( $categories as $category ) :
							?>
							<option value="<?php echo esc_attr( $category->term_id ); ?>" <?php selected( $category->term_id, $category_filter_default ); ?> ><?php echo esc_attr( $category->name ); ?></option>
							<?php
						endforeach;
						?>
					</select>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( 'name' === $show_filtered_by && 'yes' === $show_name_filter && ! empty( $available_filters ) ) : ?>
		<div class="yith-wcbr-brand-scroll-wrapper">
			<div class="yith-wcbr-brand-scroll" >
				<?php
				$first = true;
				foreach ( $stack as $letter ) :
					?>
					<a href="#" data-toggle="<?php echo esc_attr( $letter ); ?>"><?php echo esc_attr( $letter ); ?></a>
					<?php
				endforeach;
				?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $terms ) ) : ?>
		<div class="yith-wcbr-brands-list">
			<?php if ( 'none' !== $show_filtered_by ) : ?>
				<?php foreach ( $filtered_terms as $filter => $single_filter_terms ) : ?>
					<?php if ( ! empty( $single_filter_terms ) ) : ?>
						<div class="yith-wcbr-same-heading-box" data-heading="<?php echo esc_attr( $filter ); ?>">
							<h4>
								<?php
								if ( 'name' === $show_filtered_by ) {
									$name = esc_attr( $filter );
								} else {
									$category = get_term( $filter, 'product_cat' );
									$name     = esc_attr( $category->name );
								}

								echo $name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</h4>
							<ul>
								<?php
								$count       = 0;
								$current_row = 1;
								$total       = count( $single_filter_terms );
								$rows        = ceil( $total / $cols );

								foreach ( $single_filter_terms as $p_term ) {
									$classes  = '';
									$classes .= ( 0 === $count % $cols ) ? 'first' : '';
									$classes .= ( $current_row === $rows ) ? ' last-row' : '';
									$count ++;

									if ( 0 === $count % $cols ) {
										$current_row ++;
									}

									yith_wcbr_get_template(
										'brand-grid-loop',
										array(
											'p_term'     => $p_term,
											'filter'     => $filter,
											'show_filtered_by' => $show_filtered_by,
											'use_filtered_urls' => $use_filtered_urls,
											'show_image' => $show_image,
											'show_name'  => $show_name,
											'show_count' => $show_count,
											'classes'    => $classes,
											'cols_width' => $cols_width,
											'brand_category' => isset( $brand_category_relationship[ $p_term->term_id ] ) ? $brand_category_relationship[ $p_term->term_id ] : array(),
										),
										'shortcodes'
									);
								}
								?>
							</ul>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php else : ?>
				<ul>
					<?php
					$count       = 0;
					$current_row = 1;
					$total       = count( $terms );
					$rows        = ceil( $total / $cols );

					foreach ( $terms as $p_term ) {
						$classes  = '';
						$classes .= ( 0 === $count % $cols ) ? 'first' : '';
						$classes .= ( $current_row === $rows ) ? ' last-row' : '';
						$count ++;

						if ( 0 === $count % $cols ) {
							$current_row ++;
						}

						yith_wcbr_get_template(
							'brand-grid-loop',
							array(
								'p_term'           => $p_term,
								'show_filtered_by' => $show_filtered_by,
								'show_image'       => $show_image,
								'show_name'        => $show_name,
								'show_count'       => $show_count,
								'classes'          => $classes,
								'cols_width'       => $cols_width,
							),
							'shortcodes'
						);
					}
					?>
				</ul>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>

<?php wp_enqueue_script( 'yith-wcbr' ); ?>
