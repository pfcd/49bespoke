<?php
/**
 * Brand Grid widget for Elementor
 *
 * @author YITH <plugins@yithemes.com>
 *
 * @class YITH_WCBR_Elementor_Brand_Grid
 * @package YITH\Brands\Classes
 * @version 1.3.8
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_Elementor_Brand_Grid' ) ) {
	/**
	 * Brand Grid widget for Elementor
	 *
	 * @version 1.3.8
	 */
	class YITH_WCBR_Elementor_Brand_Grid extends \Elementor\Widget_Base {

		/**
		 * Get widget name.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Grid widget name.
		 *
		 * @return string Widget name.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_name() {
			return 'yith_wcbr_brand_grid';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Grid widget title.
		 *
		 * @return string Widget title.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_title() {
			return __( 'YITH Brands Grid', 'yith-woocommerce-brands-add-on' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Grid widget icon.
		 *
		 * @return string Widget icon.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_icon() {
			return 'eicon-gallery-grid';
		}

		/**
		 * Get widget categories.
		 *
		 * Retrieve the list of categories the YITH_WCBR_Elementor_Brand_Grid widget belongs to.
		 *
		 * @return array Widget categories.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_categories() {
			return array( 'general', 'yith' );
		}

		/**
		 * Register YITH_WCBR_Elementor_Brand_Grid widget controls.
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
					'label'   => _x( 'Show brand name', 'Elementor control label', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Show brand name', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Hide brand name', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'show_count',
				array(
					'label'   => __( 'Show items count for each brand', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Show items count', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not show items count', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'show_image',
				array(
					'label'   => __( 'Show brand thumbnail', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Show brand image', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not show brand image', 'yith-woocommerce-brands-add-on' ),
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
				'cols',
				array(
					'label'   => __( 'Columns', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::NUMBER,
					'default' => 4,
				)
			);

			$this->add_control(
				'show_filtered_by',
				array(
					'label'   => __( 'Filter style', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'none'     => __( 'Do not group brands', 'yith-woocommerce-brands-add-on' ),
						'category' => __( 'Group brands by category', 'yith-woocommerce-brands-add-on' ),
						'name'     => __( 'Group brands by initial letter of the name', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'none',
				)
			);

			$this->add_control(
				'show_category_filter',
				array(
					'label'   => __( 'Show categories filters?', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Show category filters', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not show category filters', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'show_name_filter',
				array(
					'label'   => __( 'Show name filters?', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Show name filters', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not show name filters', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'show_all_letters',
				array(
					'label'   => __( 'Show all letters in filter section', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'yes' => __( 'Show all letters', 'yith-woocommerce-brands-add-on' ),
						'no'  => __( 'Do not show all letters', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'no',
				)
			);

			$this->add_control(
				'category_filter_type',
				array(
					'label'   => __( 'Category filter type', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'multiselect' => __( 'Multiselect', 'yith-woocommerce-brands-add-on' ),
						'dropdown'    => __( 'Dropdown', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'multiselect',
				)
			);

			$this->add_control(
				'category_filter_style',
				array(
					'label'   => __( 'Category filter style', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'default' => __( 'Default', 'yith-woocommerce-brands-add-on' ),
						'shadow'  => __( 'Shadow', 'yith-woocommerce-brands-add-on' ),
						'border'  => __( 'Border', 'yith-woocommerce-brands-add-on' ),
						'round'   => __( 'Round', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'default',
				)
			);

			$this->add_control(
				'category_filter_default',
				array(
					'label'   => __( 'Initial selected category', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '',
				)
			);

			$this->add_control(
				'use_filtered_urls',
				array(
					'label'   => __( 'Links to redirect customers to shop filtered by brand & category', 'yith-woocommerce-brands-add-on' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'no'  => __( 'Use plain brand URLs', 'yith-woocommerce-brands-add-on' ),
						'yes' => __( 'Use filtered URLs', 'yith-woocommerce-brands-add-on' ),
					),
					'default' => 'default',
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

			$this->end_controls_section();
		}

		/**
		 * Render YITH_WCBR_Elementor_Brand_Grid widget output on the frontend.
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

			echo do_shortcode( "[yith_wcbr_brand_grid {$attribute_string}]" );
		}

	}
}
