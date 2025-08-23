// External Dependencies
import React, { Component } from 'react';

class DSWCP_WooAccountDashboard extends Component {

	static slug = 'ags_woo_account_dashboard';

	render() {
		return (
			<div dangerouslySetInnerHTML={{__html: this.html()}}></div>
		);
  	}

	html() {
		return window.DiviWoocommercePagesBuilderData.account_dashboard.html_output;
	}
}

export default DSWCP_WooAccountDashboard;
