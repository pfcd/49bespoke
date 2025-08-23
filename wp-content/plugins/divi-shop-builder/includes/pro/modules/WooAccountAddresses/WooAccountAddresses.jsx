// External Dependencies
import React, { Component } from 'react';

import DSWCP_Modules from '../../../loader';
import './style.scss';
import $ from 'jquery';

class DSWCP_WooAccountAddresses extends Component {

	static slug = 'ags_woo_account_addresses';

	constructor(props) {
		super(props);

		this.state = {
			currentView : 'edit-address'
		};
  	}

	static css(props) {

		const additionalCss = [];

		if( props.button_edit_use_icon === 'on' && props.button_edit_icon ){
			const icon 		= DSWCP_Modules.builderApi.Utils.processFontIcon(props.button_edit_icon);
			const placement = props.button_edit_icon_placement === 'left' ? 'before' : 'after';
			additionalCss.push([{
				selector:    `%%order_class%% .woocommerce-Address .woocommerce-Address-title a.edit::${placement}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		if( props.button_submit_use_icon === 'on' && props.button_submit_icon ){
			const icon 		= DSWCP_Modules.builderApi.Utils.processFontIcon(props.button_submit_icon);
			const placement = props.button_submit_icon_placement === 'left' ? 'before' : 'after';
			additionalCss.push([{
				selector:    `%%order_class%% .woocommerce-address-fields p button[type="submit"]::${placement}`,
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
		switch( this.state.currentView ){
			case 'billing_form':
			case 'submit_button':
				return window.DiviWoocommercePagesBuilderData.account_addresses.billing_form
			case 'shipping_form':
				return window.DiviWoocommercePagesBuilderData.account_addresses.shipping_form
			default:
				return window.DiviWoocommercePagesBuilderData.account_addresses.html_output
		}
	}

	componentDidMount() {
		const topDocument = window.ET_Builder.Frames.top.document;
		$(topDocument).on('click', '.et-fb-form__toggle', this.onToggleActive.bind(this));
	}

	onToggleActive() {
		if( !$(window.ET_Builder.Frames.app.document).find('.ags_woo_account_addresses.et_fb_editing_enabled:first').length ){
			return;
		}

		setTimeout(() => {
			const topDocument = window.ET_Builder.Frames.top.document;
			const node 		  = $(topDocument).find('.et-fb-tabs__panel--active .et-fb-form__toggle-opened:first');

			this.setState({currentView: node.data('name')});
		})
	}
}

export default DSWCP_WooAccountAddresses;
