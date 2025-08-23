// External Dependencies
import React, { Component } from 'react';

import DSWCP_Modules from '../../../loader';

class DSWCP_WooAccountDetails extends Component {

	static slug = 'ags_woo_account_details';

	static css(props) {

		const additionalCss = [];

		if( props.button_submit_use_icon === 'on' && props.button_submit_icon ){
			const icon 		= DSWCP_Modules.builderApi.Utils.processFontIcon(props.button_submit_icon);
			const placement = props.button_submit_icon_placement === 'left' ? 'before' : 'after';
			additionalCss.push([{
				selector:    `%%order_class%% .woocommerce-EditAccountForm.edit-account p button[type='submit']::${placement}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		return additionalCss;
	}

	render() {
		return (
			<div className="woocommerce"><div className="woocommerce-MyAccount-content" dangerouslySetInnerHTML={{__html: this.html()}}></div></div>
		);
  	}

	html() {
		return window.DiviWoocommercePagesBuilderData.account_details.output
	}

}

export default DSWCP_WooAccountDetails;
