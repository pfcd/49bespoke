<?php
/**
 * Brands Filter Widget
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Brands\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_Brand_Filter_Widget' ) ) {
	/**
	 * YITH_WCBR_Brand_Filter_Widget class
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Brand_Filter_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'yith_wcbr_brands_filter',
				__( 'YITH Brands Filter', 'yith-woocommerce-brands-add-on' ),
				array(
					'description' => __( 'Adds an A-Z filter for the brands.', 'yith-woocommerce-brands-add-on' ),
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
			 * APPLY_FILTERS: yith_wcbr_brand_filter_widget_atts
			 *
			 * Filter the array of arguments available for the Brands Filter shortcode.
			 *
			 * @param array $args Array of arguments
			 *
			 * @return array
			 */
			$shortcode_atts = shortcode_atts(
				apply_filters(
					'yith_wcbr_brand_filter_widget_atts',
					array(
						'autosense_category' => 'no',      // yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category).
						'category'           => 'all',     // all - a list of comma separated valid category slug.
						'show_filter'        => 'yes',     // yes - no.
						'show_reset'         => 'yes',     // yes - no.
						'show_all_letters'   => 'yes',     // yes - no.
						'show_count'         => 'yes',     // yes - no.
						'hide_empty'         => 'no',      // yes - no.
						'style'              => 'default', // default - big-header - small-header - shadow - box - highlight.
						'highlight_color'    => '#ffd900', // hex color code (only for highlight style).
					)
				),
				$instance
			);

			foreach ( $shortcode_atts as $key => $value ) {
				$shortcode_atts_string .= $key . '="' . $value . '" ';
			}

			echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
			echo $title; // phpcs:ignore WordPress.Security.EscapeOutput
			echo do_shortcode( "[yith_wcbr_brand_filter  $shortcode_atts_string]" );
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
			$show_filter        = isset( $instance['show_filter'] ) && 'yes' === $instance['show_filter'];
			$show_reset         = isset( $instance['show_reset'] ) && 'yes' === $instance['show_reset'];
			$show_all_letters   = isset( $instance['show_all_letters'] ) && 'yes' === $instance['show_all_letters'];
			$show_count         = isset( $instance['show_count'] ) && 'yes' === $instance['show_count'];
			$hide_empty         = isset( $instance['hide_empty'] ) && 'yes' === $instance['hide_empty'];
			$autosense_category = isset( $instance['autosense_category'] ) && 'yes' === $instance['autosense_category'];
			$category           = ! empty( $instance['category'] ) ? $instance['category'] : '';
			$style              = ! empty( $instance['style'] ) ? $instance['style'] : 'default';
			$highlight_color    = ! empty( $instance['highlight_color'] ) ? $instance['highlight_color'] : '#ffd900';

			?>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'show_filter' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'show_filter' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'show_filter' ) ); ?>" type="checkbox" value="yes" <?php checked( $show_filter ); ?>>
					<?php esc_html_e( 'Show filters', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'Show letter filter.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'show_reset' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'show_reset' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'show_reset' ) ); ?>" type="checkbox" value="yes" <?php checked( $show_reset ); ?>>
					<?php esc_html_e( 'Show reset', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'Display the "Show all" button within the letter filter.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'show_all_letters' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'show_all_letters' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'show_all_letters' ) ); ?>" type="checkbox" value="yes" <?php checked( $show_all_letters ); ?>>
					<?php esc_html_e( 'Show all letters', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'When filters are activated, show all the letters and not only those matching the available brands.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'show_count' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'show_count' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'show_count' ) ); ?>" type="checkbox" value="yes" <?php checked( $show_count ); ?>>
					<?php esc_html_e( 'Show count', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'Show the number of products for each brand.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'hide_empty' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'hide_empty' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'hide_empty' ) ); ?>" type="checkbox" value="yes" <?php checked( $hide_empty ); ?>>
					<?php esc_html_e( 'Hide empty', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'Hide brands without associated products.', 'yith-woocommerce-brands-add-on' ); ?></small>
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
				<small><?php esc_html_e( 'Comma-separated list of valid product category slugs to filter brands; leave empty if you don\'t want to filter brands by category.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'Style:' ); ?></label>
				<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'style' ) ); ?>">
					<option value="default" <?php selected( $style, 'default' ); ?> ><?php esc_html_e( 'Default', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="big-header" <?php selected( $style, 'big-header' ); ?> ><?php esc_html_e( 'Big header', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="small-header" <?php selected( $style, 'small-header' ); ?> ><?php esc_html_e( 'Small header', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="shadow" <?php selected( $style, 'shadow' ); ?> ><?php esc_html_e( 'Shadow', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="boxed" <?php selected( $style, 'boxed' ); ?> ><?php esc_html_e( 'Boxed', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="highlight" <?php selected( $style, 'highlight' ); ?> ><?php esc_html_e( 'Highlight', 'yith-woocommerce-brands-add-on' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'highlight_color' ) ); ?>"><?php esc_html_e( 'Highlight:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'highlight_color' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'highlight_color' ) ); ?>" type="text" value="<?php echo esc_attr( $highlight_color ); ?>">
				<small><?php esc_html_e( 'Valid hex color code to use as background in highlight style.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<script>
				jQuery(document).ready(function ($) {
					var show_filter = $('#<?php echo esc_html( $this->get_field_id( 'show_filter' ) ); ?>'),
						show_reset = $('#<?php echo esc_html( $this->get_field_id( 'show_reset' ) ); ?>'),
						show_all_letters = $('#<?php echo esc_html( $this->get_field_id( 'show_all_letters' ) ); ?>'),
						style = $('#<?php echo esc_html( $this->get_field_id( 'style' ) ); ?>'),
						highlight_color = $('#<?php echo esc_html( $this->get_field_id( 'highlight_color' ) ); ?>');

					show_filter.on('change', function () {
						var t = $(this);

						if (t.is(':checked')) {
							show_reset.parents('p').show();
							show_all_letters.parents('p').show();
						} else {
							show_reset.parents('p').hide();
							show_all_letters.parents('p').hide();
						}
					}).trigger('change');

					style.on('change', function () {
						var t = $(this),
							val = t.val();

						if (val === 'highlight') {
							highlight_color.parents('p').show();
						} else {
							highlight_color.parents('p').hide();
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
			$instance['show_filter']        = isset( $new_instance['show_filter'] ) && yith_plugin_fw_is_true( $new_instance['show_filter'] ) ? 'yes' : 'no';
			$instance['show_reset']         = isset( $new_instance['show_reset'] ) && yith_plugin_fw_is_true( $new_instance['show_reset'] ) ? 'yes' : 'no';
			$instance['show_all_letters']   = isset( $new_instance['show_all_letters'] ) && yith_plugin_fw_is_true( $new_instance['show_all_letters'] ) ? 'yes' : 'no';
			$instance['show_count']         = isset( $new_instance['show_count'] ) && yith_plugin_fw_is_true( $new_instance['show_count'] ) ? 'yes' : 'no';
			$instance['hide_empty']         = isset( $new_instance['hide_empty'] ) && yith_plugin_fw_is_true( $new_instance['hide_empty'] ) ? 'yes' : 'no';
			$instance['autosense_category'] = isset( $new_instance['autosense_category'] ) && yith_plugin_fw_is_true( $new_instance['autosense_category'] ) ? 'yes' : 'no';
			$instance['category']           = ! empty( $new_instance['category'] ) ? $new_instance['category'] : '';
			$instance['style']              = ! empty( $new_instance['style'] ) && in_array(
				$new_instance['style'],
				array(
					'default',
					'big-header',
					'small-header',
					'shadow',
					'boxed',
					'highlight',
				),
				true
			) ? $new_instance['style'] : 'default';
			$instance['highlight_color']    = ! empty( $new_instance['highlight_color'] ) ? wp_strip_all_tags( $new_instance['highlight_color'] ) : '';

			return $instance;
		}
	}
}
