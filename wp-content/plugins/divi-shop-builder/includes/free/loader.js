// External Dependencies
import { Component } from 'react';
import $ from 'jquery';

class DSWCP_Modules_Free {

	static init() {
		$(window).on('et_builder_api_ready', (event, API) => {
		  API.registerModules(
			[
				'ags_woo_account_content', 'ags_woo_account_navigation', 'ags_woo_account_user_image', 'ags_woo_account_user_name', 'ags_woo_cart_list', 'ags_woo_cart_totals', 'ags_woo_checkout_billing_info', 'ags_woo_checkout_coupon', 'ags_woo_checkout_order_review', 'ags_woo_checkout_shipping_info', 'ags_woo_login_form', 'ags_woo_mini_cart', 'ags_woo_multi_step_checkout', 'ags_woo_products_filters', 'ags_woo_register_form', 'ags_woo_thank_you',
			].map(function(moduleSlug) {
				class PlaceholderModule extends Component {

					static slug = moduleSlug;

					render() {
						return null;
					}
				}
				
				return PlaceholderModule;
			})
		  );
		});
	}

}

DSWCP_Modules_Free.init();

export default DSWCP_Modules_Free;