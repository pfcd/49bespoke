<?php
/**
 * Admin Premium class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Brands\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_Admin_Premium' ) ) {
	/**
	 * YITH_WCBR_Admin_Premium class
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Admin_Premium extends YITH_WCBR_Admin {
		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCBR_Admin_Premium
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Importer instance
		 *
		 * @var YITH_WCBR_CSV_Importer
		 */
		public $importer = array();

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCBR_Admin_Premium
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
			parent::__construct();

			$this->importer = YITH_WCBR_CSV_Importer();

			add_filter( 'yith_wcbr_available_admin_tabs', array( $this, 'filter_admin_tabs' ) );

			add_filter( 'yith_wcbr_general_settings', array( $this, 'filter_setting_options' ) );

			// register premium settings.
			add_action( 'woocommerce_admin_field_yith_wcbr_image_size', array( $this, 'print_image_size_field' ), 10, 1 );

			add_action( 'init', array( $this, 'check_woocommerce_brand_taxonomy' ), 3 );

			add_action( 'admin_footer', array( $this, 'add_export_action' ) );
			add_action( 'admin_init', array( $this, 'export_csv' ) );

			// add product page filters.
			add_action( 'restrict_manage_posts', array( $this, 'add_product_filter_by_brand' ), 15 );

			// add coupons restrictions on brand.
			add_action( 'woocommerce_coupon_options_usage_restriction', array( $this, 'add_brand_coupon_restrictions' ), 10, 2 );
			add_action( 'woocommerce_coupon_options_save', array( $this, 'save_brand_coupon_restrictions' ), 10, 2 );

			// adds compatibility with WooCommerce products' csv export.
			add_filter( 'woocommerce_product_export_product_default_columns', array( $this, 'register_brands_for_wc_export' ) );
			add_filter( 'woocommerce_product_export_product_column_brand_ids', array( $this, 'retrieve_brands_for_wc_export' ), 10, 2 );
			add_filter( 'woocommerce_csv_product_import_mapping_default_columns', array( $this, 'normalize_brands_column_for_wc_import' ) );
			add_filter( 'woocommerce_csv_product_import_mapping_options', array( $this, 'map_brands_for_wc_import' ) );
			add_filter( 'woocommerce_product_importer_formatting_callbacks', array( $this, 'register_brands_for_wc_import' ), 10, 2 );
			add_action( 'woocommerce_product_import_inserted_product_object', array( $this, 'bind_product_to_brands_for_wc_import' ), 10, 2 );

			// brand rewrite.
			add_action( 'admin_init', array( $this, 'add_permalink_setting' ) );
			add_filter( 'pre_update_option_woocommerce_permalinks', array( $this, 'save_permalink_setting' ), 10, 1 );

			// import handling.
			add_action( 'yith_ywbr_import_brands', array( $this, 'print_import_view' ) );

			add_filter( 'woocommerce_debug_tools', array( $this, 'register_custom_tools' ) );

			// register brand taxonomy as sortable.
			add_filter( 'woocommerce_sortable_taxonomies', array( $this, 'register_as_sortable' ) );
		}

		/**
		 * Remove Brands tab in panel depending on the taxonony selected.
		 *
		 * @param array $tabs Array of tabs.
		 *
		 * @return array
		 */
		public function filter_admin_tabs( $tabs ) {
			if ( 'yith_product_brand' !== YITH_WCBR::$brands_taxonomy ) {
				unset( $tabs['brands'] );
			}

			$tabs['import'] = _x( 'Import', 'plugin tab name', 'yith-woocommerce-brands-add-on' );

			return $tabs;
		}

		/**
		 * Adds premium option to plugin panel
		 *
		 * @param mixed $options Original options array.
		 *
		 * @return mixed Filtered option array
		 * @since 1.0.0
		 */
		public function filter_setting_options( $options ) {
			$section_start = array_splice( $options['settings'], 0, 1 );
			$section_end   = array_splice( $options['settings'], - 1, 1 );

			$product_taxonomies          = array();
			$product_taxonomies_raw      = get_object_taxonomies( 'product', 'objects' );
			$excluded_product_taxonomies = array(
				'product_type',
				'product_visibility',
				'product_shipping_class',
				'yith_product_brand',
			);

			if ( ! empty( $product_taxonomies_raw ) ) {
				foreach ( $product_taxonomies_raw as $taxonomy_slug => $taxonomy ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride
					if ( in_array( $taxonomy_slug, $excluded_product_taxonomies, true ) ) {
						continue;
					}

					$product_taxonomies[ $taxonomy_slug ] = $taxonomy->label;
				}
			}

			$premium_options_chunck_1 = array(
				'general-brand-taxonomy'         => array(
					'id'        => 'yith_wcbr_brands_taxonomy',
					'name'      => __( 'Product brand taxonomy', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'select',
					'options'   => apply_filters(
						'yith_wcbr_product_taxonomies',
						array_merge(
							array(
								'yith_product_brand' => __( 'Default brand taxonomy', 'yith-woocommerce-brands-add-on' ),
							),
							$product_taxonomies
						)
					),
					'desc'      => __( 'Select the taxonomy whose terms will be used as brands.', 'yith-woocommerce-brands-add-on' ),
					'class'     => 'wc-enhanced-select',
					'default'   => 'yith_product_brand',
				),
				'general-brand-taxonomy-rewrite' => array(
					'id'        => 'yith_wcbr_brands_taxonomy_rewrite',
					'name'      => __( 'Brand slug', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'text',
					// translators: %s is the url to the permalink settings page.
					'desc'      => sprintf( __( 'Enter the slug that should be used when generating brands\' URLs.<br> <strong>Note:</strong> to avoid 404 errors, after changing this option you may need to re-save <a href="%s">your permalinks</a>.', 'yith-woocommerce-brands-add-on' ), admin_url( 'options-permalink.php' ) ),
					'default'   => 'product-brands',
					'deps'      => array(
						'id'    => 'yith_wcbr_brands_taxonomy',
						'value' => 'yith_product_brand',
					),
				),
			);

			$premium_options_chunck_2 = array(
				'general-brand-detail-product-enable'    => array(
					'id'        => 'yith_wcbr_enable_brand_detail',
					'name'      => __( 'Show brand on the product detail page', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'onoff',
					'desc'      => __( 'Enable to show the brand on the product detail page.', 'yith-woocommerce-brands-add-on' ),
					'default'   => 'yes',
				),
				'general-brand-single-product-position'  => array(
					'id'        => 'yith_wcbr_single_product_brands_position',
					'name'      => __( 'Single product brand position', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'select',
					'options'   => array(
						'woocommerce_template_before_single_title' => __( 'Before product title', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_single_title' => __( 'After product title', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_single_price' => __( 'After product price', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_single_excerpt' => __( 'After product excerpt', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_single_add_to_cart' => __( 'After single Add to Cart', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_product_meta_end' => __( 'After product meta', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_single_sharing' => __( 'After product share', 'yith-woocommerce-brands-add-on' ),
					),
					'desc'      => __( 'Choose the position on the product detail page.', 'yith-woocommerce-brands-add-on' ),
					'default'   => 'woocommerce_template_single_meta',
					'class'     => 'wc-enhanced-select',
					'deps'      => array(
						'id'    => 'yith_wcbr_enable_brand_detail',
						'value' => 'yes',
					),
				),
				'general-brand-single-product-content'   => array(
					'id'        => 'yith_wcbr_single_product_brands_content',
					'name'      => __( 'On the product detail page show', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'radio',
					'options'   => array(
						'both' => __( 'Both name and logo', 'yith-woocommerce-brands-add-on' ),
						'logo' => __( 'Only logo', 'yith-woocommerce-brands-add-on' ),
						'name' => __( 'Only name', 'yith-woocommerce-brands-add-on' ),
					),
					'desc'      => __( 'Choose the brand content on the product detail page.', 'yith-woocommerce-brands-add-on' ),
					'default'   => 'both',
					'deps'      => array(
						'id'    => 'yith_wcbr_enable_brand_detail',
						'value' => 'yes',
					),
				),
				'general-brand-single-product-size'      => array(
					'id'      => 'yith_wcbr_single_product_brands_size',
					'name'    => __( 'Size of brand images on the product detail page', 'yith-woocommerce-brands-add-on' ),
					'type'    => 'yith_wcbr_image_size',
					// translators: Full sencente: 'Set the image size in pixels. After changing these settings you may need to regenerate your permalinks'.
					'desc'    => sprintf( __( 'Set the image size in pixels. After changing these settings you may need to %s.', 'yith-woocommerce-brands-add-on' ), '<a href="https://wordpress.org/plugins/regenerate-thumbnails-advanced/" target="_blank">' . __( 'regenerate your thumbnails', 'yith-woocommerce-brands-add-on' ) . '</a>' ),
					'default' => array(
						'width'  => apply_filters( 'yith_wcbr_single_thumb_width', 500 ),
						'height' => apply_filters( 'yith_wcbr_single_thumb_height', 100 ),
						'crop'   => apply_filters( 'yith_wcbr_single_thumb_crop', true ),
					),
				),
				'general-brand-loop-product-enable'      => array(
					'id'        => 'yith_wcbr_enable_brand_loop',
					'name'      => __( 'Show brand on the shop page', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'onoff',
					'desc'      => __( 'Enable to show the brand on the shop page.', 'yith-woocommerce-brands-add-on' ),
					'default'   => 'yes',
				),
				'general-brand-loop-product-position'    => array(
					'id'        => 'yith_wcbr_loop_product_brands_position',
					'name'      => __( 'Product brand position on the shop page', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'radio',
					'desc'      => __( 'Choose the position of the brand on the shop page.', 'yith-woocommerce-brands-add-on' ),
					'default'   => 'woocommerce_template_loop_price',
					'class'     => 'wc-enhanced-select',
					'options'   => array(
						'woocommerce_template_loop_price' => __( 'After product price', 'yith-woocommerce-brands-add-on' ),
						'woocommerce_template_loop_add_to_cart' => __( 'After "Add to Cart"', 'yith-woocommerce-brands-add-on' ),
					),
					'deps'      => array(
						'id'    => 'yith_wcbr_enable_brand_loop',
						'value' => 'yes',
					),
				),
				'general-brand-loop-product-content'     => array(
					'id'        => 'yith_wcbr_loop_product_brands_content',
					'name'      => __( 'On the shop page show', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'radio',
					'options'   => array(
						'both' => __( 'Both name and logo', 'yith-woocommerce-brands-add-on' ),
						'logo' => __( 'Only logo', 'yith-woocommerce-brands-add-on' ),
						'name' => __( 'Only name', 'yith-woocommerce-brands-add-on' ),
					),
					'desc'      => __( 'Choose the brand content on the shop page.', 'yith-woocommerce-brands-add-on' ),
					'default'   => 'name',
					'deps'      => array(
						'id'    => 'yith_wcbr_enable_brand_loop',
						'value' => 'yes',
					),
				),
				'general-brand-loop-product-size'        => array(
					'id'      => 'yith_wcbr_loop_product_brands_size',
					'name'    => __( 'Size of brand images on the shop page', 'yith-woocommerce-brands-add-on' ),
					'type'    => 'yith_wcbr_image_size',
					// translators: Full sencente: 'Set the image size in pixels. After changing these settings you may need to regenerate your permalinks'.
					'desc'    => sprintf( __( 'Set the image size in pixels. After changing these settings you may need to %s.', 'yith-woocommerce-brands-add-on' ), '<a href="https://wordpress.org/plugins/regenerate-thumbnails-advanced/" target="_blank">' . __( 'regenerate your thumbnails', 'yith-woocommerce-brands-add-on' ) . '</a>' ),
					'default' => array(
						'width'  => apply_filters( 'yith_wcbr_grid_thumb_width', 500 ),
						'height' => apply_filters( 'yith_wcbr_grid_thumb_height', 100 ),
						'crop'   => apply_filters( 'yith_wcbr_grid_thumb_crop', true ),
					),
				),
				'general-brand-use-logo-default'         => array(
					'id'        => 'yith_wcbr_use_logo_default',
					'name'      => __( 'Set a default image for brands without a logo', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'onoff',
					'desc'      => __( 'Enable to upload a default image to use in brands without a logo.', 'yith-woocommerce-brands-add-on' ),
					'default'   => 'no',
				),
				'general-brand-logo-default'             => array(
					'id'        => 'yith_wcbr_logo_default',
					'name'      => __( 'Default logo', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'upload',
					'deps'      => array(
						'id'    => 'yith_wcbr_use_logo_default',
						'value' => 'yes',
					),
				),
				'genera-brand-loop-enable-brand-sorting' => array(
					'id'        => 'yith_wcbr_enable_brand_sorting',
					'name'      => __( 'Enable "Sort by Brand"', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'onoff',
					'desc'      => __( 'Enable a "Sort by Brand" option on the shop archive page.', 'yith-woocommerce-brands-add-on' ),
					'default'   => 'no',
				),
				'genera-brand-loop-enable-title'         => array(
					'id'        => 'yith_wcbr_enable_title',
					'name'      => __( 'Show brand name on brand pages', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'onoff',
					'desc'      => __( 'Enable to show the title on the brand pages.', 'yith-woocommerce-brands-add-on' ),
					'default'   => 'yes',
				),
				'genera-brand-loop-enable-logo'          => array(
					'id'        => 'yith_wcbr_enable_logo',
					'name'      => __( 'Show brand logo on brand pages', 'yith-woocommerce-brands-add-on' ),
					'type'      => 'yith-field',
					'yith-type' => 'onoff',
					'desc'      => __( 'Enable to show the logo on the brand pages. <br><b>Note: </b>This option will take precedence over the one to choose which content to display on the shop page.', 'yith-woocommerce-brands-add-on' ),
					'default'   => 'yes',
				),
			);

			$options['settings'] = array_merge( $section_start, $premium_options_chunck_1, $options['settings'], $premium_options_chunck_2, $section_end );

			return $options;
		}

		/**
		 * Print custom image size filed on plugin panel
		 *
		 * @param mixed $field Array of filed options.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function print_image_size_field( $field ) {
			// define templates for the field.
			list ( $id, $name, $default ) = yith_plugin_fw_extract( $field, 'id', 'name', 'default' );

			if ( ! isset( $default ) ) {
				$default = array(
					'width'  => 500,
					'height' => 100,
					'crop'   => false,
				);
			}

			$image_size = get_option( $id, $default );
			$args       = array(
				'field'      => $field,
				'id'         => $id,
				'name'       => $name,
				'image_size' => $image_size,
			);

			// include field template.
			yith_wcbr_get_view( '/fields/image-size.php', $args );
		}

		/**
		 * Prints custom term fields on "Add Brand" page
		 *
		 * @param string $p_term Current taxonomy id.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function add_brand_taxonomy_fields( $p_term ) {
			// include basic options.
			parent::add_brand_taxonomy_fields( $p_term );

			// include premium options.
			yith_wcbr_get_view( 'add-brand-taxonomy-form-premium.php' );
		}

		/**
		 * Prints custom term fields on "Edit brand" page
		 *
		 * @param string $p_term Current taxonomy id.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function edit_brand_taxonomy_fields( $p_term ) {
			// include basic options.
			parent::edit_brand_taxonomy_fields( $p_term );

			$banner_id  = absint( yith_wcbr_get_term_meta( $p_term->term_id, 'banner_id', true ) );
			$banner     = $banner_id ? wp_get_attachment_thumb_url( $banner_id ) : wc_placeholder_img_src();
			$custom_url = yith_wcbr_get_term_meta( $p_term->term_id, 'custom_url', true );

			$args = array(
				'banner_id'  => $banner_id,
				'banner'     => $banner,
				'custom_url' => $custom_url,
			);

			// include premium options.
			yith_wcbr_get_view( 'edit-brand-taxonomy-form-premium.php', $args );
		}

		/**
		 * Save custom term fields
		 *
		 * @param int        $term_id Currently saved term id.
		 * @param string|int $tt_id Term Taxonomy id.
		 * @param string     $taxonomy string Current taxonomy slug.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function save_brand_taxonomy_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
			// nonce already verified in wp-admin/edit-tags.php:168.
			// phpcs:disable WordPress.Security.NonceVerification.Missing
			parent::save_brand_taxonomy_fields( $term_id, $tt_id, $taxonomy );

			if ( isset( $_POST['product_brand_banner_id'] ) && YITH_WCBR::$brands_taxonomy === $taxonomy ) {
				yith_wcbr_update_term_meta( $term_id, 'banner_id', absint( $_POST['product_brand_banner_id'] ) );
			}

			if ( isset( $_POST['product_brand_custom_url'] ) && YITH_WCBR::$brands_taxonomy === $taxonomy ) {
				yith_wcbr_update_term_meta( $term_id, 'custom_url', esc_url( sanitize_text_field( wp_unslash( $_POST['product_brand_custom_url'] ) ) ) );
			}
			// phpcs:enable WordPress.Security.NonceVerification.Missing
		}

		/**
		 * Check whether we're using an attribute as Brand taxonomy, and change register_taxonomy args consequently
		 *
		 * @return void
		 * @since 1.0.10
		 */
		public function check_woocommerce_brand_taxonomy() {
			$wc_product_attributes = wp_list_pluck( wc_get_attribute_taxonomies(), 'attribute_name' );
			$taxonomy_name         = YITH_WCBR::$brands_taxonomy;

			foreach ( $wc_product_attributes as $index => $attribute ) {
				$wc_product_attributes[ $index ] = wc_attribute_taxonomy_name( $attribute );
			}

			if ( in_array( $taxonomy_name, (array) $wc_product_attributes, true ) ) {
				add_filter(
					"woocommerce_taxonomy_args_{$taxonomy_name}",
					array(
						$this,
						'change_woocommerce_brand_taxonomy_args',
					)
				);
			}
		}

		/**
		 * Set show_in_menu param for attributes taxonomy, when used as brand taxonomy
		 *
		 * @param array $args Original register_taxonomy arguments.
		 *
		 * @return array Filtered register_taxonomy arguments
		 * @since 1.0.10
		 */
		public function change_woocommerce_brand_taxonomy_args( $args ) {
			$args['show_admin_column'] = true;
			$args['query_var'] = $args['query_var'] || is_admin();

			return $args;
		}

		/**
		 * Print js code used to add bulk action "Export CSV" in add tag screen
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function add_export_action() {
			$screen = get_current_screen();

			if ( 'edit-' . YITH_WCBR::$brands_taxonomy === $screen->id ) :
				?>

				<script type="text/javascript">
					jQuery(function () {
						jQuery('<option>').val('export_csv').text('<?php esc_html_e( 'Export CSV', 'yith-woocommerce-brands-add-on' ); ?>').appendTo("select[name='action']");
						jQuery('<option>').val('export_csv').text('<?php esc_html_e( 'Export CSV', 'yith-woocommerce-brands-add-on' ); ?>').appendTo("select[name='action2']");
					});
				</script>

				<?php
			endif;
		}

		/**
		 * Generate file csv to export brands
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function export_csv() {
			global $pagenow;

			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			if ( 'edit-tags.php' === $pagenow && ! empty( $_REQUEST['delete_tags'] ) && ( ( isset( $_REQUEST['action'] ) && 'export_csv' === $_REQUEST['action'] ) || ( isset( $_REQUEST['action2'] ) && 'export_csv' === $_REQUEST['action2'] ) ) ) {
				$terms = wc_clean( $_REQUEST['delete_tags'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput

				$sitename  = sanitize_key( get_bloginfo( 'name' ) );
				$sitename .= ( ! empty( $sitename ) ) ? '.' : '';
				$filename  = $sitename . 'WordPress.' . gmdate( 'Y-m-d' ) . '.csv';
				$base_url  = is_multisite() ? network_home_url() : get_bloginfo_rss( 'url' );

				// create csv file content.
				$formatted_terms   = array();
				$formatted_terms[] = array(
					'id',
					'name',
					'slug',
					'description',
					'parent',
					'base_siste_url',
					'thumbnail',
					'banner',
					'custom_url',
				);

				foreach ( $terms as $term_id ) {
					// retrieve term.
					$p_term = get_term( $term_id, YITH_WCBR::$brands_taxonomy );

					// retrieve thumbnail.
					$term_thumbnail_id = absint( yith_wcbr_get_term_meta( $term_id, 'thumbnail_id', true ) );
					$term_image        = $term_thumbnail_id ? wp_get_attachment_url( $term_thumbnail_id ) : '';

					// retrieve banner.
					$term_banner_id = absint( yith_wcbr_get_term_meta( $term_id, 'banner_id', true ) );
					$term_banner    = $term_banner_id ? wp_get_attachment_url( $term_banner_id ) : '';

					// retrieve custom url.
					$term_custom_url = yith_wcbr_get_term_meta( $term_id, 'custom_url', true );

					// retrieve term parent.
					$term_parent_slug = '';

					if ( $p_term->parent ) {
						$term_parent_obj  = get_term( $p_term->parent, YITH_WCBR::$brands_taxonomy );
						$term_parent_slug = ( $term_parent_obj && ! is_wp_error( $term_parent_obj ) ) ? $term_parent_obj->slug : '';
					}

					$formatted_terms[] = array(
						$term_id,
						$p_term->name,
						$p_term->slug,
						$p_term->description,
						$term_parent_slug,
						$base_url,
						$term_image,
						$term_banner,
						$term_custom_url,
					);
				}

				header( 'Content-Description: File Transfer' );
				header( 'Content-Disposition: attachment; filename=' . $filename );
				header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );

				$df = fopen( 'php://output', 'w' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fopen

				foreach ( $formatted_terms as $row ) {
					fputcsv( $df, $row );
				}

				fclose( $df ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose

				die();
			}
			// phpcs:enable WordPress.Security.NonceVerification.Recommended
		}

		/**
		 * Brand filter for products post type
		 *
		 * @return void
		 * @since 1.0.9
		 */
		public function add_product_filter_by_brand() {
			global $typenow;

			if ( 'product' === $typenow ) {
				/**
				 * APPLY_FILTERS: yith_wcbr_change_brand_name_in_filter
				 *
				 * Filter the brand name when filtering the products by brand in the backend.
				 *
				 * @param string $brand_name Brand name
				 *
				 * @return string
				 */
				$query_var             = apply_filters( 'yith_wcbr_change_brand_name_in_filter', YITH_WCBR::$brands_taxonomy );
				$current_product_brand = isset( $_GET[ $query_var ] ) ? sanitize_text_field( wp_unslash( $_GET[ $query_var ] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

				/**
				 * APPLY_FILTERS: yith_wcbr_product_filter_by_brand_args
				 *
				 * Filter the array of arguments available when filtering products by brand in the backend.
				 *
				 * @param array $args Array of arguments
				 *
				 * @return array
				 */
				$terms  = yith_wcbr_get_terms( YITH_WCBR::$brands_taxonomy, apply_filters( 'yith_wcbr_product_filter_by_brand_args', array( 'orderby' => 'name' ) ) );
				$output = '';

				if ( ! empty( $terms ) ) {
					$output .= '<select name="' . esc_attr( $query_var ) . '" class="dropdown_product_brand">';

					$output .= '<option value="" ' . selected( $current_product_brand, '', false ) . '>' . esc_html__( 'Select a brand', 'yith-woocommerce-brands-add-on' ) . '</option>';

					foreach ( $terms as $p_term ) {
						$output .= '<option value="' . esc_attr( $p_term->slug ) . '" ' . selected( $current_product_brand, $p_term->slug, false ) . '>' . esc_html( sprintf( '%s (%d)', $p_term->name, $p_term->count ) ) . '</option>';
					}

					$output .= '</select>';
				}

				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		/**
		 * Print additional coupon fields
		 *
		 * @param int       $coupon_id Coupon id.
		 * @param WC_Coupon $coupon Coupon.
		 *
		 * @return void
		 */
		public function add_brand_coupon_restrictions( $coupon_id, $coupon ) {
			$brands          = get_terms(
				array(
					'taxonomy' => YITH_WCBR::$brands_taxonomy,
				)
			);
			$allowed_brands  = array();
			$excluded_brands = array();

			if ( $coupon ) {
				$allowed_brands  = $coupon->get_meta( 'allowed_brands', true );
				$excluded_brands = $coupon->get_meta( 'excluded_brands', true );
			}

			$args = array(
				'brands'          => $brands,
				'allowed_brands'  => $allowed_brands,
				'excluded_brands' => $excluded_brands,
			);

			yith_wcbr_get_view( 'coupon-restrictions.php', $args );
		}

		/**
		 * Save additional coupon fields
		 *
		 * @param int       $coupon_id Coupon id.
		 * @param WC_Coupon $coupon Coupon.
		 *
		 * @return void
		 */
		public function save_brand_coupon_restrictions( $coupon_id, $coupon ) {
			// nonce areldy verified in woocommerce/includes/admin/class-wc-admin-meta-boxes.php:198.
			// phpcs:disable WordPress.Security.NonceVerification.Missing
			$allowed_brands  = isset( $_POST['allowed_brands'] ) ? (array) wc_clean( $_POST['allowed_brands'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
			$excluded_brands = isset( $_POST['excluded_brands'] ) ? (array) wc_clean( $_POST['excluded_brands'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
			// phpcs:enabled disable WordPress.Security.NonceVerification.Missing

			$the_coupon = new WC_Coupon( $coupon_id );

			$the_coupon->update_meta_data( 'allowed_brands', array_filter( array_map( 'intval', $allowed_brands ) ) );
			$the_coupon->update_meta_data( 'excluded_brands', array_filter( array_map( 'intval', $excluded_brands ) ) );

			$the_coupon->save();
		}

		/**
		 * Register brands column in WooCommerce exporter
		 *
		 * @param array $columns Array of columns to export.
		 *
		 * @return array Array of filtered columns
		 *
		 * @since 1.2.0
		 */
		public function register_brands_for_wc_export( $columns ) {
			$tag_pos = array_search( 'tag_ids', array_keys( $columns ), true ) + 1;

			$columns = array_merge(
				array_slice( $columns, 0, $tag_pos ),
				array( 'brand_ids' => __( 'Brands', 'yith-woocommerce-brands-add-on' ) ),
				array_slice( $columns, $tag_pos )
			);

			return $columns;
		}

		/**
		 * Retrieves brands to export
		 *
		 * @param mixed      $value   mixed Original value for the cell.
		 * @param WC_Product $product Product for the current row.
		 *
		 * @return mixed Filtered value of the cell
		 *
		 * @since 1.2.0
		 */
		public function retrieve_brands_for_wc_export( $value, $product ) {
			$brand_ids = wp_get_post_terms( yit_get_base_product_id( $product ), YITH_WCBR::$brands_taxonomy, array( 'fields' => 'ids' ) );
			$exporter  = new WC_Product_CSV_Exporter();

			return $exporter->format_term_ids( $brand_ids, YITH_WCBR::$brands_taxonomy );
		}

		/**
		 * Binds "Brands" column heading to brands' handling
		 *
		 * @param array $columns Original array of relationships.
		 *
		 * @return array Filtered array of relationships
		 *
		 * @since 1.2.0
		 */
		public function normalize_brands_column_for_wc_import( $columns ) {
			$columns[ __( 'Brands', 'yith-woocommerce-brands' ) ] = 'brand_ids';

			return $columns;
		}

		/**
		 * Add Brands option to import fields
		 *
		 * @param array $mapping Original array of import fields.
		 *
		 * @return array Filtered array of import fields
		 *
		 * @since 1.2.0
		 */
		public function map_brands_for_wc_import( $mapping ) {
			$tag_pos = array_search( 'tag_ids', array_keys( $mapping ), true ) + 1;

			$mapping = array_merge(
				array_slice( $mapping, 0, $tag_pos ),
				array( 'brand_ids' => __( 'Brands', 'yith-woocommerce-brands-add-on' ) ),
				array_slice( $mapping, $tag_pos )
			);

			return $mapping;
		}

		/**
		 * Register callback for brands handling during import
		 *
		 * @param array                   $callbacks array Original array of callbacks.
		 * @param WC_Product_CSV_Importer $importer  Importer object.
		 *
		 * @return array Filtered array of callbacks
		 *
		 * @since 1.2.0
		 */
		public function register_brands_for_wc_import( $callbacks, $importer ) {
			$mapped_keys = $importer->get_mapped_keys();
			$brand_pos   = array_search( 'brand_ids', $mapped_keys, true );

			if ( false !== $brand_pos ) {
				$callbacks[ $brand_pos ] = array( $this, 'parse_brands_for_wc_import' );
			}

			return $callbacks;
		}

		/**
		 * Parse brands cell for import
		 *
		 * @param mixed $value Value of the Brands column.
		 *
		 * @return mixed Filtered value of the Brands column
		 *
		 * @since 1.2.0
		 */
		public function parse_brands_for_wc_import( $value ) {
			if ( empty( $value ) ) {
				return array();
			}

			$row_terms = explode( ',', $value );
			$brands    = array();

			foreach ( $row_terms as $row_term ) {
				$parent = null;
				$_terms = array_map( 'trim', explode( '>', $row_term ) );
				$total  = count( $_terms );

				foreach ( $_terms as $index => $_term ) {
					// Check if brand exists. Parent must be empty string or null if doesn't exists.
					$p_term = term_exists( $_term, YITH_WCBR::$brands_taxonomy, $parent );

					if ( is_array( $p_term ) ) {
						$term_id = $p_term['term_id'];
					} else {
						$p_term = wp_insert_term( $_term, YITH_WCBR::$brands_taxonomy, array( 'parent' => intval( $parent ) ) );

						if ( is_wp_error( $p_term ) ) {
							break; // We cannot continue if the term cannot be inserted.
						}

						$term_id = $p_term['term_id'];
					}

					// Only requires assign the last brand.
					if ( ( 1 + $index ) === $total ) {
						$brands[] = $term_id;
					} else {
						// Store parent to be able to insert or query categories based in parent ID.
						$parent = $term_id;
					}
				}
			}

			return $brands;
		}

		/**
		 * Add brands terms to currently imported product
		 *
		 * @param WC_Product $object Imported product.
		 * @param array      $data   Array of original CSV row.
		 *
		 * @return void
		 *
		 * @since 1.2.0
		 */
		public function bind_product_to_brands_for_wc_import( $object, $data ) {
			if ( empty( $data['brand_ids'] ) ) {
				return;
			}

			foreach ( $data['brand_ids'] as $id ) {
				$p_term = get_term_by( 'id', $id, YITH_WCBR::$brands_taxonomy );

				wp_add_object_terms( yit_get_base_product_id( $object ), $p_term->name, YITH_WCBR::$brands_taxonomy );
			}
		}

		/**
		 * Register brand rewrite settings to be print out on permalinks settings page
		 *
		 * @return void
		 * @since 1.3.7
		 */
		public function add_permalink_setting() {
			add_settings_field( 'yith_wcbr_brands_taxonomy_rewrite', __( 'Product brand base', 'yith-woocommerce-brands-add-on' ), array( $this, 'print_permalink_setting' ), 'permalink', 'optional' );
		}

		/**
		 * Print field to enter brand rewrite on permalinks settings page
		 *
		 * @return void
		 * @since 1.3.7
		 */
		public function print_permalink_setting() {
			$brand_rewrite = get_option( 'yith_wcbr_brands_taxonomy_rewrite', 'product-brands' );

			?>
				<input name="yith_wcbr_brands_taxonomy_rewrite" type="text" class="regular-text code" value="<?php echo esc_attr( $brand_rewrite ); ?>" placeholder="<?php echo esc_attr_x( 'product-brand', 'slug', 'yith-woocommerce-brands-add-on' ); ?>"/>
			<?php
		}

		/**
		 * Save permalinks settings
		 *
		 * This method will:
		 * - save brand rewrite, if submitted
		 * - filter woocommerce permalinks and apply fix to product rewrite if needed to avoid conflict with page url
		 *   when using %yith_product_brand% placeholder
		 *
		 * @param array $permalinks Array of store permalinks being saved.
		 *
		 * @return array Array of filtered store permalinks to save
		 * @since 1.3.7
		 */
		public function save_permalink_setting( $permalinks ) {
			// fix product rewrite.
			$brand_taxonomy = YITH_WCBR::$brands_taxonomy;
			$product_base   = isset( $permalinks['product_base'] ) ? $permalinks['product_base'] : '';

			if ( "/%{$brand_taxonomy}%/" === trailingslashit( $product_base ) ) {
				$product_base = '/' . _x( 'product', 'slug', 'woocommerce' ) . $product_base;
			}

			$permalinks['product_base'] = wc_sanitize_permalink( $product_base );

			// save brand rewrite.
			// phpcs:disable WordPress.Security.NonceVerification.Missing
			if ( isset( $_POST['yith_wcbr_brands_taxonomy_rewrite'] ) ) {
				$brand_rewrite = wc_sanitize_permalink( wp_unslash( $_POST['yith_wcbr_brands_taxonomy_rewrite'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput

				update_option( 'yith_wcbr_brands_taxonomy_rewrite', $brand_rewrite );
			}
			// phpcs:enable WordPress.Security.NonceVerification.Missing

			return $permalinks;
		}

		/**
		 * Print the view to import the brands
		 *
		 * @param arary $field Field.
		 */
		public function print_import_view( $field ) {
			yith_wcbr_get_view( 'importer.php' );
		}

		/**
		 * Print custom tools in default WooCommerce tab
		 *
		 * @param  mixed $tools Default tools from WooCommerce.
		 *
		 * @return $tools
		 * @since 1.12.0
		 */
		public function register_custom_tools( $tools ) {
			$additional_tools = array(
				'clear_transient_brand_category' => array(
					'name'     => _x( 'Brands-Categories Transient', '[ADMIN] WooCommerce Tools tab, name of the tool', 'yith-woocommerce-brands-add-on' ),
					'button'   => _x( 'Clear Transient', '[ADMIN] WooCommerce Tools tab, button for the tool', 'yith-woocommerce-brands-add-on' ),
					'desc'     => __( 'This tool will clear Brands-Categories relationship transient.', 'yith-woocommerce-brands-add-on' ),
					'callback' => array( $this, 'execute_tools' ),
				),
				'clear_transient_category_brand' => array(
					'name'     => _x( 'Categories-Brands Transient', '[ADMIN] WooCommerce Tools tab, name of the tool', 'yith-woocommerce-brands-add-on' ),
					'button'   => _x( 'Clear Transient', '[ADMIN] WooCommerce Tools tab, button for the tool', 'yith-woocommerce-brands-add-on' ),
					'desc'     => __( 'This tool will clear Categories-Brands relationship transient.', 'yith-woocommerce-brands-add-on' ),
					'callback' => array( $this, 'execute_tools' ),
				),
				'clear_brands_transients'        => array(
					'name'     => _x( 'YITH WCBR Transient', '[ADMIN] WooCommerce Tools tab, name of the tool', 'yith-woocommerce-brands-add-on' ),
					'button'   => _x( 'Clear Transients', '[ADMIN] WooCommerce Tools tab, button for the tool', 'yith-woocommerce-brands-add-on' ),
					'desc'     => __( 'This tool will clear the brands transients cache.', 'yith-woocommerce-brands-add-on' ),
					'callback' => array( $this, 'execute_tools' ),
				),
				'recount_brands_terms'           => array(
					'name'     => _x( 'Term counts', '[ADMIN] WooCommerce Tools tab, name of the tool', 'yith-woocommerce-brands-add-on' ),
					'button'   => _x( 'Recount terms', '[ADMIN] WooCommerce Tools tab, button for the tool', 'yith-woocommerce-brands-add-on' ),
					'desc'     => __( 'This tool will recount product terms.', 'yith-woocommerce-brands-add-on' ),
					'callback' => array( $this, 'execute_tools' ),
				),
			);

			$tools = array_merge(
				$tools,
				$additional_tools
			);

			return $tools;
		}

		/**
		 * Handle tools panel actions
		 *
		 * @return void
		 * @since 1.1.2
		 */
		public function execute_tools() {
			if ( ! empty( $_GET['action'] ) && ! empty( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'debug_action' ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
				switch ( $_GET['action'] ) {
					case 'clear_transient_brand_category':
						delete_transient( 'yith_wcbr_brand_category_relationships' );
						break;
					case 'clear_transient_category_brand':
						delete_transient( 'yith_wcbr_category_brand_relationships' );
						break;
					case 'clear_brands_transients':
						delete_transient( 'yith_wcbr_brand_category_relationships' );
						delete_transient( 'yith_wcbr_category_brand_relationships' );
						break;
					case 'recount_terms':
						$brands = yith_wcbr_get_terms(
							YITH_WCBR::$brands_taxonomy,
							array(
								'hide_empty' => false,
								'fields'     => 'tt_ids',
							)
						);

						wp_update_term_count_now( $brands, YITH_WCBR::$brands_taxonomy );
						break;
				}
			}
		}

		/**
		 * Register brand taxonomy as sortable for WooCommerce
		 *
		 * @param array $sortable_taxonomies Array of sortable taxonomies.
		 *
		 * @return array Filtered array of sortable taxonomies
		 * @since 1.0.10
		 */
		public function register_as_sortable( $sortable_taxonomies ) {
			$sortable_taxonomies[] = YITH_WCBR::$brands_taxonomy;

			return $sortable_taxonomies;
		}
	}
}

/**
 * Unique access to instance of YITH_WCBR_Admin_Premium class
 *
 * @return \YITH_WCBR_Admin_Premium
 * @since 1.0.0
 */
function YITH_WCBR_Admin_Premium() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCBR_Admin_Premium::get_instance();
}
