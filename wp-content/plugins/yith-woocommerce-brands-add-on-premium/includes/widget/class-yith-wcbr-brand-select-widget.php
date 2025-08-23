<?php
/**
 * Brands Select Widget
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Brands\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_Brand_Select_Widget' ) ) {
	/**
	 * YITH_WCBR_Brand_Select_Widget class
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Brand_Select_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'yith_wcbr_brands_select',
				__( 'YITH Brands Select', 'yith-woocommerce-brands-add-on' ),
				array(
					'description' => __( 'Adds a select with all brands.', 'yith-woocommerce-brands-add-on' ),
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
					'autosense_category' => 'no',   // yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category).
					'category'           => 'all',  // all - a list of comma separated valid category slug.
					'show_count'         => 'yes',  // yes - no.
					'hide_empty'         => 'no',   // yes - no.
					'brand'              => 'all',  // brands slug to include.
					'parent'             => '',     // parent to match for terms (term id).
					'orderby'            => 'none', // terms ordering name - slug - term_id - id - description.
					'order'              => 'ASC',  // order ascending or descending.
					'exclude'            => '',     // brand ids to exclude.
				),
				$instance
			);

			foreach ( $shortcode_atts as $key => $value ) {
				$shortcode_atts_string .= $key . '="' . $value . '" ';
			}

			echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
			echo $title; // phpcs:ignore WordPress.Security.EscapeOutput
			echo do_shortcode( "[yith_wcbr_brand_select $shortcode_atts_string]" );
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
			$autosense_category = isset( $instance['autosense_category'] ) && 'yes' === $instance['autosense_category'];
			$category           = ! empty( $instance['category'] ) ? $instance['category'] : '';
			$show_count         = isset( $instance['show_count'] ) && 'yes' === $instance['show_count'];
			$hide_empty         = isset( $instance['hide_empty'] ) && 'yes' === $instance['hide_empty'];
			$brand              = isset( $instance['brand'] ) ? $instance['brand'] : '';
			$exclude            = ! empty( $instance['exclude'] ) ? $instance['exclude'] : '';
			$parent             = isset( $instance['parent'] ) ? $instance['parent'] : '';
			$orderby            = isset( $instance['orderby'] ) ? $instance['orderby'] : '';
			$order              = isset( $instance['order'] ) ? $instance['order'] : '';

			?>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
				<label for="<?php echo esc_html( $this->get_field_id( 'brand' ) ); ?>"><?php esc_html_e( 'Brand:' ); ?></label>
				<input class="widefat" type="text" id="<?php echo esc_html( $this->get_field_id( 'brand' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'brand' ) ); ?>" value="<?php echo esc_attr( $brand ); ?>"/>
				<small><?php esc_html_e( 'Comma-separated list of valid product brand slugs to show in the widget; leave it empty if you want to retrieve all brands.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'exclude' ) ); ?>"><?php esc_html_e( 'Excluded brands:' ); ?></label>
				<input class="widefat" type="text" id="<?php echo esc_html( $this->get_field_id( 'exclude' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'exclude' ) ); ?>" value="<?php echo esc_attr( $exclude ); ?>"/>
				<small><?php esc_html_e( 'Comma-separated list of valid product brand IDs to not show in the widget; leave it empty if you want to retrieve all brands.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'parent' ) ); ?>"><?php esc_html_e( 'Parent:' ); ?></label>
				<input class="widefat" type="text" id="<?php echo esc_html( $this->get_field_id( 'parent' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'parent' ) ); ?>" value="<?php echo esc_attr( $parent ); ?>"/>
				<small><?php esc_html_e( 'Enter the ID of the parent brand to use in the term query; leave it empty if you want to retrieve all brands.', 'yith-woocommerce-brands-add-on' ); ?></small>
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
				<label for="<?php echo esc_html( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order by:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'orderby' ) ); ?>">
					<option value="none" <?php selected( empty( $orderby ) || 'none' === $orderby ); ?> ><?php esc_html_e( 'Default', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="name" <?php selected( $orderby, 'name' ); ?> ><?php esc_html_e( 'Term name', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="slug" <?php selected( $orderby, 'slug' ); ?> ><?php esc_html_e( 'Term slug', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="term_id" <?php selected( $orderby, 'term_id' ); ?> ><?php esc_html_e( 'Term ID', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="description" <?php selected( $orderby, 'description' ); ?> ><?php esc_html_e( 'Term description', 'yith-woocommerce-brands-add-on' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Order:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'order' ) ); ?>">
					<option value="ASC" <?php selected( empty( $order ) || 'ASC' === $order ); ?> ><?php esc_html_e( 'Ascending', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="DESC" <?php selected( $order, 'DESC' ); ?> ><?php esc_html_e( 'Descending', 'yith-woocommerce-brands-add-on' ); ?></option>
				</select>
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
			$instance                       = array();
			$instance['title']              = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
			$instance['autosense_category'] = isset( $new_instance['autosense_category'] ) && yith_plugin_fw_is_true( $new_instance['autosense_category'] ) ? 'yes' : 'no';
			$instance['category']           = ! empty( $new_instance['category'] ) ? $new_instance['category'] : '';
			$instance['show_count']         = isset( $new_instance['show_count'] ) && yith_plugin_fw_is_true( $new_instance['show_count'] ) ? 'yes' : 'no';
			$instance['hide_empty']         = isset( $new_instance['hide_empty'] ) && yith_plugin_fw_is_true( $new_instance['hide_empty'] ) ? 'yes' : 'no';
			$instance['brand']              = ! empty( $new_instance['brand'] ) ? $new_instance['brand'] : '';
			$instance['exclude']            = ! empty( $new_instance['exclude'] ) ? $new_instance['exclude'] : '';
			$instance['parent']             = ! empty( $new_instance['parent'] ) ? $new_instance['parent'] : '';
			$instance['orderby']            = in_array(
				$new_instance['orderby'],
				array(
					'none',
					'name',
					'slug',
					'term_id',
					'description',
				),
				true
			) ? $new_instance['orderby'] : 'none';
			$instance['order']              = in_array(
				$new_instance['order'],
				array(
					'ASC',
					'DESC',
				),
				true
			) ? $new_instance['order'] : 'ASC';

			return $instance;
		}
	}
}
