<?php

namespace Barn2\Plugin\WC_Product_Table\Admin;

use Barn2\Plugin\WC_Product_Table\Util\Settings as Util_Settings;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Plugin\Licensed_Plugin;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\WooCommerce\Admin\Custom_Settings_Fields;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\WooCommerce\Admin\Plugin_Promo;
use Barn2\Plugin\WC_Product_Table\Admin\Settings_Tab\Tables;
use Barn2\Plugin\WC_Product_Table\Admin\Settings_Tab\Settings;
use Barn2\Plugin\WC_Product_Table\Admin\Settings_Tab\Design;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Standard_Service;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Util as Lib_Util;
use Barn2\Plugin\WC_Product_Table\Util\Util;

/**
 * Provides functions for the plugin settings page in the WordPress admin.
 *
 * Settings can be accessed at WooCommerce -> Settings -> Products -> Product tables.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Settings_Page implements Registerable, Standard_Service {

	private $plugin;

	public $registered_settings = [];

	public function __construct( Licensed_Plugin $plugin ) {
		$this->plugin              = $plugin;
		$this->registered_settings = $this->get_settings_tabs();
	}

	public function register() {
		Lib_Util::register_services( $this->registered_settings );

		add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
		add_action( 'admin_init', [ $this, 'back_compat_settings' ] );

		// Add sections & settings.
		add_filter( 'woocommerce_get_sections_products', [ $this, 'add_section' ] );
		add_filter( 'woocommerce_get_settings_products', [ $this, 'add_settings' ], 10, 2 );

		// Support old settings structure.
		add_action( 'woocommerce_settings_products', [ $this, 'back_compat_settings' ], 5 );
		add_action( 'admin_notices', [ $this, 'display_cache_cleared_notice' ] );
		add_action( 'wp_ajax_clear_table_cache', [ $this, 'clear_table_cache' ] );
	}

	/**
	 * Retrieves the settings tab classes.
	 *
	 * @return array
	 */
	private function get_settings_tabs() {
		$settings_tabs = [
			Tables::TAB_ID   => new Tables( $this->plugin ),
			Settings::TAB_ID => new Settings( $this->plugin ),
			Design::TAB_ID   => new Design( $this->plugin ),
		];

		return $settings_tabs;
	}

	/**
	 * Register the Settings submenu page.
	 */
	public function add_settings_page() {
		add_submenu_page(
			'edit.php?post_type=product',
			__( 'Product Tables', 'woocommerce-product-table' ),
			__( 'Product Tables', 'woocommerce-product-table' ),
			'manage_woocommerce',
			'tables',
			[ $this, 'render_settings_page' ],
		);
	}

	/**
	 * Render the Settings page.
	 */
	public function render_settings_page() {
		$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'tables';

		if ( $active_tab === 'tables' && isset( $_GET['add-new'] ) ) {
			echo $this->registered_settings[ $active_tab ]->output();
		} else {
			?>
		<div class="barn2-layout__header">
			<div class="barn2-layout__header-wrapper">
				<h3 class="barn2-layout__header-heading">
			<?php esc_html_e( 'Product Tables', 'woocommerce-product-table' ); ?>
				</h3>
				<div class="links-area">
			<?php $this->support_links(); ?>
				</div>
			</div>
		</div>
		<div id="b2-pages-wrapper" class="wrap">
			<?php do_action( 'barn2_before_plugin_settings', $this->plugin->get_id() ); ?>
			<div class="barn2-settings-inner">

				<h2 class="nav-tab-wrapper">
			<?php
			foreach ( $this->registered_settings as $setting_tab ) {
				$active_class = $active_tab === $setting_tab->get_id() ? ' nav-tab-active' : '';
				$url          = $setting_tab->get_id() === 'tables' ? 'edit.php?post_type=product&page=tables' : 'edit.php?post_type=product&page=tables&tab=' . $setting_tab->get_id();
				?>
						<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( sprintf( 'nav-tab%s', $active_class ) ); ?>">
				<?php echo esc_html( $setting_tab->get_title() ); ?>
						</a>
				<?php
			}
			?>
				</h2>

				<h1></h1>

				<div class="inside-wrapper">
			<?php if ( $active_tab === 'tables' ) : ?>
				<?php echo $this->registered_settings[ $active_tab ]->output(); ?>
					<?php else : ?>
						<?php if ( $active_tab === 'settings' ) : ?>
							<h2>
							<?php esc_html_e( 'Product Tables', 'woocommerce-product-table' ); ?>
							</h2>
							<p>
							<?php
							// translators: 1: help link open tag, 2: help link close tag.
							printf(
								esc_html__( 'Use this page to configure default settings which will apply to all product tables.', 'woocommerce-product-table' ),
								Lib_Util::format_barn2_link_open( 'kb/product-table-options', true ),
								'</a>'
							);
							?>
							</p>
						<?php endif; ?>

						<form action="options.php" method="post">
						<?php
						settings_errors();
						settings_fields( $this->registered_settings[ $active_tab ]::OPTION_GROUP );
						do_settings_sections( $this->registered_settings[ $active_tab ]::MENU_SLUG );
						?>
						<p class="submit">
							<input name="Submit" type="submit" name="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'woocommerce-product-table' ); ?>" />
							<input name="clear_cache" type="button" name="clear_cache" class="button button-default" value="<?php esc_attr_e( 'Clear Cache', 'woocommerce-product-table' ); ?>" />

							<?php if ( $active_tab === 'design' ) : ?>
							<button type="button" name="reset_design_settings" class="button button-default">
								<img src="<?php echo Util::get_asset_url( 'images/reset-icon.svg' ); ?>" alt="reset-icon">
								<?php esc_attr_e( 'Reset to default', 'woocommerce-product-table' ); ?>
							</button>
							<?php endif; ?>
						</p>
						</form>
					<?php endif; ?>
				</div>

			</div>
			<?php do_action( 'barn2_after_plugin_settings', $this->plugin->get_id() ); ?>
		</div>
			<?php
		}
	}

	/**
	 * Output the Barn2 Support Links.
	 */
	public function support_links() {
		printf(
			'<p>%s | %s | %s</p>',
      // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
			Lib_Util::format_link( $this->plugin->get_documentation_url(), __( 'Documentation', 'woocommerce-product-table' ), true ),
			Lib_Util::format_link( $this->plugin->get_support_url(), __( 'Support', 'woocommerce-product-table' ), true ),
			sprintf(
				'<a class="barn2-wiz-restart-btn" href="%s">%s</a>',
				admin_url( 'edit.php?post_type=product&page=tables&add-new&wizard=1' ),
				__( 'Setup wizard', 'woocommerce-product-table' )
			)
      // phpcs:enable
		);
	}

	public function add_section( $sections ) {
		$sections[ Util_Settings::SECTION_SLUG ] = __( 'Product tables', 'woocommerce-product-table' );

		return $sections;
	}

	public function add_settings( $settings, $current_section ) {
		// Check we're on the correct settings section
		if ( Util_Settings::SECTION_SLUG !== $current_section ) {
			return $settings;
		}

		return Settings_List::get_all_settings( $this->plugin );
	}

	/**
	 * Display admin notice after cache cleared
	 *
	 * @return void
	 */
	public function display_cache_cleared_notice() {
		// Check if the transient is set
		if ( ! get_transient( 'wcpt_cache_cleared_notice' ) ) {
			return;
		}

		printf(
			'<div class="notice notice-success is-dismissible"><p><b>%s</b></p></div>',
			esc_html__( 'Cache cleared.', 'woocommerce-product-table' )
		);

		// Delete the transient so the notice is shown only once
		delete_transient( 'wcpt_cache_cleared_notice' );
	}

	/**
	 * Clear table cache on AJAX request
	 * and set a transient to display a one time admin notice
	 *
	 * @return void
	 */
	public function clear_table_cache() {
		check_ajax_referer( 'wcpt-admin', 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'Unauthorized user', 403 );
			return;
		}

		// Delete table transients
		Util::delete_table_transients();
		// set transient to be used for admin notice purposes
		set_transient( 'wcpt_cache_cleared_notice', true, 30 );

		wp_send_json_success();
	}

	public function back_compat_settings() {

		$shortcode_defaults = get_option( Util_Settings::OPTION_TABLE_DEFAULTS, [] );
		$misc_settings      = get_option( Util_Settings::OPTION_MISC, [] );

		if ( ! empty( $shortcode_defaults['add_selected_text'] ) ) {
			$misc_settings['add_selected_text'] = $shortcode_defaults['add_selected_text'];
			update_option( Util_Settings::OPTION_MISC, $misc_settings );

			unset( $shortcode_defaults['add_selected_text'] );
			update_option( Util_Settings::OPTION_TABLE_DEFAULTS, $shortcode_defaults );
		}

		if ( isset( $shortcode_defaults['show_quantity'] ) ) {
			$shortcode_defaults['quantities'] = $shortcode_defaults['show_quantity'];

			unset( $shortcode_defaults['show_quantity'] );
			update_option( Util_Settings::OPTION_TABLE_DEFAULTS, $shortcode_defaults );
		}

		if ( isset( $shortcode_defaults['variation_name_format'] ) ) {
			$shortcode_defaults['variation_name_format'] = $misc_settings['variation_name_format'];
			update_option( Util_Settings::OPTION_TABLE_DEFAULTS, $shortcode_defaults );
		}
	}
}
