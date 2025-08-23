<?php

namespace Barn2\Plugin\WC_Product_Table;

use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Plugin\Licensed_Plugin;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Plugin\Plugin_Activation_Listener;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Standard_Service;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Util;

/**
 * Handles the setup of the plugin setup wizard.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Plugin_Setup implements Plugin_Activation_Listener, Registerable, Standard_Service {

	/**
	 * Instance of the plugin.
	 *
	 * @var Licensed_Plugin
	 */
	private $plugin;

	/**
	 * Plugin slug.
	 *
	 * @var string
	 */
	private $slug;

	/**
	 * Constructor.
	 *
	 * @param Licensed_Plugin $plugin The plugin instance.
	 */
	public function __construct( Licensed_Plugin $plugin ) {
		$this->plugin = $plugin;
		$this->slug   = $plugin->get_slug();
	}

	/**
	 * Registers activation hooks and admin actions.
	 *
	 * @return void
	 */
	public function register() {
		register_activation_hook( $this->plugin->get_file(), [ $this, 'on_activate' ] );
		add_action( 'admin_init', [ $this, 'after_plugin_activation' ] );
	}

	/**
	 * Handles actions to perform on plugin activation.
	 *
	 * @param bool $network_wide Whether the plugin is being activated network-wide.
	 * @return void
	 */
	public function on_activate( $network_wide ) {
		$this->update_plugin_data();
		$this->maybe_redirect();
	}

	/**
	 * Handles actions to perform on plugin deactivation.
	 *
	 * @param bool $network_wide Whether the plugin is being deactivated network-wide.
	 * @return void
	 */
	public function on_deactivate( $network_wide ) {
	}

	/**
	 * Checks if the activation redirect transient exists.
	 *
	 * @return bool True if the transient exists, false otherwise.
	 */
	public function detected() {
		return get_transient( "_{$this->slug}_activation_redirect" );
	}

	/**
	 * Creates a transient to trigger the setup wizard on activation.
	 *
	 * @return void
	 */
	public function create_transient() {
		set_transient( "_{$this->slug}_activation_redirect", \true, 30 );
	}

	/**
	 * Deletes the activation redirect transient.
	 *
	 * @return void
	 */
	public function delete_transient() {
		delete_transient( "_{$this->slug}_activation_redirect" );
	}

	/**
	 * Conditionally creates a transient for redirecting to the setup wizard.
	 *
	 * @return void
	 */
	public function maybe_redirect() {
		if ( $this->plugin->has_valid_license() && Util::is_woocommerce_active() ) {
			return;
		}
		$this->create_transient();
	}

	/**
	 * Updates the plugin version in the database.
	 *
	 * @return void
	 */
	public function update_plugin_data() {
		update_option( $this->slug . '_version', $this->plugin->get_version() );
	}

	/**
	 * Redirects to the setup wizard if the activation transient is detected.
	 *
	 * @return void
	 */
	public function after_plugin_activation() {
		if ( ! $this->detected() ) {
			return;
		}

		$this->delete_transient();
		$this->redirect();
	}

	/**
	 * Redirects to the product table generator page with the wizard flag.
	 *
	 * @return void
	 */
	public function redirect() {
		$url = admin_url( 'edit.php?post_type=product&page=tables&add-new&wizard=1' );
		wp_safe_redirect( $url );
		exit;
	}
}