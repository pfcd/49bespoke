<?php
/**
 * Vendors table class
 *
 * @package YITH\CatalogMode\Admin\Tables
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'YWCTM_Vendors_Table' ) ) {

	/**
	 * Displays the exclusion table in YWCTM plugin admin tab
	 *
	 * @class   YWCTM_Vendors_Table
	 * @since   2.0.0
	 * @author  YITH <plugins@yithemes.com>
	 * @package YITH\CatalogMode\Admin\Tables
	 */
	class YWCTM_Vendors_Table {

		/**
		 * Constructor
		 *
		 * @return  void
		 * @since   2.0.0
		 */
		public function __construct() {
			if ( ! isset( $_GET['sub_tab'] ) || ( isset( $_GET['sub_tab'] ) && 'exclusions-vendors' !== $_GET['sub_tab'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				return;
			}
			add_action( 'init', array( $this, 'init' ), 15 );
		}

		/**
		 * Init page
		 *
		 * @return  void
		 * @since   2.0.0
		 */
		public function init() {
			add_action( 'ywctm_exclusions_vendors', array( $this, 'output' ) );
			add_filter( 'set-screen-option', array( $this, 'set_options' ), 10, 3 );
			add_action( 'current_screen', array( $this, 'add_options' ) );
		}

		/**
		 * Outputs the exclusion table template with insert form in plugin options panel
		 *
		 * @return  void
		 * @since   2.0.0
		 */
		public function output() {

			global $wpdb;

			$table = new YITH_YWCTM_Custom_Table(
				array(
					'singular' => esc_html__( 'vendor', 'yith-woocommerce-catalog-mode' ),
					'plural'   => esc_html__( 'vendors', 'yith-woocommerce-catalog-mode' ),
					'id'       => 'vendor',
				)
			);

			$fields      = array();
			$message     = '';
			$object_name = '';
			$getted      = $_GET; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			if ( ! empty( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), basename( __FILE__ ) ) ) {
				$posted = $_POST;

				if ( ! empty( $posted['item_ids'] ) ) {
					$object_ids = ( ! is_array( $posted['item_ids'] ) ) ? explode( ',', $posted['item_ids'] ) : $posted['item_ids'];

					foreach ( $object_ids as $object_id ) {
						update_term_meta( $object_id, '_ywctm_vendor_override_exclusion', 'yes' );
					}

					if ( ! empty( $posted['insert'] ) ) {
						$singular = esc_html__( '1 vendor added successfully', 'yith-woocommerce-catalog-mode' );
						/* translators: %s number of vendors */
						$plural  = sprintf( esc_html__( '%s vendors added successfully', 'yith-woocommerce-catalog-mode' ), count( $object_ids ) );
						$message = count( $object_ids ) === 1 ? $singular : $plural;
					}
				}
			}

			$table->options = array(
				'select_table'     => $wpdb->terms . ' a INNER JOIN ' . $wpdb->term_taxonomy . ' b ON a.term_id = b.term_id INNER JOIN ' . $wpdb->termmeta . ' c ON c.term_id = a.term_id',
				'select_columns'   => array(
					'a.term_id AS ID',
					'a.name',
					'MAX( CASE WHEN c.meta_key = "_ywctm_vendor_override_exclusion" THEN c.meta_value ELSE NULL END ) AS exclude',
				),
				'select_where'     => 'b.taxonomy = "yith_shop_vendor" AND ( c.meta_key = "_ywctm_vendor_override_exclusion" )',
				'select_group'     => 'a.term_id',
				'select_order'     => 'a.name',
				'select_order_dir' => 'ASC',
				'per_page_option'  => 'vendors_per_page',
				'search_where'     => array(
					'a.name',
				),
				'count_table'      => $wpdb->terms . ' a INNER JOIN ' . $wpdb->term_taxonomy . ' b ON a.term_id = b.term_id INNER JOIN ' . $wpdb->termmeta . ' c ON c.term_id = a.term_id',
				'count_where'      => 'b.taxonomy = "yith_shop_vendor" AND c.meta_key = "_ywctm_vendor_override_exclusion"',
				'key_column'       => 'ID',
				'view_columns'     => array(
					'cb'      => '<input type="checkbox" />',
					'vendor'  => esc_html__( 'Vendor', 'yith-woocommerce-catalog-mode' ),
					'actions' => '',
				),
				'hidden_columns'   => array(),
				'sortable_columns' => array(
					'category' => array( 'name', true ),
				),
				'custom_columns'   => array(
					'column_vendor'  => function ( $item ) {
						return ywctm_item_name_column( $item );
					},
					'column_actions' => function ( $item ) {
						$actions = ywctm_get_exclusion_list_item_actions( $item, 'vendor' );

						yith_plugin_fw_get_action_buttons( $actions );
					},
				),
				'bulk_actions'     => array(
					'actions'   => array(
						'delete' => esc_html__( 'Remove from list', 'yith-woocommerce-catalog-mode' ),
					),
					'functions' => array(
						'function_delete' => function () {

							$getted = $_REQUEST; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

							if ( isset( $getted['nonce'] ) ) {
								return;
							}

							$ids = ! is_array( $getted['id'] ) ? sanitize_text_field( wp_unslash( $getted['id'] ) ) : $getted['id'];

							if ( ! is_array( $ids ) ) {
								$ids = explode( ',', $ids );
							}

							if ( ! empty( $ids ) ) {
								foreach ( $ids as $id ) {

									delete_term_meta( $id, '_ywctm_vendor_override_exclusion' );
								}
							}
						},
					),
				),
				'wp_cache_option'  => 'ywctm_vendors',
			);
			$table->prepare_items();

			if ( 'delete' === $table->current_action() ) {
				$ids      = $getted['id'];
				$deleted  = count( is_array( $ids ) ? $ids : explode( ',', $ids ) );
				$singular = esc_html__( '1 vendor removed successfully', 'yith-woocommerce-catalog-mode' );
				/* translators: %s number of vendors*/
				$plural  = sprintf( esc_html__( '%s vendors removed successfully', 'yith-woocommerce-catalog-mode' ), $deleted );
				$message = 1 === $deleted ? $singular : $plural;

				$redirect = remove_query_arg( array( 'id', 'action', 'paged', 'action2' ) );

				wp_safe_redirect( $redirect );
				exit;
			}

			$this->print_template( $table, $fields, $message );
		}

		/**
		 * Print table template
		 *
		 * @param YITH_YWCTM_Custom_Table $table   The table object.
		 * @param array                   $fields  Fields array.
		 * @param string                  $message Messages.
		 *
		 * @return  void
		 * @since   2.0.0
		 */
		private function print_template( $table, $fields, $message ) {
			$getted          = $_GET; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$list_query_args = array(
				'page'    => $getted['page'],
				'tab'     => $getted['tab'],
				'sub_tab' => $getted['sub_tab'],
			);

			$list_url      = esc_url( add_query_arg( $list_query_args, admin_url( 'admin.php' ) ) );
			$is_empty_list = ! $table->has_items() && empty( $getted['s'] );
			$query_args    = array_merge( $list_query_args, array( 'action' => 'insert' ) );
			$add_form_url  = esc_url( add_query_arg( $query_args, admin_url( 'admin.php' ) ) );

			if ( ! $is_empty_list ) :
				?>
				<a class="page-title-action yith-add-button" href="<?php echo esc_attr( $add_form_url ); ?>"><?php echo esc_html__( 'Add vendor', 'yith-woocommerce-catalog-mode' ); ?></a>
			<?php endif; ?>

			<div class="ywctm-exclusions">
				<?php if ( $message ) : ?>
					<?php include YWCTM_DIR . 'views/list-table/list-table-notice.php'; ?>
				<?php endif; ?>
				<?php
				if ( $is_empty_list ) {
					$this->render_blank_state();

					echo '<style type="text/css">.yith-plugin-fw__panel__content__page__heading { display: none; } .yith-plugin-fw__panel__content.yith-plugin-fw__panel__content--has-header-nav .yith-plugin-fw__panel__content__page .yith-plugin-fw-panel-custom-tab-container { padding-top: 32px; } </style>';
				} else {
					include YWCTM_DIR . 'views/list-table/list-table-form.php';
				}
				?>
				<div class="ywctm-exclusion-list-popup-wrapper vendor-exclusion">
					<?php
					$fields = $this->get_fields();

					$this->get_form( $fields );
					?>
				</div>
				<div class="clear"></div>
			</div>
			<?php
		}

		/**
		 * Retrieve an array of parameters for blank state.
		 *
		 * @return array{
		 * @type string $icon_url The icon URL.
		 * @type string $message  The message to be shown.
		 * @type array  $cta      The call-to-action button args.
		 * }
		 */
		protected function get_blank_state_params() {
			$getted          = $_GET; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$list_query_args = array(
				'page'    => $getted['page'],
				'tab'     => $getted['tab'],
				'sub_tab' => $getted['sub_tab'],
			);
			$query_args      = array_merge( $list_query_args, array( 'action' => 'insert' ) );
			$add_form_url    = esc_url( add_query_arg( $query_args, admin_url( 'admin.php' ) ) );

			return array(
				'icon_url' => YWCTM_ASSETS_URL . '/icons/vendor.svg',
				'message'  => sprintf(
					// translators: all the placeholders are HTML tags to use in the string.
					esc_html_x(
						'%1$sYou don\'t have any vendor yet.%2$s%3$sClick on the "Add vendor" button to add a vendor!%4$s',
						'Text showed when the exclusion list is empty.',
						'yith-woocommerce-catalog-mode'
					),
					'<strong>',
					'</strong>',
					'<p>',
					'</p>',
				),
				'cta'      => array(
					'title' => esc_html__( 'Add vendor', 'yith-woocommerce-catalog-mode' ),
					'url'   => $add_form_url,
					'class' => 'yith-add-button',
				),
			);
		}

		/**
		 * Render blank state.
		 */
		protected function render_blank_state() {
			$component         = $this->get_blank_state_params();
			$component['type'] = 'list-table-blank-state';

			yith_plugin_fw_get_component( $component, true );
		}

		/**
		 * Get field option for current screen
		 *
		 * @param array  $fields Fields array.
		 * @param array  $getted Values array.
		 * @param string $action Action url.
		 *
		 * @return  void
		 * @since   2.1.0
		 */
		private function get_form( $fields, $getted = array(), $action = false ) {
			?>
			<form id="form" method="POST" action="<?php echo esc_url( $action ); ?>">
				<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( basename( __FILE__ ) ) ); ?>" />
				<table class="form-table">
					<tbody>
					<?php foreach ( $fields as $field ) : ?>
						<tr valign="top" class="yith-plugin-fw-panel-wc-row <?php echo esc_attr( $field['type'] ); ?> <?php echo esc_attr( $field['name'] ); ?>">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $field['name'] ); ?>"><?php echo esc_attr( $field['title'] ); ?></label>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( $field['type'] ); ?>">
								<?php yith_plugin_fw_get_field( $field, true ); ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<?php if ( $action ) : ?>
					<input id="<?php echo esc_attr( $getted['action'] ); ?>" name="<?php echo esc_attr( $getted['action'] ); ?>" type="submit" class="<?php echo esc_attr( 'insert' === $getted['action'] ? 'yith-save-button' : 'yith-update-button' ); ?>" value="<?php echo( ( 'insert' === $getted['action'] ) ? esc_html__( 'Add vendor', 'yith-woocommerce-catalog-mode' ) : esc_html__( 'Update vendor', 'yith-woocommerce-catalog-mode' ) ); ?>" />
				<?php endif; ?>
			</form>
			<?php
		}

		/**
		 * Get field option for current screen
		 *
		 * @return  array
		 * @since   2.0.0
		 */
		private function get_fields() {
			$fields = array(
				0 => array(
					'id'       => 'item_ids',
					'name'     => 'item_ids',
					'type'     => 'ajax-terms',
					'multiple' => true,
					'data'     => array(
						'placeholder' => esc_html__( 'Search vendors', 'yith-woocommerce-catalog-mode' ),
						'taxonomy'    => 'yith_shop_vendor',
					),
					'title'    => esc_html__( 'Select vendors', 'yith-woocommerce-catalog-mode' ),
				),
			);

			return $fields;
		}

		/**
		 * Add screen options for exclusions list table template
		 *
		 * @param WP_Screen $current_screen The current screen.
		 *
		 * @return  void
		 * @since   2.0.0
		 */
		public function add_options( $current_screen ) {

			if ( ( 'yith-plugins_page_yith_wc_catalog_mode_panel' === $current_screen->id ) && ( isset( $_GET['tab'] ) && 'exclusions' === $_GET['tab'] ) && ( ! isset( $_GET['action'] ) || ( 'edit' !== $_GET['action'] && 'insert' !== $_GET['action'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended

				$option = 'per_page';
				$args   = array(
					'label'   => esc_html__( 'Vendors', 'yith-woocommerce-catalog-mode' ),
					'default' => 10,
					'option'  => 'vendors_per_page',
				);

				add_screen_option( $option, $args );

			}
		}

		/**
		 * Set screen options for exclusions list table template
		 *
		 * @param string $status Screen status.
		 * @param string $option Option name.
		 * @param string $value  Option value.
		 *
		 * @return  string
		 * @since   2.0.0
		 */
		public function set_options( $status, $option, $value ) {

			return ( 'vendors_per_page' === $option ) ? $value : $status;
		}
	}

	new YWCTM_Vendors_Table();
}
