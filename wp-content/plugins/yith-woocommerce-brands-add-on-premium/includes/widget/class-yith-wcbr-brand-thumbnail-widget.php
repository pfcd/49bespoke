<?php
/**
 * Brands Thumbnail Widget
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Brands\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_Brand_Thumbnail_Widget' ) ) {
	/**
	 * YITH_WCBR_Brand_Thumbnail_Widget class
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Brand_Thumbnail_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'yith_wcbr_brands_thumbnail',
				__( 'YITH Brands Thumbnails', 'yith-woocommerce-brands-add-on' ),
				array(
					'description' => __( 'Adds a grid of brand thumbnails.', 'yith-woocommerce-brands-add-on' ),
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

			if ( isset( $instance['brand'] ) && empty( $instance['brand'] ) ) {
				unset( $instance['brand'] );
			}

			// parse args.
			$shortcode_atts_string = '';

			/**
			 * APPLY_FILTERS: yith_wcbr_thumbnail_shortcode_atts
			 *
			 * Filter the array of arguments available for the Brands Thumbnail shortcode.
			 *
			 * @param array $args Array of arguments
			 *
			 * @return array
			 */
			$shortcode_atts = apply_filters(
				'yith_wcbr_thumbnail_shortcode_atts',
				shortcode_atts(
					array(
						'autosense_category' => 'no',      // yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category).
						'category'           => 'all',     // all - a list of comma separated valid category slug.
						'brand'              => 'all',     // all - a list of comma separated valid brand slug.
						'pagination'         => 'no',      // whether to show pagination.
						'per_page'           => 0,         // int.
						'hide_empty'         => 'no',      // yes - no.
						'hide_no_image'      => 'no',      // yes - no.
						'cols'               => 2,         // int.
						'style'              => 'default', // default - big-header - small-header - shadow - box - highlight.
						'orderby'            => 'none',    // terms ordering name - slug - term_id - id - description.
						'order'              => 'ASC',     // order ascending or descending.
						'exclude'            => '',        // brand ids to exclude.
					),
					$instance
				)
			);

			foreach ( $shortcode_atts as $key => $value ) {
				$shortcode_atts_string .= $key . '="' . $value . '" ';
			}

			echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
			echo $title; // phpcs:ignore WordPress.Security.EscapeOutput
			echo do_shortcode( "[yith_wcbr_brand_thumbnail  $shortcode_atts_string]" );
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
			$autosense_category = isset( $instance['autosense_category'] ) && 'yes' === $instance['autosense_category'];
			$category           = ! empty( $instance['category'] ) ? $instance['category'] : '';
			$brand              = ! empty( $instance['brand'] ) ? $instance['brand'] : '';
			$exclude            = ! empty( $instance['exclude'] ) ? $instance['exclude'] : '';
			$style              = ! empty( $instance['style'] ) ? $instance['style'] : 'default';
			$orderby            = ! empty( $instance['orderby'] ) && in_array(
				$instance['orderby'],
				array(
					'name',
					'slug',
					'term_id',
					'id',
					'description',
				),
				true
			) ? $instance['orderby'] : 'none';
			$order              = ! empty( $instance['order'] ) && in_array(
				$instance['order'],
				array(
					'ASC',
					'DESC',
				),
				true
			) ? $instance['order'] : 'ASC';
			$pagination         = isset( $instance['pagination'] ) ? $instance['pagination'] : 'no';
			$per_page           = isset( $instance['per_page'] ) ? $instance['per_page'] : '0';

			?>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
				<label for="<?php echo esc_html( $this->get_field_id( 'brand' ) ); ?>"><?php esc_html_e( 'Brands:' ); ?></label>
				<input class="widefat" type="text" id="<?php echo esc_html( $this->get_field_id( 'brand' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'brand' ) ); ?>" value="<?php echo esc_attr( $brand ); ?>"/>
				<small><?php esc_html_e( 'Comma-separated list of valid product brands slugs to show in the widget; leave it empty to show all.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'exclude' ) ); ?>"><?php esc_html_e( 'Excluded brands:' ); ?></label>
				<input class="widefat" type="text" id="<?php echo esc_html( $this->get_field_id( 'exclude' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'exclude' ) ); ?>" value="<?php echo esc_attr( $exclude ); ?>"/>
				<small><?php esc_html_e( 'Comma-separated list of excluded product brands IDs to not show in the widget; leave it empty to show all.', 'yith-woocommerce-brands-add-on' ); ?></small>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'Style:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'style' ) ); ?>">
					<option value="default" <?php selected( $style, 'default' ); ?> ><?php esc_html_e( 'Default', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="boxed" <?php selected( $style, 'boxed' ); ?> ><?php esc_html_e( 'Boxed', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="shadow" <?php selected( $style, 'shadow' ); ?> ><?php esc_html_e( 'Shadow', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="borderless" <?php selected( $style, 'borderless' ); ?> ><?php esc_html_e( 'Borderless', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="top-border" <?php selected( $style, 'top-border' ); ?> ><?php esc_html_e( 'Top border', 'yith-woocommerce-brands-add-on' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order by:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'orderby' ) ); ?>">
					<option value="none" <?php selected( $orderby, 'none' ); ?> ><?php esc_html_e( 'None', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="name" <?php selected( $orderby, 'name' ); ?> ><?php esc_html_e( 'Name', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="slug" <?php selected( $orderby, 'slug' ); ?> ><?php esc_html_e( 'Slug', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="term_id" <?php selected( $orderby, 'term_id' ); ?> ><?php esc_html_e( 'Term ID', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="description" <?php selected( $orderby, 'top-description' ); ?> ><?php esc_html_e( 'Description', 'yith-woocommerce-brands-add-on' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Order:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'order' ) ); ?>">
					<option value="ASC" <?php selected( $order, 'ASC' ); ?> ><?php esc_html_e( 'Ascending', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="DESC" <?php selected( $order, 'DESC' ); ?> ><?php esc_html_e( 'Descending', 'yith-woocommerce-brands-add-on' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'pagination' ) ); ?>"><?php esc_html_e( 'Paginate:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'pagination' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'pagination' ) ); ?>">
					<option value="no" <?php selected( $pagination, 'no' ); ?> ><?php esc_html_e( 'No', 'yith-woocommerce-brands-add-on' ); ?></option>
					<option value="yes" <?php selected( $pagination, 'yes' ); ?> ><?php esc_html_e( 'Yes', 'yith-woocommerce-brands-add-on' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'per_page' ) ); ?>"><?php esc_html_e( 'Per page:' ); ?></label>
				<input class="widefat" type="number" id="<?php echo esc_html( $this->get_field_id( 'per_page' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'per_page' ) ); ?>" value="<?php echo esc_attr( $per_page ); ?>"/>
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
			$instance['hide_empty']         = isset( $new_instance['hide_empty'] ) && yith_plugin_fw_is_true( $new_instance['hide_empty'] ) ? 'yes' : 'no';
			$instance['hide_no_image']      = isset( $new_instance['hide_no_image'] ) && yith_plugin_fw_is_true( $new_instance['hide_no_image'] ) ? 'yes' : 'no';
			$instance['autosense_category'] = isset( $new_instance['autosense_category'] ) && yith_plugin_fw_is_true( $new_instance['autosense_category'] ) ? 'yes' : 'no';
			$instance['category']           = ! empty( $new_instance['category'] ) ? $new_instance['category'] : '';
			$instance['brand']              = ! empty( $new_instance['brand'] ) ? $new_instance['brand'] : '';
			$instance['exclude']            = ! empty( $new_instance['exclude'] ) ? $new_instance['exclude'] : '';
			$instance['style']              = ! empty( $new_instance['style'] ) && in_array(
				$new_instance['style'],
				array(
					'default',
					'shadow',
					'boxed',
					'borderless',
					'top-border',
				),
				true
			) ? $new_instance['style'] : 'default';
			$instance['orderby']            = ! empty( $new_instance['orderby'] ) && in_array(
				$new_instance['orderby'],
				array(
					'name',
					'slug',
					'term_id',
					'id',
					'description',
				),
				true
			) ? $new_instance['orderby'] : 'none';
			$instance['order']              = ! empty( $new_instance['order'] ) && in_array(
				$new_instance['order'],
				array(
					'ASC',
					'DESC',
				),
				true
			) ? $new_instance['order'] : 'ASC';
			$instance['pagination']         = ! empty( $new_instance['pagination'] ) ? $new_instance['pagination'] : 'no';
			$instance['per_page']           = ! empty( $new_instance['per_page'] ) ? $new_instance['per_page'] : '0';

			return $instance;
		}
	}
}
