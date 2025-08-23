<?php
/**
 * Product Brand Widget
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Brands\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_Product_Brand_Widget' ) ) {
	/**
	 * YITH_WCBR_Product_Brand_Widget class
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Product_Brand_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'yith_wcbr_product_brand',
				__( 'YITH Product Brand', 'yith-woocommerce-brands-add-on' ),
				array(
					'description' => __( 'Adds the brand name and logo for a specific product.', 'yith-woocommerce-brands-add-on' ),
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
			$shortcode_atts        = shortcode_atts(
				array(
					'product_id' => '',    // int (product id that will be used to retrieve brands; leave empty to use global product, if defined).
					'show_logo'  => 'yes', // yes - no (whether to show brand logo or not).
					'show_title' => 'yes', // yes - no (whether to show brand title or not).
				),
				$instance
			);

			if ( ! is_product() && ! $shortcode_atts['product_id'] ) {
				return;
			}

			foreach ( $shortcode_atts as $key => $value ) {
				$shortcode_atts_string .= $key . '="' . $value . '" ';
			}

			echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
			echo $title; // phpcs:ignore WordPress.Security.EscapeOutput
			echo do_shortcode( "[yith_wcbr_product_brand $shortcode_atts_string]" );
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
			$title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$product_id = ! empty( $instance['product_id'] ) ? $instance['product_id'] : '';
			$show_logo  = isset( $instance['show_logo'] ) && 'yes' === $instance['show_logo'];
			$show_title = isset( $instance['show_title'] ) && 'yes' === $instance['show_title'];

			?>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'product_id' ) ); ?>"><?php esc_html_e( 'Product ID:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'product_id' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'product_id' ) ); ?>" type="text" value="<?php echo esc_html( $product_id ); ?>">
				<small><?php esc_html_e( 'Enter product ID, or let the widget use the global $product.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'show_logo' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'show_logo' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'show_logo' ) ); ?>" type="checkbox" value="yes" <?php checked( $show_logo ); ?>>
					<?php esc_html_e( 'Show logo', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'Decide whether to show the logo or not. Please, note that if you don\'t mark at least one option between Show logo or Show title, the default option value will take effect.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'show_title' ) ); ?>">
					<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'show_title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'show_title' ) ); ?>" type="checkbox" value="yes" <?php checked( $show_title ); ?>>
					<?php esc_html_e( 'Show title', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php esc_html_e( 'Decide whether to show the title or not. Please, note that if you don\'t mark at least one option between Show logo or Show title, the default option value will take effect.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
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
			$instance               = array();
			$instance['title']      = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
			$instance['product_id'] = ! empty( $new_instance['product_id'] ) ? $new_instance['product_id'] : '';
			$instance['show_logo']  = isset( $new_instance['show_logo'] ) && yith_plugin_fw_is_true( $new_instance['show_logo'] ) ? 'yes' : 'no';
			$instance['show_title'] = isset( $new_instance['show_title'] ) && yith_plugin_fw_is_true( $new_instance['show_title'] ) ? 'yes' : 'no';

			return $instance;
		}
	}
}
