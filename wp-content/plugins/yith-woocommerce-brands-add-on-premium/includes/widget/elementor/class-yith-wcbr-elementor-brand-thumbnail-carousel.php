<?php
/**
 * Brand Thumbnail Carousel widget for Elementor
 *
 * @author YITH <plugins@yithemes.com>
 *
 * @class YITH_WCBR_Elementor_Brand_Thumbnail_Carousel
 * @package YITH\Brands\Classes
 * @version 1.3.8
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_Elementor_Brand_Thumbnail_Carousel' ) ) {
	/**
	 * Brand Thumbnail Carousel widget for Elementor
	 *
	 * @version 1.3.8
	 */
	class YITH_WCBR_Elementor_Brand_Thumbnail_Carousel extends \Elementor\Widget_Base {

		/**
		 * Get widget name.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Thumbnail_Carousel widget name.
		 *
		 * @return string Widget name.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_name() {
			return 'yith_wcbr_brand_thumbnail_carousel';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Thumbnail_Carousel widget title.
		 *
		 * @return string Widget title.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_title() {
			return __( 'YITH Brands Thumbnails Carousel', 'yith-woocommerce-brands-add-on' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Thumbnail_Carousel widget icon.
		 *
		 * @return string Widget icon.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_icon() {
			return 'eicon-slider-push';
		}

		/**
		 * Get widget categories.
		 *
		 * Retrieve the list of categories the YITH_WCBR_Elementor_Brand_Thumbnail_Carousel widget belongs to.
		 *
		 * @return array Widget categories.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_categories() {
			return array( 'general', 'yith' );
		}

		/**
		 * Register YITH_WCBR_Elementor_Brand_Thumbnail_Carousel widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @since  1.0.0
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'general_section',
				array(
					'label' => __( 'General', 'yith-woocommerce-brands-add-on' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'title',
				array(
					'label'       => __( 'Title', 'yith-woocommerce-brands-add-on' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'input_type'  => 'text',
					'placeholder' => '',
				)
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'appearance_section',
				array(
					'label' => __( 'Appearance', 'yith-woocommerce-brands-add-on' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'show_name',
				array(
					'label'   => __( 'Show brand name', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Show brand name', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Hide brand name', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'show_rating',
				array(
					'label'   => __( 'Show average rating for products of the brand', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Show rating', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Hide rating', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'hide_empty',
				array(
					'label'   => __( 'Hide brands with no products', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Hide empty brands', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Show also empty brands', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'hide_no_image',
				array(
					'label'   => __( 'Hide brands with no image', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Hide brands without image', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Show brands without image', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'cols',
				array(
					'label'   => __( 'Columns', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 4,
				)
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'carousel_section',
				array(
					'label' => __( 'Carousel', 'yith-woocommerce-brands-add-on' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'autoplay',
				array(
					'label'   => __( 'Autoplay carousel on page load', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Autoplay', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not autoplay', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'loop',
				array(
					'label'   => __( 'Loop carousel', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Enable loop', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not enable loop', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'direction',
				array(
					'label'   => __( 'Slider direction', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'horizontal' => __( 'Horizontal', 'yith-woocommerce-brands-add-on' ),
						'vertical'   => __( 'Vertical', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'horizontal',
				)
			);

			$this->add_control(
				'pagination',
				array(
					'label'   => __( 'Show carousel pagination', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Show pagination', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not show pagination', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'pagination_style',
				array(
					'label'   => __( 'Carousel pagination style', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'round'  => __( 'Round', 'yith-woocommerce-brands-add-on' ),
						'square' => __( 'Square', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'round',
				)
			);

			$this->add_control(
				'prev_next',
				array(
					'label'   => __( 'Show prev/next buttons', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'no'  => __( 'Do not show prev/next', 'yith-woocommerce-brands-add-on' ),
						'yes' => __( 'Show prev/next', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'prev_next_style',
				array(
					'label'   => __( 'Prev/Next buttons style', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'round'  => __( 'Round', 'yith-woocommerce-brands-add-on' ),
						'square' => __( 'Square', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'round',
				)
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'query_section',
				array(
					'label' => __( 'Query', 'yith-woocommerce-brands-add-on' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'autosense_category',
				array(
					'label'   => __( 'Autosense category', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SWITCHER,
					'default' => 'no',
				)
			);

			$this->add_control(
				'category',
				array(
					'label'   => __( 'Comma-separated list of categories slugs', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '',
				)
			);

			$this->add_control(
				'brand',
				array(
					'label'   => __( 'Comma-separated list of brands slugs to show', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '',
				)
			);

			$this->add_control(
				'parent',
				array(
					'label'   => __( 'Parent ID that terms must match', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '',
				)
			);

			$this->add_control(
				'orderby',
				array(
					'label'   => __( 'Order by', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'none'        => __( 'None', 'yith-woocommerce-brands-add-on' ),
						'name'        => __( 'Name', 'yith-woocommerce-brands-add-on' ),
						'slug'        => __( 'Slug', 'yith-woocommerce-brands-add-on' ),
						'term_id'     => __( 'Term ID', 'yith-woocommerce-brands-add-on' ),
						'description' => __( 'Description', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'none',
				)
			);

			$this->add_control(
				'order',
				array(
					'label'   => __( 'Order', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'ASC'  => __( 'Ascending', 'yith-woocommerce-brands-add-on' ),
						'DESC' => __( 'Descending', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'none',
				)
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'style_section',
				array(
					'label' => __( 'Style', 'yith-woocommerce-brands-add-on' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'style',
				array(
					'label'   => __( 'Shortcode style', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'default'    => __( 'Default', 'yith-woocommerce-brands-add-on' ),
						'shadow'     => __( 'Shadow', 'yith-woocommerce-brands-add-on' ),
						'boxed'      => __( 'Boxed', 'yith-woocommerce-brands-add-on' ),
						'borderless' => __( 'Borderless', 'yith-woocommerce-brands-add-on' ),
						'top-border' => __( 'Top border', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'default',
				)
			);

			$this->end_controls_section();
		}

		/**
		 * Render YITH_WCBR_Elementor_Brand_Thumbnail_Carousel widget output on the frontend.
		 *
		 * @since  1.0.0
		 * @access protected
		 */
		protected function render() {

			$attribute_string = '';
			$settings         = $this->get_settings_for_display();

			foreach ( $settings as $key => $value ) {
				if ( empty( $value ) || ! is_scalar( $value ) ) {
					continue;
				}
				$attribute_string .= " {$key}=\"{$value}\"";
			}

			echo do_shortcode( "[yith_wcbr_brand_thumbnail_carousel {$attribute_string}]" );
		}

	}
}
