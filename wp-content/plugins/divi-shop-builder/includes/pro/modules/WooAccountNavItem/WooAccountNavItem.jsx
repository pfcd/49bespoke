// External Dependencies
import React, { Component } from 'react';

import DSWCP_Modules from '../../../loader';

class DSWCP_WooAccountNavItem extends Component {

	static slug = 'ags_woo_account_navigation_item';

	constructor(props) {
		super(props);
		this.processFontIcon = DSWCP_Modules.builderApi.Utils.processFontIcon;
	}

	static css(props) {

		const additionalCss = [];

		return additionalCss;
	}

	render() {
		const title = this.props.item_name ? this.props.item_name : this.props.item_title;

		// Set default icons for nav items
		var icon = '';
		if (this.props.icon) {
			icon = this.props.icon;
		} else if (this.props.item_title === 'Dashboard'){
			icon = '&#xe037;';
		} else if (this.props.item_title === 'Orders'){
			icon = '&#xe07a;';
		} else if (this.props.item_title === 'Downloads'){
			icon = '&#xe092;';
		} else if (this.props.item_title === 'Addresses'){
			icon = '&#xe081;';
		} else if (this.props.item_title === 'Account details'){
			icon = '&#xe08a;';
		} else if (this.props.item_title === 'Logout'){
			icon = '&#xe03e;';
		} else {
			icon = '&#xe037;';
		}


		return (
			<li className={`woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--${this.props.item} ${this.props.index === 0 ? 'is-active': ''}`}>
				<a href="#" data-icon={this.processFontIcon(icon)}>{title}</a>
			</li>
		);
  	}
}

export default DSWCP_WooAccountNavItem;
