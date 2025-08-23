<?php
/**
 * Brands Thumbnail Carousel Widget
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Brands\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_Brand_Thumbnail_Carousel_Widget' ) ) {
	/**
	 * YITH_WCBR_Brand_Thumbnail_Carousel_Widget class
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Brand_Thumbnail_Carousel_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'yith_wcbr_brands_thumbnail_carousel',
				__( 'YITH Brands Thumbnails Carousel', 'yith-woocommerce-brands-add-on' ),
				array(
					'description' => __( 'Adds a carousel of brands thumbnails.', 'yith-woocommerce-brands-add-on' ),
				)
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 *
		 * @return void
		 * @see   WP_Widget::widget()
		 *
		 * @since 1.0.0
		 */
		public function widget( $args, $instance ) {
			$title = '';

			// translate widget title.
			if ( isset( $instance['title'] ) ) {
				$title = $args['before_title'] . wp_kses_post( apply_filters( 'widget_title', $instance['title'] ) ) . $args['after_title'];
				unset( $instance['title'] );
			}

			// parse args.
			$shortcode_atts_string = '';

			/**
			 * APPLY_FILTERS: yith_wcbr_thumbnail_carrousel_shortcode_atts
			 *
			 * Filter the array of arguments available for the Brands Thumbnail Carousel shortcode.
			 *
			 * @param array $args Array of arguments
			 *
			 * @return array
			 */
			$shortcode_atts = apply_filters(
				'yith_wcbr_thumbnail_carrousel_shortcode_atts',
				shortcode_atts(
					array(
						'autosense_category' => 'no',         // yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category).
						'category'           => 'all',        // all - a list of comma separated valid category slug.
						'hide_empty'         => 'no',         // yes - no.
						'hide_no_image'      => 'no',         // yes - no.
						'direction'          => 'horizontal', // horizontal - vertical.
						'cols'               => 2,            // int.
						'autoplay'           => 'yes',        // yes - no.
						'pagination'         => 'no',         // yes - no.
						'pagination_style'   => 'round',      // round - square.
						'prev_next'          => 'no',         // yes - no.
						'prev_next_style'    => 'round',      // round - square.
						'show_name'          => 'yes',        // yes - no.
						'show_rating'        => 'no',         // yes - no.
						'style'              => 'default',    // default - top-border - shadow - centered-title - boxed - squared - background.
					),
					$instance
				)
			);

			foreach ( $shortcode_atts as $key => $value ) {
				$shortcode_atts_string .= $key . '="' . $value . '" ';
			}

			echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
			echo $title; // phpcs:ignore WordPress.Security.EscapeOutput
			echo do_shortcode( "[yith_wcbr_brand_thumbnail_carousel  $shortcode_atts_string]" );
			echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance Previously saved values from database.
		 *
		 * @return void
		 * @see   WP_Widget::form()
		 *
		 * @since 1.0.0
		 */
		public function form( $instance ) {
			$title              = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$hide_empty         = isset( $instance['hide_empty'] ) && 'yes' === $instance['hide_empty'];
			$hide_no_image      = isset( $instance['hide_no_image'] ) && 'yes' === $instance['hide_no_image'];
			$autoplay           = isset( $instance['autoplay'] ) && 'yes' === $instance['autoplay'];
			$direction          = ! empty( $instance['direction'] ) ? $instance['direction'] : 'horizontal';
			$pagination         = isset( $instance['pagination'] ) && 'yes' === $instance['pagination'];
			$pagination_style   = isset( $instance['pagination_style'] ) ? $instance['pagination_style'] : 'round';
			$show_name          = isset( $instance['show_name'] ) && 'yes' === $instance['show_name'];
			$show_rating        = isset( $instance['show_rating'] ) && 'yes' === $instance['show_rating'];
			$autosense_category = isset( $instance['autosense_category'] ) && 'yes' === $instance['autosense_category'];
			$category           = ! empty( $instance['category'] ) ? $instance['category'] : '';
			$style              = ! empty( $instance['style'] ) ? $instance['style'] : 'default';

			?>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'show_name' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'show_name' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'show_name' ) ); ?>" type="checkbox" value="yes" <?php checked( $show_name ); ?>>
					<?php esc_html_e( 'Show brand name', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'Show brand name for each element of the carousel.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'show_rating' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'show_rating' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'show_rating' ) ); ?>" type="checkbox" value="yes" <?php checked( $show_rating ); ?>>
					<?php esc_html_e( 'Show rating', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'Show brand rate for each element of the carousel (brand rate is calculated as the average rating for products of the same brand).', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'hide_empty' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'hide_empty' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'hide_empty' ) ); ?>" type="checkbox" value="yes" <?php checked( $hide_empty ); ?>>
					<?php esc_html_e( 'Hide empty', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'Hide brands without associated products.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'hide_no_image' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'hide_no_image' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'hide_no_image' ) ); ?>" type="checkbox" value="yes" <?php checked( $hide_no_image ); ?>>
					<?php esc_html_e( 'Hide terms without images', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'Hide brands without associated images.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'autoplay' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'autoplay' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'autoplay' ) ); ?>" type="checkbox" value="yes" <?php checked( $autoplay ); ?>>
					<?php esc_html_e( 'Autoplay', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'Autoplay carousel slides', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'autosense_category' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'autosense_category' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'autosense_category' ) ); ?>" type="checkbox" value="yes" <?php checked( $autosense_category ); ?>>
					<?php esc_html_e( 'Autosense category', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'On category page, show only brands of the current category. ', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category:' ); ?></label>
				<input class="widefat" type="text" id="<?php echo esc_html( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'category' ) ); ?>" value="<?php echo esc_attr( $category ); ?>"/>
				<small><?php esc_html_e( 'Comma-separated list of valid product category slugs to filter brands; leave it empty if you don\'t want to filter brands by category.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'direction' ) ); ?>"><?php esc_html_e( 'Slider direction:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'direction' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'direction' ) ); ?>">
					<option value="horizontal" <?php selected( $direction, 'horizontal' ); ?> ><?php esc_html_e( 'Horizontal', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="vertical" <?php selected( $direction, 'vertical' ); ?> ><?php esc_html_e( 'Vertical', 'yith-woocommerce-brands-add-on' ); ?></option>
				</select>
				<small><?php esc_html_e( 'Select the sliding direction of the carousel.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'pagination' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'pagination' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'pagination' ) ); ?>" type="checkbox" value="yes" <?php checked( $pagination ); ?>>
					<?php esc_html_e( 'Show carousel pagination', 'yith-woocommerce-brands-add-on' ); ?><br/>
				</label>
				<small><?php esc_html_e( 'Show pagination for the carousel.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'pagination_style' ) ); ?>"><?php esc_html_e( 'Carousel pagination style:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'pagination_style' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'pagination_style' ) ); ?>">
					<option value="round" <?php selected( $pagination_style, 'round' ); ?> ><?php esc_html_e( 'Round', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="square" <?php selected( $pagination_style, 'square' ); ?> ><?php esc_html_e( 'Square', 'yith-woocommerce-brands-add-on' ); ?></option>
				</select>
				<small><?php esc_html_e( 'Carousel pagination style', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'Style:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'style' ) ); ?>">
					<option value="default" <?php selected( $style, 'default' ); ?> ><?php esc_html_e( 'Default', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="top-border" <?php selected( $style, 'top-border' ); ?> ><?php esc_html_e( 'Top border', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="shadow" <?php selected( $style, 'shadow' ); ?> ><?php esc_html_e( 'Shadow', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="centered-title" <?php selected( $style, 'centered-title' ); ?> ><?php esc_html_e( 'Centered title', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="boxed" <?php selected( $style, 'boxed' ); ?> ><?php esc_html_e( 'Boxed', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="squared" <?php selected( $style, 'squared' ); ?> ><?php esc_html_e( 'Squared', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="background" <?php selected( $style, 'background' ); ?> ><?php esc_html_e( 'Background', 'yith-woocommerce-brands-add-on' ); ?></option>
				</select>
			</p>
			<script>
				jQuery(document).ready(function ($) {
					var pagination = $('#<?php echo esc_html( $this->get_field_id( 'pagination' ) ); ?>'),
						pagination_style = $('#<?php echo esc_html( $this->get_field_id( 'pagination_style' ) ); ?>');

					pagination.on('change', function () {
						var t = $(this);

						if (t.is(':checked')) {
							pagination_style.parents('p').show();
						} else {
							pagination_style.parents('p').hide();
						}
					}).trigger('change');
				});
			</script>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 * @see   WP_Widget::update()
		 *
		 * @since 1.0.0
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                       = array();
			$instance['title']              = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
			$instance['hide_empty']         = isset( $new_instance['hide_empty'] ) && yith_plugin_fw_is_true( $new_instance['hide_empty'] ) ? 'yes' : 'no';
			$instance['hide_no_image']      = isset( $new_instance['hide_no_image'] ) && yith_plugin_fw_is_true( $new_instance['hide_no_image'] ) ? 'yes' : 'no';
			$instance['autoplay']           = isset( $new_instance['autoplay'] ) && yith_plugin_fw_is_true( $new_instance['autoplay'] ) ? 'yes' : 'no';
			$instance['direction']          = ! empty( $new_instance['direction'] ) && in_array(
				$new_instance['direction'],
				array(
					'horizontal',
					'vertical',
				),
				true
			) ? $new_instance['direction'] : 'horizontal';
			$instance['pagination']         = isset( $new_instance['pagination'] ) ? 'yes' : 'no';
			$instance['pagination_style']   = ! empty( $new_instance['pagination_style'] ) && in_array(
				$new_instance['pagination_style'],
				array(
					'round',
					'square',
				),
				true
			) ? $new_instance['pagination_style'] : 'round';
			$instance['show_name']          = isset( $new_instance['show_name'] ) && yith_plugin_fw_is_true( $new_instance['show_name'] ) ? 'yes' : 'no';
			$instance['show_rating']        = isset( $new_instance['show_rating'] ) && yith_plugin_fw_is_true( $new_instance['show_rating'] ) ? 'yes' : 'no';
			$instance['autosense_category'] = isset( $new_instance['autosense_category'] ) && yith_plugin_fw_is_true( $new_instance['autosense_category'] ) ? 'yes' : 'no';
			$instance['category']           = ! empty( $new_instance['category'] ) ? $new_instance['category'] : '';
			$instance['style']              = ! empty( $new_instance['style'] ) && in_array(
				$new_instance['style'],
				array(
					'default',
					'top-border',
					'shadow',
					'centered-title',
					'boxed',
					'squared',
					'background',
				),
				true
			) ? $new_instance['style'] : 'default';

			return $instance;
		}
	}
}
