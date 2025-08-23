<?php
/**
 * Brand Thumbnail widget for Elementor
 *
 * @author YITH <plugins@yithemes.com>
 *
 * @class YITH_WCBR_Elementor_Brand_Thumbnail
 * @package YITH\Brands\Classes
 * @version 1.3.8
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_Elementor_Brand_Thumbnail' ) ) {
	/**
	 * Brand Thumbnail widget for Elementor
	 *
	 * @version 1.3.8
	 */
	class YITH_WCBR_Elementor_Brand_Thumbnail extends \Elementor\Widget_Base {

		/**
		 * Get widget name.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Thumbnail widget name.
		 *
		 * @return string Widget name.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_name() {
			return 'yith_wcbr_brand_thumbnail';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Thumbnail widget title.
		 *
		 * @return string Widget title.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_title() {
			return __( 'YITH Brands Thumbnails', 'yith-woocommerce-brands-add-on' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Thumbnail widget icon.
		 *
		 * @return string Widget icon.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_icon() {
			return 'eicon-image';
		}

		/**
		 * Get widget categories.
		 *
		 * Retrieve the list of categories the YITH_WCBR_Elementor_Brand_Thumbnail widget belongs to.
		 *
		 * @return array Widget categories.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_categories() {
			return array( 'general', 'yith' );
		}

		/**
		 * Register YITH_WCBR_Elementor_Brand_Thumbnail widget controls.
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
				'query_section',
				array(
					'label' => __( 'Query', 'yith-woocommerce-brands-add-on' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'pagination',
				array(
					'label'   => __( 'Paginate items', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Paginate items', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not paginate items', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'per_page',
				array(
					'label'   => __( 'Items per page', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 5,
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
		 * Render YITH_WCBR_Elementor_Brand_Thumbnail widget output on the frontend.
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

			echo do_shortcode( "[yith_wcbr_brand_thumbnail {$attribute_string}]" );
		}

	}
}
