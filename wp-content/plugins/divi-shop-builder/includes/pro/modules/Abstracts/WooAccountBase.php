<?php

defined( 'ABSPATH' ) || exit;

/**
 * Base class of Woo My Account Modules
 *
 */
class DSWCP_WooAccountBase extends ET_Builder_Module {

	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

    protected function _can_render(){
        return is_user_logged_in() && WC()->customer && ( dswcp_is_account_endpoint( $this->endpoint ) || et_core_is_fb_enabled() );
    }

	protected function _render_module_wrapper( $output = '', $render_slug = '' ){

		if( !$this->_can_render() ){
			return '';
		}

		return parent::_render_module_wrapper( $output, $render_slug );
	}
}