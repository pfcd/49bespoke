<?php
/**
 * Brand Header Image widget for Elementor
 *
 * @author YITH <plugins@yithemes.com>
 *
 * @class YITH_WCBR_Elementor_Brand_Header_Image
 * @package YITH\Brands\Classes
 * @version 1.3.8
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_Elementor_Brand_Header_Image' ) ) {
	/**
	 * Brand Header Image widget for Elementor
	 *
	 * @version 1.3.8
	 */
	class YITH_WCBR_Elementor_Brand_Header_Image extends \Elementor\Widget_Base {

		/**
		 * Get widget name.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Header_Image widget name.
		 *
		 * @return string Widget name.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_name() {
			return 'yith_wcbr_brand_header_image';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Header_Image widget title.
		 *
		 * @return string Widget title.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_title() {
			return __( 'YITH Brands - Header Image', 'yith-woocommerce-brands-add-on' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve YITH_WCBR_Elementor_Brand_Header_Image widget icon.
		 *
		 * @return string Widget icon.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_icon() {
			return 'eicon-image-box';
		}

		/**
		 * Get widget categories.
		 *
		 * Retrieve the list of categories the YITH_WCBR_Elementor_Brand_Header_Image widget belongs to.
		 *
		 * @return array Widget categories.
		 * @since  1.0.0
		 * @access public
		 */
		public function get_categories() {
			return array( 'general', 'yith' );
		}

		/**
		 * Render YITH_WCBR_Elementor_Brand_Header_Image widget output on the frontend.
		 *
		 * @since  1.0.0
		 * @access protected
		 */
		protected function render() {
			YITH_WCBR()->add_loop_brand_header();
		}
	}
}
