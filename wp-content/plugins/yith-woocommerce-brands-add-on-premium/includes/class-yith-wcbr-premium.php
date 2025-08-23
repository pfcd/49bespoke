<?php
/**
 * Main class Premium
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Brands\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_Premium' ) ) {
	/**
	 * YITH_WCBR_Premium class
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Premium extends YITH_WCBR {
		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCBR_Premium
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCBR_Premium
		 * @since 1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor method
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// sets correct brand taxonomy and execute parent constructor.
			self::$brands_taxonomy = get_option( 'yith_wcbr_brands_taxonomy', self::$brands_taxonomy );
			parent::__construct();

			// register plugin to licence/update system.
			add_action( 'wp_loaded', array( $this, 'register_plugin_for_activation' ), 99 );
			add_action( 'wp_loaded', array( $this, 'register_plugin_for_updates' ), 99 );

			// register shortcodes.
			remove_action( 'init', array( 'YITH_WCBR_Shortcode', 'init' ), 5 );
			add_action( 'init', array( 'YITH_WCBR_Shortcode_Premium', 'init' ), 5 );

			// register widget.
			add_action( 'widgets_init', array( $this, 'register_widget' ) );

			// adds archive page banner.
			add_action( 'woocommerce_archive_description', array( $this, 'add_loop_brand_header' ), 5 );
			add_action( 'yith_before_shop_page_meta', array( $this, 'add_loop_brand_header' ), 5 );

			// adds action for frontend templates.
			add_action( 'wp', array( $this, 'add_loop_product_brand_action' ) );

			// adds action to print default logo.
			add_action( 'yith_wcbr_no_brand_logo', array( $this, 'add_default_logo_image' ), 10, 5 );

			// add filter to customize term link.
			add_filter( 'term_link', array( $this, 'add_custom_term_link' ), 10, 3 );

			// flush transients for brands-category and category-brand relationships whenever a new term relationship is added.
			add_action( 'set_object_terms', array( $this, 'flush_relationships_transients' ), 10, 6 );

			// Yoast SEO integration.
			if ( defined( 'WPSEO_VERSION' ) ) {
				add_action( 'init', array( $this, 'add_yoast_seo_replacement' ) );
				add_filter( 'wpseo_canonical', array( $this, 'filter_yoast_canonical_seo' ) );
			}

			// enable %yith_product_brand% rewrite for products.
			add_filter( 'post_type_link', array( $this, 'filter_product_post_type_link' ), 10, 2 );

			// enable sort by brand on admin page.
			add_action( 'init', array( $this, 'enable_sort_by_brand' ) );

			// add coupons restrictions on brand.
			add_filter( 'woocommerce_coupon_is_valid_for_product', array( $this, 'is_coupon_valid_for_brand' ), 10, 3 );
			add_filter( 'woocommerce_coupon_is_valid', array( $this, 'is_coupon_valid_for_brand_for_cart' ), 10, 3 );

			// flush rewrite rules when saving brand rewrite.
			add_action( 'update_option_yith_wcbr_brands_taxonomy_rewrite', array( $this, 'flush_rewrite' ), 10, 2 );

			// add brand to product structured data.
			add_filter( 'woocommerce_structured_data_product', array( $this, 'add_brand_to_structured_data' ), 10, 2 );

			// manage title option.
			add_action( 'wp', array( $this, 'hide_title_brand_page_action' ) );
		}

		/**
		 * Register plugins for activation tab
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_plugin_for_activation() {
			if ( ! class_exists( 'YIT_Plugin_Licence' ) ) {
				require_once YITH_WCBR_DIR . 'plugin-fw/licence/lib/yit-licence.php';
				require_once YITH_WCBR_DIR . 'plugin-fw/licence/lib/yit-plugin-licence.php';
			}

			YIT_Plugin_Licence()->register( YITH_WCBR_INIT, YITH_WCBR_SECRET_KEY, YITH_WCBR_SLUG );
		}

		/**
		 * Register plugins for update tab
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_plugin_for_updates() {
			if ( ! class_exists( 'YIT_Upgrade' ) ) {
				require_once YITH_WCBR_DIR . 'plugin-fw/lib/yit-upgrade.php';
			}

			YIT_Upgrade()->register( YITH_WCBR_SLUG, YITH_WCBR_INIT );
		}

		/**
		 * Register frontend scripts
		 *
		 * @return void
		 * @since 1.3.0
		 */
		public function register_scripts() {
			parent::register_scripts();

			$path   = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? 'unminified/' : '';
			$suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';

			// include js required.
			$template_name = 'brands.js';
			$locations     = array(
				trailingslashit( WC()->template_path() ) . 'yith-wcbr/' . $template_name,
				trailingslashit( WC()->template_path() ) . $template_name,
				'yith-wcbr/' . $template_name,
				$template_name,
			);

			$template_js = locate_template( $locations );

			if ( ! $template_js ) {
				$template_js = YITH_WCBR_URL . 'assets/js/' . $path . 'yith-wcbr' . $suffix . '.js';
			} else {
				$search      = array( get_stylesheet_directory(), get_template_directory() );
				$replace     = array( get_stylesheet_directory_uri(), get_template_directory_uri() );
				$template_js = str_replace( $search, $replace, $template_js );
			}

			// include shortcode css.
			$template_name = 'brands-shortcode.css';
			$locations     = array(
				trailingslashit( WC()->template_path() ) . 'yith-wcbr/' . $template_name,
				trailingslashit( WC()->template_path() ) . $template_name,
				'yith-wcbr/' . $template_name,
				$template_name,
			);

			$template_css = locate_template( $locations );

			if ( ! $template_css ) {
				$template_css = YITH_WCBR_URL . 'assets/css/yith-wcbr-shortcode.css';
			} else {
				$search       = array( get_stylesheet_directory(), get_template_directory() );
				$replace      = array( get_stylesheet_directory_uri(), get_template_directory_uri() );
				$template_css = str_replace( $search, $replace, $template_css );
			}

			wp_register_script( 'jquery-swiper', YITH_WCBR_URL . 'assets/js/' . $path . 'swiper.jquery' . $suffix . '.js', array( 'jquery' ), '6.4.6', true );
			wp_register_script(
				'yith-wcbr',
				$template_js,
				array(
					'jquery',
					'jquery-swiper',
					'select2',
					'jquery-blockui',
					'wp-hooks',
				),
				YITH_WCBR_VERSION,
				true
			);

			wp_localize_script(
				'yith-wcbr',
				'yith_wcbr',
				array(
					'ajax_url'                => admin_url( 'admin-ajax.php' ),
					/**
					 * APPLY_FILTERS: yith_wcbr_brand_thumbnail_carousel_time
					 *
					 * Filter the time (in milliseconds) to reproduce the carousel in the Brands Thumbnail Carousel shortcode.
					 *
					 * @param int $carousel_time Carousel time
					 *
					 * @return int
					 */
					'thumbnail_carousel_time' => apply_filters( 'yith_wcbr_brand_thumbnail_carousel_time', 1500 ),
					/**
					 * APPLY_FILTERS: yith_wcbr_brand_slides_per_view_mobile
					 *
					 * Filter the slides in the Brands Thumbnail Carousel shortcode in mobile devices.
					 *
					 * @param int $slides Slides
					 *
					 * @return int
					 */
					'slides_per_view_mobile'  => apply_filters( 'yith_wcbr_brand_slides_per_view_mobile', 2 ),
					'nonce'                   => wp_create_nonce( 'yith_ajax_nonce' ),
				)
			);

			wp_register_style( 'jquery-swiper', YITH_WCBR_URL . 'assets/css/swiper.css', array(), '6.4.6' );
			wp_register_style( 'yith-wcbr-shortcode', $template_css, array( 'yith-wcbr', 'jquery-swiper', 'select2' ), YITH_WCBR_VERSION );
		}

		/**
		 * Enqueue frontend scripts
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function enqueue_scripts() {
			parent::enqueue_scripts();

			wp_enqueue_style( 'yith-wcbr-shortcode' );
		}

		/**
		 * Register taxonomy for brands
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_taxonomy() {
			if ( ! taxonomy_exists( self::$brands_taxonomy ) ) {
				// set taxonomy rewrite from user preferences.
				self::$brands_rewrite = get_option( 'yith_wcbr_brands_taxonomy_rewrite', self::$brands_rewrite );

				// register default taxonomy.
				parent::register_taxonomy();
			}
		}

		/**
		 * Register thumb size for brand logo on single product page
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_image_size() {
			parent::register_image_size();

			$default_values = array(
				'width'  => 500,
				'height' => 100,
				'crop'   => true,
			);
			$stored_values  = get_option( 'yith_wcbr_loop_product_brands_size', $default_values );

			/**
			 * APPLY_FILTERS: yith_wcbr_grid_thumb_width
			 *
			 * Filter the default width for the image size in the loop page.
			 *
			 * @param int $width Default width
			 *
			 * @return int
			 */
			$grid_thumb_width = apply_filters( 'yith_wcbr_grid_thumb_width', $stored_values['width'] );

			/**
			 * APPLY_FILTERS: yith_wcbr_grid_thumb_height
			 *
			 * Filter the default height for the image size in the loop page.
			 *
			 * @param int $height Default height
			 *
			 * @return int
			 */
			$grid_thumb_height = apply_filters( 'yith_wcbr_grid_thumb_height', $stored_values['height'] );

			/**
			 * APPLY_FILTERS: yith_wcbr_grid_thumb_crop
			 *
			 * Filter whether to crop image in the loop page.
			 *
			 * @param bool $crop Whether to crop image
			 *
			 * @return bool
			 */
			$grid_thumb_crop = apply_filters( 'yith_wcbr_grid_thumb_crop', isset( $stored_values['crop'] ) ? $stored_values['crop'] : false );

			add_image_size( 'yith_wcbr_grid_logo_size', $grid_thumb_width, $grid_thumb_height, $grid_thumb_crop );
		}

		/**
		 * Register available widgets
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_widget() {
			require_once YITH_WCBR_INC . 'widget/class-yith-wcbr-product-brand-widget.php';
			require_once YITH_WCBR_INC . 'widget/class-yith-wcbr-brand-filter-widget.php';
			require_once YITH_WCBR_INC . 'widget/class-yith-wcbr-brand-thumbnail-widget.php';
			require_once YITH_WCBR_INC . 'widget/class-yith-wcbr-brand-thumbnail-carousel-widget.php';
			require_once YITH_WCBR_INC . 'widget/class-yith-wcbr-brand-select-widget.php';
			require_once YITH_WCBR_INC . 'widget/class-yith-wcbr-brand-list-widget.php';

			register_widget( 'YITH_WCBR_Product_Brand_Widget' );
			register_widget( 'YITH_WCBR_Brand_Filter_Widget' );
			register_widget( 'YITH_WCBR_Brand_Thumbnail_Widget' );
			register_widget( 'YITH_WCBR_Brand_Thumbnail_Carousel_Widget' );
			register_widget( 'YITH_WCBR_Brand_Select_Widget' );
			register_widget( 'YITH_WCBR_Brand_List_Widget' );
		}

		/**
		 * Adds single product brand template to correct action
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function add_single_product_brand_action() {
			$enable = get_option( 'yith_wcbr_enable_brand_detail', 'yes' );

			if ( 'yes' !== $enable ) {
				return;
			}

			$position = get_option( 'yith_wcbr_single_product_brands_position', 'woocommerce_template_single_meta' );

			if ( yith_plugin_fw_wc_is_using_block_template_in_single_product() ) {
				$this->add_single_product_brand_block_action( $position );
				return;
			}

			$action   = 'woocommerce_product_meta_end';
			$priority = 10;

			switch ( $position ) {
				case 'woocommerce_template_single_title':
					$action   = 'woocommerce_single_product_summary';
					$priority = 7;
					break;
				case 'woocommerce_template_before_single_title':
					$action   = 'woocommerce_single_product_summary';
					$priority = 3;
					break;
				case 'woocommerce_template_single_price':
					$action   = 'woocommerce_single_product_summary';
					$priority = 15;
					break;
				case 'woocommerce_template_single_excerpt':
					$action   = 'woocommerce_single_product_summary';
					$priority = 25;
					break;
				case 'woocommerce_template_single_add_to_cart':
					$action   = 'woocommerce_single_product_summary';
					$priority = 35;
					break;
				case 'woocommerce_template_single_sharing':
					$action   = 'woocommerce_single_product_summary';
					$priority = 55;
					break;
				case 'woocommerce_product_meta_end':
				default:
					break;
			}

			/**
			 * APPLY_FILTERS: yith_wcbr_brand_position_single_product
			 *
			 * Filters the action where to display the brands in the single product page.
			 *
			 * @param string $action Action name
			 *
			 * @return string
			 */
			$action = apply_filters( 'yith_wcbr_brand_position_single_product', $action );

			add_action( $action, array( $this, 'add_single_product_brand_template' ), $priority );
		}

		/**
		 * Append/Prepend single product brand to the correct block when using blockified templates
		 *
		 * @param string $position Position where to hook brand template in single product page.
		 */
		public function add_single_product_brand_block_action( $position = '' ) {
			if ( ! is_product() ) {
				return;
			}

			$method   = false !== strpos( $position, 'before' ) ? 'add_brand_before_block' : 'add_brand_after_block';
			$callback = function( $block_content, $parsed_block, $block ) use ( $position, $method ) {
				// if we're currently printing a loop (like related products in single product page) skip.
				if ( apply_filters( 'yith_wcbr_skip_single_brand_block', isset( $GLOBALS['woocommerce_loop'] ), $block, $position ) ) {
					return $block_content;
				}

				return $this->$method( $block_content, $parsed_block, $block );
			};

			switch ( $position ) {
				case 'woocommerce_template_before_single_title':
				case 'woocommerce_template_single_title':
					add_filter( 'render_block_core/post-title', $callback, 10, 3 );
					break;
				case 'woocommerce_template_single_price':
					add_filter( 'render_block_woocommerce/product-price', $callback, 10, 3 );
					break;
				case 'woocommerce_template_single_excerpt':
					add_filter( 'render_block_core/post-excerpt', $callback, 10, 3 );
					break;
				case 'woocommerce_template_single_add_to_cart':
					add_filter( 'render_block_woocommerce/add-to-cart-form', $callback, 10, 3 );
					break;
				case 'woocommerce_product_meta_end':
				case 'woocommerce_template_single_sharing':
				default:
					add_filter( 'render_block_core/post-terms', $callback, 10, 3 );
					break;

			}
		}

		/**
		 * Skip Single brand template addition to blockified template
		 *
		 * @param bool     $skip     Whether to skip or not.
		 * @param WP_Block $block    Block object that is used as reference (brand template will be appended to its content).
		 * @param string   $position Position where brands template should be hooked in single product page.
		 *
		 * @return bool Whether to skip template addition or not.
		 */
		public function skip_single_product_brand_block_action( $skip, $block, $position ) {
			if (
				in_array( $position, array( 'woocommerce_product_meta_end', 'woocommerce_template_single_sharing' ), true ) &&
				(
					! isset( $block->attributes['term'] ) ||
					'product_tag' !== $block->attributes['term']
				)
			) {
				return true;
			}

			return $skip;
		}

		/**
		 * Adds loop brand template to correct action
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function add_loop_product_brand_action() {
			$enable = get_option( 'yith_wcbr_enable_brand_loop', 'yes' );

			if ( 'yes' !== $enable ) {
				return;
			}

			$position = get_option( 'yith_wcbr_loop_product_brands_position', 'woocommerce_template_loop_price' );

			if ( yith_plugin_fw_wc_is_using_block_template_in_product_catalogue() ) {
				$this->add_loop_product_brand_block_action( $position );
				return;
			}

			$action   = 'woocommerce_after_shop_loop_item';
			$priority = 15;

			switch ( $position ) {
				case 'woocommerce_template_loop_price':
					$action   = 'woocommerce_after_shop_loop_item';
					$priority = 5;
					break;
				case 'woocommerce_template_loop_add_to_cart':
				default:
					break;
			}

			/**
			 * APPLY_FILTERS: yith_wcbr_brand_position_loop
			 *
			 * Filter the action where to display the brands in the loop page.
			 *
			 * @param string $action Action name
			 *
			 * @return string
			 */
			$action = apply_filters( 'yith_wcbr_brand_position_loop', $action );

			add_action( $action, array( $this, 'add_loop_brand_template' ), $priority );
		}

		/**
		 * Append/Prepend loop product brand to the correct block when using blockified templates
		 *
		 * @param string $position Position where to hook brand template in archive product page.
		 */
		public function add_loop_product_brand_block_action( $position = '' ) {
			$method   = false !== strpos( $position, 'before' ) ? 'add_brand_before_block' : 'add_brand_after_block';
			$callback = function( $block_content, $parsed_block, $block ) use ( $position, $method ) {
				// if we're currently printing a loop (like related products in single product page) skip.
				if ( apply_filters( 'yith_wcbr_skip_loop_brand_block', ! isset( $GLOBALS['woocommerce_loop'] ), $block, $position ) ) {
					return $block_content;
				}

				return $this->$method( $block_content, $parsed_block, $block );
			};

			switch ( $position ) {
				case 'woocommerce_template_loop_price':
					add_filter( 'render_block_woocommerce/product-price', $callback, 10, 3 );
					break;
				case 'woocommerce_template_loop_add_to_cart':
				default:
					add_filter( 'render_block_woocommerce/product-button', $callback, 10, 3 );
					break;

			}
		}

		/**
		 * Include template for brands on archive product page
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function add_loop_brand_header() {
			$is_preview = defined( 'YITH_PLUGIN_FW_BLOCK_PREVIEW' ) && YITH_PLUGIN_FW_BLOCK_PREVIEW;

			/**
			 * APPLY_FILTERS: yith_wcbr_remove_brand_header_on_next_pages
			 *
			 * Filter whether to remove the brand header on next brand pages.
			 *
			 * @param bool $remove_brand_header Whether to remove brand header or not
			 *
			 * @return bool
			 */
			$should_appear = is_tax( self::$brands_taxonomy ) || $is_preview || ! apply_filters( 'yith_wcbr_remove_brand_header_on_next_pages', 0 === (int) get_query_var( 'paged' ) );

			if ( ! $should_appear ) {
				return;
			}

			$term = get_queried_object();

			if ( ! $term instanceof WP_Term && $is_preview ) {
				$terms = get_terms(
					array(
						'taxonomy'   => self::$brands_taxonomy,
						'number'     => 1,
						'hide_empty' => false,
						'tax_query'  => array(
							array(
								'key'      => 'banner_id',
								'operator' => 'EXISTS',
							),
						),
					)
				);

				$term = $terms ? array_shift( $terms ) : false;
			}

			if ( ! $term || ! $term instanceof WP_Term ) {
				return;
			}

			$banner_id = get_term_meta( $term->term_id, 'banner_id', true );

			if ( ! $banner_id ) {
				return;
			}

			$args = array(
				'term_id'   => $term->term_id,
				'term'      => $term,
				'banner_id' => $banner_id,
			);

			if ( $banner_id ) {
				$args['banner'] = wp_get_attachment_image( $banner_id, 'big', false, array( ' class' => 'brand-banner' ) );
			}

			// include payment form template.
			$template_name = 'archive-product-brands-header.php';

			yith_wcbr_get_template( $template_name, $args );
		}

		/**
		 * Print loop brand template
		 *
		 * @param int|bool $product_id Optional product id to use for template.
		 * @return void
		 * @since 1.0.0
		 */
		public function add_loop_brand_template( $product_id = false ) {
			global $product;

			if ( $product_id ) {
				$current_product = wc_get_product( $product_id );
			} elseif ( $product instanceof WC_Product ) {
				$current_product = $product;
				$product_id      = $product->get_id();
			}

			if ( ! $current_product instanceof WC_Product ) {
				return;
			}

			// retrieve data to use in template.
			$brands_taxonomy = self::$brands_taxonomy;

			/**
			 * APPLY_FILTERS: yith_wcbr_single_product_before_term_list
			 *
			 * Filter the content to be displayed before the terms list in the loop page.
			 *
			 * @param string $content Content
			 *
			 * @return string
			 */
			$before_term_list = apply_filters( 'yith_wcbr_single_product_before_term_list', '' );

			/**
			 * APPLY_FILTERS: yith_wcbr_single_product_after_term_list
			 *
			 * Filter the content to be displayed after the terms list in the loop page.
			 *
			 * @param string $content Content
			 *
			 * @return string
			 */
			$after_term_list = apply_filters( 'yith_wcbr_single_product_after_term_list', '' );

			/**
			 * APPLY_FILTERS: yith_wcbr_single_product_term_list_sep
			 *
			 * Filter the separator for the terms list in the loop page.
			 *
			 * @param string $separator Separator
			 *
			 * @return string
			 */
			$term_list_sep      = apply_filters( 'yith_wcbr_single_product_term_list_sep', ', ' );
			$brands_label       = get_option( 'yith_wcbr_brands_label' );
			$product_brands     = get_the_terms( $product_id, self::$brands_taxonomy );
			$product_has_brands = ! is_wp_error( $product_brands ) && $product_brands;
			$content_to_show    = get_option( 'yith_wcbr_loop_product_brands_content' );
			$show_brand_logo    = get_option( 'yith_wcbr_enable_logo', 'yes' );

			$args = array(
				'product'            => $current_product,
				'product_id'         => $product_id,
				'brands_taxonomy'    => $brands_taxonomy,
				'before_term_list'   => $before_term_list,
				'after_term_list'    => $after_term_list,
				'term_list_sep'      => $term_list_sep,
				'brands_label'       => $brands_label,
				'product_brands'     => $product_brands,
				'product_has_brands' => $product_has_brands,
				'content_to_show'    => $content_to_show,
				'show_brand_logo'    => $show_brand_logo,
			);

			// include payment form template.
			$template_name = 'loop-brands.php';

			yith_wcbr_get_template( $template_name, $args );
		}

		/**
		 * Print default logo image, if enabled
		 *
		 * @param int      $term_id         Term id.
		 * @param stdClass $p_term          Term object.
		 * @param mixed    $size            Logo size.
		 * @param bool     $show_term_name  Wether to show name.
		 * @param bool     $show_avg_rating Wether to average rating.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function add_default_logo_image( $term_id, $p_term, $size = 'yith_wcbr_logo_size', $show_term_name = false, $show_avg_rating = false ) {
			$default_logo_enabled = get_option( 'yith_wcbr_use_logo_default' );

			if ( 'yes' === $default_logo_enabled ) {
				$default_logo_id = get_option( 'yith_wcbr_logo_default' );

				if ( version_compare( YITH_WCBR_VERSION, '2.0.0', '>=' ) ) {
					if ( ! is_numeric( $default_logo_id ) ) {
						$default_logo_id = attachment_url_to_postid( $default_logo_id );
					}
				}

				if ( $default_logo_id ) {
					$default_logo = wp_get_attachment_image_src( $default_logo_id, $size );

					if ( $default_logo ) {
						$output = sprintf( '<a href="%s"><img src="%s" width="%d" height="%d" alt="%s"/>', get_term_link( $p_term ), $default_logo[0], $default_logo[1], $default_logo[2], $p_term->name );

						if ( $show_term_name || $show_avg_rating ) {
							$output .= '<div class="brand-info">';

							if ( $show_term_name ) {
								$output .= $p_term->name;
							}

							if ( $show_avg_rating ) {
								$output .= $this->get_average_term_rating_html( $term_id );
							}

							$output .= '</div>';
						}

						$output .= '</a>';

						echo wp_kses_post( $output );
					}
				}
			}
		}

		/**
		 * Filters term link, to add custom url when set for brands
		 *
		 * @param string   $term_link Term original url.
		 * @param stdClass $p_term    Term object.
		 * @param string   $taxonomy  Taxonomy slug.
		 *
		 * @return string Term link
		 * @since 1.0.0
		 */
		public function add_custom_term_link( $term_link, $p_term, $taxonomy ) {
			if ( $taxonomy === self::$brands_taxonomy ) {
				$custom_url = yith_wcbr_get_term_meta( $p_term->term_id, 'custom_url', true );

				if ( yith_wcbr_is_valid_url( $custom_url ) ) {
					$term_link = $custom_url;
				}
			}

			return $term_link;
		}

		/**
		 * Filter term query clauses, to remove terms without thumbnail
		 *
		 * @param array $clauses  Array of query clauses to filter.
		 * @param array $taxonomy Array of taxonomy for current query.
		 * @param array $args     Array of args passe to get_terms().
		 *
		 * @return array Filtered array of query clauses
		 * @deprecated Since version 2.6 of WooCommerce (woocommerce_termmeta has been replaced by termmeta)
		 *
		 * @since      1.0.0
		 */
		public function filter_term_without_image( $clauses, $taxonomy, $args ) {
			global $wpdb;

			if ( in_array( self::$brands_taxonomy, $taxonomy, true ) ) {
				if ( version_compare( WC()->version, '2.6', '<' ) ) {
					$clauses['fields'] .= ', tm.*';
					$clauses['join']   .= " INNER JOIN {$wpdb->prefix}woocommerce_termmeta AS tm ON t.term_id = tm.woocommerce_term_id";
					$clauses['where']  .= " AND tm.meta_key = 'thumbnail_id' AND tm.meta_value <> '0'";
				}
			}

			return $clauses;
		}

		/**
		 * Returns AVG brands product rating
		 *
		 * @param int $term_id Brand id.
		 *
		 * @return string|int Avg rating
		 * @since 1.0.0
		 */
		public function get_average_brand_rating( $term_id ) {
			global $wpdb;

			$avg_brand_rating = $wpdb->get_var( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
				$wpdb->prepare(
					"
					SELECT AVG( cm.meta_value )
					FROM $wpdb->commentmeta AS cm
					LEFT JOIN $wpdb->comments AS c ON cm.comment_id = c.comment_ID
					WHERE meta_key = 'rating'
					AND comment_post_ID IN(
						SELECT p.ID
						FROM $wpdb->posts AS p
						INNER JOIN $wpdb->term_relationships AS tr ON ( p.ID = tr.object_id )
						WHERE tr.term_taxonomy_id = %d
						AND p.post_type = %s
						AND p.post_status = %s
					)
					AND c.comment_approved = '1'
					AND cm.meta_value > 0
				",
					$term_id,
					'product',
					'publish'
				)
			);

			return is_null( $avg_brand_rating ) ? 0 : $avg_brand_rating;
		}

		/**
		 * Returns html for rating
		 *
		 * @param int $term_id Brand id.
		 *
		 * @return string HTML code for rating stars
		 * @since 1.0.0
		 */
		public function get_average_term_rating_html( $term_id ) {
			$rating = $this->get_average_brand_rating( $term_id );

			/* translators: %s: rating value */
			$rating_html  = '<div class="star-rating" title="' . esc_attr( sprintf( __( 'Rated %s out of 5', 'yith-woocommerce-brands-add-on' ), $rating ) ) . '">';
			$rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"><strong class="rating">' . esc_html( $rating ) . '</strong> ' . esc_html__( 'out of 5', 'yith-woocommerce-brands-add-on' ) . '</span>';
			$rating_html .= '</div>';

			$rating_html = apply_filters( 'woocommerce_product_get_rating_html', $rating_html, $rating );

			$output  = '<div class="woocommerce-product-rating">';
			$output .= wp_kses_post( $rating_html );
			$output .= '</div>';

			return $output;
		}

		/**
		 * Returns an array indexed by brands ids; every element is an array of ids of brand-related categories
		 *
		 * @return mixed
		 * @since 1.0.0
		 */
		public function get_brand_category_relationships() {
			global $wpdb;

			$brand_category_relationship_stored = get_transient( 'yith_wcbr_brand_category_relationships' );

			if ( false === $brand_category_relationship_stored ) {
				$query = $wpdb->prepare(
					"SELECT DISTINCT tt1.term_id AS product_cat, tt2.term_id AS brand
					 FROM {$wpdb->term_taxonomy} AS tt1
					 LEFT JOIN {$wpdb->term_relationships} AS tr1 ON tr1.term_taxonomy_id = tt1.term_taxonomy_id
					 LEFT JOIN {$wpdb->term_relationships} AS tr2 ON tr2.object_id = tr1.object_id
					 LEFT JOIN {$wpdb->term_taxonomy} AS tt2 ON tt2.term_taxonomy_id = tr2.term_taxonomy_id
					 WHERE tt1.taxonomy =  %s
					 AND tt2.taxonomy =  %s",
					'product_cat',
					YITH_WCBR::$brands_taxonomy
				);

				$brand_category_relationship                = array();
				$brand_category_relationship_without_parent = array();
				$brand_category_relationship_raw            = $wpdb->get_results( $query, ARRAY_N ); //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,WordPress.DB.DirectDatabaseQuery

				foreach ( $brand_category_relationship_raw as $row ) {
					if ( isset( $brand_category_relationship_without_parent[ $row[1] ] ) ) {
						$brand_category_relationship_without_parent[ $row[1] ][] = $row[0];
					} else {
						$brand_category_relationship_without_parent[ $row[1] ] = (array) $row[0];
					}
				}

				$brand_category_relationship = $brand_category_relationship_without_parent;

				foreach ( $brand_category_relationship_without_parent as $term_id => $related ) {
					$current_term = get_term( $term_id, 'product_cat' );

					if ( $current_term ) {
						while ( $current_term->parent ) {
							if ( isset( $brand_category_relationship[ $current_term->parent ] ) ) {
								$brand_category_relationship[ $current_term->parent ] = array_unique( array_merge( $brand_category_relationship[ $current_term->parent ], $related ) );
							} else {
								$brand_category_relationship[ $current_term->parent ] = (array) $related;
							}

							$current_term = get_term( $current_term->parent, 'product_cat' );
						}
					}
				}

				set_transient( 'yith_wcbr_brand_category_relationships', $brand_category_relationship, WEEK_IN_SECONDS );
			} else {
				$brand_category_relationship = $brand_category_relationship_stored;
			}

			return $brand_category_relationship;
		}

		/**
		 * Returns an array indexed by product_cat ids; every element is an array of ids of category-related brands
		 *
		 * @return mixed
		 * @since 1.0.0
		 */
		public function get_category_brand_relationships() {
			global $wpdb;

			$brand_category_relationship_stored = get_transient( 'yith_wcbr_category_brand_relationships' );

			if ( false === $brand_category_relationship_stored ) {
				$query = $wpdb->prepare(
					"SELECT DISTINCT tt2.term_id AS brand, tt1.term_id AS product_cat
					 FROM {$wpdb->term_taxonomy} AS tt1
					 LEFT JOIN {$wpdb->term_relationships} AS tr1 ON tr1.term_taxonomy_id = tt1.term_taxonomy_id
					 LEFT JOIN {$wpdb->term_relationships} AS tr2 ON tr2.object_id = tr1.object_id
					 LEFT JOIN {$wpdb->term_taxonomy} AS tt2 ON tt2.term_taxonomy_id = tr2.term_taxonomy_id
					 WHERE tt1.taxonomy =  %s
					 AND tt2.taxonomy =  %s",
					'product_cat',
					YITH_WCBR::$brands_taxonomy
				);

				$brand_category_relationship                = array();
				$brand_category_relationship_without_parent = array();
				$brand_category_relationship_raw            = $wpdb->get_results( $query, ARRAY_N ); //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,WordPress.DB.DirectDatabaseQuery

				foreach ( $brand_category_relationship_raw as $row ) {
					if ( isset( $brand_category_relationship_without_parent[ $row[1] ] ) ) {
						$brand_category_relationship_without_parent[ $row[1] ][] = $row[0];
					} else {
						$brand_category_relationship_without_parent[ $row[1] ] = (array) $row[0];
					}
				}

				$brand_category_relationship = $brand_category_relationship_without_parent;

				foreach ( $brand_category_relationship_without_parent as $term_id => $related ) {
					$current_term = get_term( $term_id, 'product_cat' );
					while ( $current_term->parent ) {
						if ( isset( $brand_category_relationship[ $current_term->parent ] ) ) {
							$brand_category_relationship[ $current_term->parent ] = array_unique( array_merge( $brand_category_relationship[ $current_term->parent ], $related ) );
						} else {
							$brand_category_relationship[ $current_term->parent ] = (array) $related;
						}

						$current_term = get_term( $current_term->parent, 'product_cat' );
					}
				}

				set_transient( 'yith_wcbr_category_brand_relationships', $brand_category_relationship, WEEK_IN_SECONDS );
			} else {
				$brand_category_relationship = $brand_category_relationship_stored;
			}

			return $brand_category_relationship;
		}

		/**
		 * Flush brands-categories relationships when new new terms of this taxonomies are added to a product
		 *
		 * @param int    $object_id  Post id.
		 * @param mixed  $terms      Terms id array.
		 * @param mixed  $tt_ids     Term-taxonomy relationships ids array.
		 * @param string $taxonomy   Taxonomy name.
		 * @param bool   $append     bool Whether to append new terms to the old terms.
		 * @param mixed  $old_tt_ids Old term-taxonomy relationships ids array.
		 */
		public function flush_relationships_transients( $object_id, $terms, $tt_ids, $taxonomy, $append, $old_tt_ids ) {
			if ( 'product' !== get_post_type( $object_id ) ) {
				return;
			}

			if ( empty( $terms ) ) {
				return;
			}

			if ( count( $tt_ids ) === count( $old_tt_ids ) && count( array_intersect( $tt_ids, $old_tt_ids ) ) === count( $tt_ids ) ) {
				return;
			}

			if ( ! in_array( $taxonomy, array( 'product_cat', self::$brands_taxonomy ), true ) ) {
				return;
			}

			delete_transient( 'yith_wcbr_brand_category_relationships' );
			delete_transient( 'yith_wcbr_category_brand_relationships' );
		}

		/* === YOAST SEO INTEGRATION === */

		/**
		 * Register replacement for YOAST SEo (you can use %%product_brand%% in products)
		 *
		 * @return void
		 * @since 1.0.6
		 */
		public function add_yoast_seo_replacement() {
			if ( ! class_exists( 'WPSEO_Replace_Vars' ) ) {
				return;
			}

			WPSEO_Replace_Vars::register_replacement(
				'%%product_brand%%',
				array(
					$this,
					'retrieve_yoast_seo_replacement_value',
				)
			);
		}

		/**
		 * Return replacement value for %%product_brand%% shortcut
		 *
		 * @param string $var  String to replace.
		 * @param mixed  $post Args sent to replace function (in this case a post object).
		 *
		 * @return string Replacement values
		 * @since 1.0.6
		 */
		public function retrieve_yoast_seo_replacement_value( $var, $post ) {
			if ( ! isset( $post->ID ) ) {
				return $var;
			}

			$brands = wp_get_post_terms( $post->ID, YITH_WCBR::$brands_taxonomy );

			if ( empty( $brands ) ) {
				return $var;
			}

			$brand = $brands[0];

			return $brand->name;
		}

		/**
		 * Filter canonical url added by YOAST
		 *
		 * @param string $canonical Canonical url.
		 * @return string Filtered canonical url.
		 */
		public function filter_yoast_canonical_seo( $canonical ) {
			if ( is_tax( self::$brands_taxonomy ) ) {
				$queried_object = get_queried_object();

				return get_term_link( $queried_object, self::$brands_taxonomy );
			}

			return $canonical;
		}

		/* === PRODUCT REWRITE RULES === */

		/**
		 * Filters product rewrite rules, to let urls contain product brand
		 *
		 * @param string  $permalink Original permalink string.
		 * @param WP_Post $post      Post to which permlink refers.
		 *
		 * @return string Filtered permalink, with %{YITH_WCBR::$$brands_taxonomy}% placeholder replaced
		 * @since 1.0.9
		 */
		public function filter_product_post_type_link( $permalink, $post ) {
			global $wp_version;

			// Abort if post is not a product.
			if ( 'product' !== $post->post_type ) {
				return $permalink;
			}

			// Abort early if the placeholder rewrite tag isn't in the generated URL.
			if ( false === strpos( $permalink, '%' ) ) {
				return $permalink;
			}

			// Get the custom taxonomy terms in use by this post.
			$terms = get_the_terms( $post->ID, YITH_WCBR::$brands_taxonomy );

			if ( ! empty( $terms ) ) {
				if ( function_exists( 'wp_list_sort' ) ) {
					$terms = wp_list_sort( $terms, 'term_id', 'ASC' );
				} else {
					usort( $terms, '_usort_terms_by_ID' ); // order by ID.
				}

				/**
				 * APPLY_FILTERS: yith_wcbr_product_post_type_link_brand
				 *
				 * Filter the category object, if the %yith_product_brand% has been included in the permalink structure.
				 *
				 * @param WP_Term $term  Term object
				 * @param array   $terms Array of terms
				 * @param WP_Post $post  Post object
				 *
				 * @return WP_Term
				 */
				$category_object = apply_filters( 'yith_wcbr_product_post_type_link_brand', $terms[0], $terms, $post );
				$category_object = get_term( $category_object, YITH_WCBR::$brands_taxonomy );
				$product_cat     = $category_object->slug;

				if ( $category_object->parent ) {
					$ancestors = get_ancestors( $category_object->term_id, YITH_WCBR::$brands_taxonomy );
					foreach ( $ancestors as $ancestor ) {
						$ancestor_object = get_term( $ancestor, YITH_WCBR::$brands_taxonomy );
						$product_cat     = $ancestor_object->slug . '/' . $product_cat;
					}
				}
			} else {
				// If no terms are assigned to this post, use a string instead (can't leave the placeholder there).
				$product_cat = _x( 'uncategorized', 'slug', 'woocommerce' );
			}

			$find = array(
				'%' . YITH_WCBR::$brands_taxonomy . '%',
			);

			$replace = array(
				$product_cat,
			);

			$permalink = str_replace( $find, $replace, $permalink );

			return $permalink;
		}

		/* === SORT BY BRAND ON LOOP === */

		/**
		 * Enable sort by brand option
		 *
		 * @return void
		 * @since 1.0.10
		 */
		public function enable_sort_by_brand() {
			$enable_sort = get_option( 'yith_wcbr_enable_brand_sorting', 'no' );

			if ( 'yes' === $enable_sort ) {
				add_filter( 'woocommerce_catalog_orderby', array( $this, 'show_sort_by_brand' ) );
				add_filter( 'woocommerce_get_catalog_ordering_args', array( $this, 'set_sort_by_brand' ) );
			}
		}

		/**
		 * Show "Sort by brand" option in frontend select
		 *
		 * @param array $sort array Available sorting options.
		 *
		 * @return array Filtered sorting options
		 * @since 1.0.10
		 */
		public function show_sort_by_brand( $sort ) {
			if ( is_tax( YITH_WCBR::$brands_taxonomy ) ) {
				return $sort;
			}

			/**
			 * APPLY_FILTERS: yith_wcbr_sort_label
			 *
			 * Filter the label to sort products by brand in the loop page.
			 *
			 * @param string $sort_label Sort label
			 *
			 * @return string
			 */
			$sort['brand'] = apply_filters( 'yith_wcbr_sort_label', __( 'Sort by brand', 'yith-woocommerce-brands-add-on' ) );

			/**
			 * APPLY_FILTERS: yith_wcbr_show_sort_by_brand
			 *
			 * Filter the sort options in the loop page.
			 *
			 * @param array $sort Sort options
			 *
			 * @return array
			 */
			return apply_filters( 'yith_wcbr_show_sort_by_brand', $sort );
		}

		/**
		 * Check current sorting option, and eventually set query args for brand sorting
		 *
		 * @param array $args Query arguments array.
		 *
		 * @return array Filtered query arguments array
		 * @since 1.0.10
		 */
		public function set_sort_by_brand( $args ) {
			if ( is_tax( YITH_WCBR::$brands_taxonomy ) ) {
				return $args;
			}

			$orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput, WordPress.Security.NonceVerification.Recommended

			/**
			 * APPLY_FILTERS: yith_wcbr_set_sort_by_brand
			 *
			 * Filter whether to set the sort by brand option.
			 *
			 * @param bool   $set_sort_by_brand Whether to set sort by brand option or not
			 * @param string $orderby_value     Orderby value
			 *
			 * @return bool
			 */
			if ( 'brand' === $orderby_value || apply_filters( 'yith_wcbr_set_sort_by_brand', false, $orderby_value ) ) {
				add_filter( 'posts_clauses', array( $this, 'set_sort_by_brand_query_args' ) );
			}

			return $args;
		}

		/**
		 * Set query args for brand sorting
		 *
		 * @param array $args array Query args.
		 *
		 * @return array FIltered query args
		 * @since 1.0.10
		 */
		public function set_sort_by_brand_query_args( $args ) {
			global $wpdb;

			$args['fields'] .= ', bt.name AS brand';
			$args['join']   .= "
				LEFT JOIN {$wpdb->term_relationships} AS br ON ($wpdb->posts.ID = br.object_id)
				LEFT JOIN {$wpdb->term_taxonomy} AS btx ON (br.term_taxonomy_id = btx.term_taxonomy_id)
				LEFT JOIN {$wpdb->terms} AS bt ON (bt.term_id = btx.term_id)
			";
			$args['where']  .= $wpdb->prepare( ' AND btx.taxonomy = %s', $this::$brands_taxonomy );
			$args['orderby'] = 'brand ASC';
			$args['groupby'] = "$wpdb->posts.ID";

			return $args;
		}

		/* === BRANDS COUPON === */

		/**
		 * Whether coupon is valid.
		 *
		 * @param bool       $valid    Whether coupon is valid.
		 * @param WC_Product $product Current product.
		 * @param WC_Coupon  $coupon  Current coupon.
		 *
		 * @return bool Whether coupon is valid
		 */
		public function is_coupon_valid_for_brand( $valid, $product, $coupon ) {
			if ( ! $valid || ! $coupon->is_type( wc_get_product_coupon_types() ) ) {
				return $valid;
			}

			global $sitepress;

			$product_id = ( $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id() );

			if ( isset( $sitepress ) ) {
				$product_id = yit_wpml_object_id( $product_id, 'product', true, $sitepress->get_default_language() );
			}

			$product_brands = wc_get_product_term_ids( $product_id, YITH_WCBR::$brands_taxonomy );

			if ( isset( $sitepress ) ) {
				foreach ( $product_brands as $key => $brand_id ) {
					$original_brand_id      = icl_object_id( $brand_id, YITH_WCBR::$brands_taxonomy, true, $sitepress->get_default_language() );
					$product_brands[ $key ] = $original_brand_id;
				}
			}

			$allowed_brands  = $coupon->get_meta( 'allowed_brands', true );
			$excluded_brands = $coupon->get_meta( 'excluded_brands', true );

			// Category discounts.
			if ( is_array( $allowed_brands ) && ! empty( $allowed_brands ) && ! count( array_intersect( $product_brands, $allowed_brands ) ) ) {
				$valid = false;
			}

			// Specific categories excluded from the discount.
			if ( is_array( $excluded_brands ) && ! empty( $excluded_brands ) && count( array_intersect( $product_brands, $excluded_brands ) ) ) {
				$valid = false;
			}

			return $valid;
		}

		/* === BRANDS COUPON FOR CART === */

		/**
		 * Set coupon as invalid, if it doesn't match brands for current cart
		 *
		 * @param bool          $valid Whether coupon is valid.
		 * @param \WC_Coupon    $coupon Current coupon.
		 * @param \WC_Discounts $discounts Discounts object.
		 * @return bool Whether coupon is valid
		 * @throws Exception Error encountered during validation.
		 */
		public function is_coupon_valid_for_brand_for_cart( $valid, $coupon, $discounts ) {
			if ( ! $valid || ! $coupon->is_type( wc_get_cart_coupon_types() ) ) {
				return $valid;
			}

			global $sitepress;

			$allowed_brands  = $coupon->get_meta( 'allowed_brands', true );
			$excluded_brands = $coupon->get_meta( 'excluded_brands', true );

			if ( is_array( $allowed_brands ) && count( $allowed_brands ) > 0 ) {
				$valid = false;

				foreach ( $discounts->get_items_to_validate() as $item ) {
					if ( $coupon->get_exclude_sale_items() && $item->product && $item->product->is_on_sale() ) {
						continue;
					}

					$product_id = ( $item->product->is_type( 'variation' ) ? $item->product->get_parent_id() : $item->product->get_id() );

					if ( isset( $sitepress ) ) {
						$product_id = yit_wpml_object_id( $product_id, 'product', true, $sitepress->get_default_language() );
					}

					$product_brands = wc_get_product_term_ids( $product_id, YITH_WCBR::$brands_taxonomy );

					if ( isset( $sitepress ) ) {
						foreach ( $product_brands as $key => $brand_id ) {
							$original_brand_id      = icl_object_id( $brand_id, YITH_WCBR::$brands_taxonomy, true, $sitepress->get_default_language() );
							$product_brands[ $key ] = $original_brand_id;
						}
					}

					// If we find an item with a cat in our allowed cat list, the coupon is valid.
					if ( count( array_intersect( $product_brands, $allowed_brands ) ) > 0 ) {
						$valid = true;
						break;
					}
				}

				if ( ! $valid ) {
					throw new Exception( __( 'Sorry, this coupon is not applicable to selected products.', 'woocommerce' ), 109 );
				}
			}

			if ( is_array( $excluded_brands ) && count( $excluded_brands ) > 0 ) {
				$brands = array();

				foreach ( $discounts->get_items_to_validate() as $item ) {
					if ( ! $item->product ) {
						continue;
					}

					$product_id = ( $item->product->is_type( 'variation' ) ? $item->product->get_parent_id() : $item->product->get_id() );

					if ( isset( $sitepress ) ) {
						$product_id = yit_wpml_object_id( $product_id, 'product', true, $sitepress->get_default_language() );
					}

					$product_brands = wc_get_product_term_ids( $product_id, YITH_WCBR::$brands_taxonomy );

					if ( isset( $sitepress ) ) {
						foreach ( $product_brands as $key => $brand_id ) {
							$original_brand_id      = icl_object_id( $brand_id, YITH_WCBR::$brands_taxonomy, true, $sitepress->get_default_language() );
							$product_brands[ $key ] = $original_brand_id;
						}
					}

					$brands_id_list = array_intersect( $product_brands, $excluded_brands );

					if ( count( $brands_id_list ) > 0 ) {
						foreach ( $brands_id_list as $brand_id ) {
							$brand    = get_term( $brand_id, YITH_WCBR::$brands_taxonomy );
							$brands[] = $brand->name;
						}
					}
				}

				if ( ! empty( $brands ) ) {
					/* translators: %s: categories list */
					throw new Exception( sprintf( __( 'Sorry, this coupon is not applicable to the brands: %s.', 'woocommerce' ), implode( ', ', array_unique( $brands ) ) ), 114 );
				}
			}

			return true;
		}

		/* === HANDLE TAXONOMY REWRITE === */

		/**
		 * Flushes rewrite rules when brand rewrite gets updates
		 *
		 * @param string $old_value Old option value.
		 * @param string $new_value New option value.
		 *
		 * @since 1.1.1
		 */
		public function flush_rewrite( $old_value, $new_value ) {
			if ( $old_value !== $new_value ) {
				flush_rewrite_rules();
			}
		}

		/* === STRUCTURED DATA === */

		/**
		 * Add brand to product structured data
		 *
		 * @param array      $data    Product markup.
		 * @param WC_Product $product Current product.
		 *
		 * @return array Filtered array of data
		 */
		public function add_brand_to_structured_data( $data, $product ) {
			$brands = wp_get_post_terms( $product->get_id(), YITH_WCBR::$brands_taxonomy );

			if ( ! empty( $brands ) && ! is_wp_error( $brands ) ) {
				$data['brand'] = array();

				foreach ( $brands as $brand ) {
					$brand_markup = array(
						'@type' => 'Brand',
						'name'  => $brand->name,
						'url'   => get_term_link( $brand ),
					);

					$thumbnail_id = absint( yith_wcbr_get_term_meta( $brand->term_id, 'thumbnail_id', true ) );

					if ( $thumbnail_id ) {
						$image = wp_get_attachment_image_url( $thumbnail_id, 'yith_wcbr_logo_size' );
					} else {
						$default_logo_enabled = get_option( 'yith_wcbr_use_logo_default' );

						if ( 'yes' === $default_logo_enabled ) {
							$default_logo_id = get_option( 'yith_wcbr_logo_default' );

							if ( $default_logo_id ) {
								$image = wp_get_attachment_image_url( $default_logo_id, 'yith_wcbr_logo_size' );
							}
						}
					}

					if ( isset( $image ) ) {
						$brand_markup['logo'] = $image;
					}

					$data['brand'][] = $brand_markup;
				}
			}

			return $data;
		}

		/**
		 * Hide/show title in Brand taxonomy pages
		 *
		 * @param  mixed $bool Based on the options.
		 * @return $bool
		 * @since 2.0.0
		 */
		public function hide_title_brand_page_action() {
			if ( ! is_tax( YITH_WCBR::$brands_taxonomy ) || 'no' !== get_option( 'yith_wcbr_enable_title', 'yes' ) ) {
				return;
			}

			if ( yith_plugin_fw_wc_is_using_block_template_in_product_catalogue() ) {
				add_filter( 'render_block_core/query-title', '__return_empty_string' );
			} else {
				add_filter( 'woocommerce_show_page_title', '__return_false' );
			}
		}
	}
}

/**
 * Unique access to instance of YITH_WCBR_Premium class
 *
 * @return \YITH_WCBR_Premium
 * @since 1.0.0
 */
function YITH_WCBR_Premium() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCBR_Premium::get_instance();
}
