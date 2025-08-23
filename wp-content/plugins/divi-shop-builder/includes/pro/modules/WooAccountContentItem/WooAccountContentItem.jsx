// External Dependencies
import React, { Component } from 'react';
import parse from 'html-react-parser';

import DSWCP_Modules from '../../../loader';
import DSWCP_WooAccountViewOrder from './../WooAccountViewOrder/WooAccountViewOrder';
import DSWCP_WooAccountOrders from './../WooAccountOrders/WooAccountOrders';
import DSWCP_WooAccountDownloads from './../WooAccountDownloads/WooAccountDownloads';
import DSWCP_WooAccountLogin from './../WooAccountLogin/WooAccountLogin';
import './style.scss';
import {generateStyles} from "../../../module_dependencies/styles";

class DSWCP_WooAccountContentItem extends Component {

	static slug = 'ags_woo_account_content_item';

	static css(props) {

		const additionalCss = [];
		let address = props.address;

		// table td padding
		if( props.view_order_text_margin ) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'margin',
				name: 'view_order_text_margin',
				selector: '%%order_class%% .view-order-wrapper > p:first-of-type',
				cssProperty: 'margin',
				important: true
			}));
		}

		if( 'fullwidth' === props.login_forms_layout  ){
			additionalCss.push([{
				selector:    '%%order_class%% .login-wrapper .col2-set .col-1, %%order_class%% .login-wrapper .col2-set .col-2',
				declaration: `width: 100%; float: none;`
			}]);
		}

		// login form padding
		if( props.login_form_padding ) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'padding',
				name: 'login_form_padding',
				selector: '%%order_class%% .woocommerce-MyAccount-content .login-wrapper form.woocommerce-form-login',
				cssProperty: 'padding',
				important: true
			}));
		}

		// login form margin
		if( props.login_form_margin) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'margin',
				name: 'login_form_margin',
				selector: '%%order_class%% .woocommerce-MyAccount-content .login-wrapper form.woocommerce-form-login',
				cssProperty: 'margin',
				important: true
			}));
		}

		// login form background
		if( props.login_form_bg_color  ){
			additionalCss.push([{
				selector:    '%%order_class%% .login-wrapper form.woocommerce-form-login',
				declaration: `background-color:  ${props.login_form_bg_color} !important;`
			}]);
		}

		// login password button
		if( props.login_form_button_use_icon && props.login_form_button_use_icon === 'on' && props.login_form_button_icon ){
			const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.login_form_button_icon);
			const position = props.login_form_button_icon_placement ? props.login_form_button_icon_placement : 'right';
			additionalCss.push([{
				selector:    `%%order_class%% .login-wrapper .woocommerce-form-login__submit:${position === 'left' ? 'before' : 'after'}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		// register form padding
		if( props.register_form_padding ) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'padding',
				name: 'register_form_padding',
				selector: '%%order_class%% .woocommerce-MyAccount-content .login-wrapper form.woocommerce-form-register',
				cssProperty: 'padding',
				important: true
			}));
		}

		// register form margin
		if( props.register_form_margin) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'margin',
				name: 'register_form_margin',
				selector: '%%order_class%% .woocommerce-MyAccount-content .login-wrapper form.woocommerce-form-register',
				cssProperty: 'margin',
				important: true
			}));
		}

		// register form background
		if( props.register_form_bg_color  ){
			additionalCss.push([{
				selector:    '%%order_class%% .login-wrapper form.woocommerce-form-register',
				declaration: `background-color:  ${props.register_form_bg_color} !important;`
			}]);
		}

		// register password button
		if( props.register_form_button_use_icon && props.register_form_button_use_icon === 'on' && props.register_form_button_icon ){
			const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.register_form_button_icon);
			const position = props.register_form_button_icon_placement ? props.register_form_button_icon_placement : 'right';
			additionalCss.push([{
				selector:    `%%order_class%% .login-wrapper .woocommerce-form-register__submit:${position === 'left' ? 'before' : 'after'}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		// lost password form padding
		if( props.lost_password_form_padding ) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'padding',
				name: 'lost_password_form_padding',
				selector: '%%order_class%% .woocommerce-MyAccount-content .login-wrapper form.woocommerce-ResetPassword',
				cssProperty: 'padding',
				important: true
			}));
		}

		// lost password form margin
		if( props.lost_password_form_margin) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'margin',
				name: 'lost_password_form_margin',
				selector: '%%order_class%% .woocommerce-MyAccount-content .login-wrapper form.woocommerce-ResetPassword',
				cssProperty: 'margin',
				important: true
			}));
		}

		// lost password form background
		if( props.lost_password_form_bg_color  ){
			additionalCss.push([{
				selector:    '%%order_class%% .login-wrapper form.woocommerce-ResetPassword',
				declaration: `background-color:  ${props.lost_password_form_bg_color} !important;`
			}]);
		}

		// lost password button
		if( props.lost_password_form_button_use_icon && props.lost_password_form_button_use_icon === 'on' && props.lost_password_form_button_icon ){
			const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.lost_password_form_button_icon);
			const position = props.lost_password_form_button_icon_placement ? props.lost_password_form_button_icon_placement : 'right';
			additionalCss.push([{
				selector:    `%%order_class%% .login-wrapper form.woocommerce-ResetPassword button.button:${position === 'left' ? 'before' : 'after'}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		//notices

		// billing padding
		if( props.billing_address_padding ) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'padding',
				name: 'billing_address_padding',
				selector: '%%order_class%% .woocommerce-MyAccount-content .view-order-wrapper .woocommerce-customer-details .woocommerce-column--billing-address address',
				cssProperty: 'padding',
				important: true
			}));
		}

		// billing margin
		if( props.billing_address_margin ) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'margin',
				name: 'billing_address_margin',
				selector: '%%order_class%% .woocommerce-MyAccount-content .view-order-wrapper .woocommerce-customer-details .woocommerce-column--billing-address address',
				cssProperty: 'margin',
				important: true
			}));
		}

		// billing background
		if( props.billing_address_background ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-MyAccount-content .view-order-wrapper .woocommerce-customer-details .woocommerce-column--billing-address address',
				declaration: `background-color:  ${props.billing_address_background};`
			}]);
		}


		// shipping padding
		if( props.shipping_address_padding ) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'padding',
				name: 'shipping_address_padding',
				selector: '%%order_class%% .woocommerce-MyAccount-content .view-order-wrapper .woocommerce-customer-details .woocommerce-column--shipping-address address',
				cssProperty: 'padding',
				important: true
			}));
		}

		// shipping margin
		if( props.shipping_address_margin ) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'margin',
				name: 'shipping_address_margin',
				selector: '%%order_class%% .woocommerce-MyAccount-content .view-order-wrapper .woocommerce-customer-details .woocommerce-column--shipping-address address',
				cssProperty: 'margin',
				important: true
			}));
		}

		// shipping background
		if( props.shipping_address_background ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-MyAccount-content .view-order-wrapper .woocommerce-customer-details .woocommerce-column--shipping-address address',
				declaration: `background-color:  ${props.shipping_address_background};`
			}]);
		}

		// address padding
		if( props.address_billing_shipping_padding ) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'padding',
				name: 'address_billing_shipping_padding',
				selector: '%%order_class%% .woocommerce-MyAccount-content .edit-address-wrapper .woocommerce-Address',
				cssProperty: 'padding',
				important: true
			}));
		}

		// address margin
		if( props.address_billing_shipping_margin ) {
			additionalCss.push(generateStyles({
				address,
				attrs: props,
				type: 'margin',
				name: 'address_billing_shipping_margin',
				selector: '%%order_class%% .woocommerce-MyAccount-content .edit-address-wrapper .woocommerce-Address',
				cssProperty: 'margin',
				important: true
			}));
		}

		// address background
		if( props.address_billing_shipping_background ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-MyAccount-content .edit-address-wrapper .woocommerce-Address',
				declaration: `background-color:  ${props.address_billing_shipping_background};`
			}]);
		}

		if( props.orders_button_view_use_icon && props.orders_button_view_use_icon === 'on' && props.orders_button_view_icon ){
			const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.orders_button_view_icon);
			const position = props.orders_button_view_icon_placement ? props.orders_button_view_icon_placement : 'right';
			additionalCss.push([{
				selector:    `%%order_class%% .woocommerce-MyAccount-content .orders-wrapper table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions .button:${position === 'left' ? 'before' : 'after'}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		if( props.orders_button_browse_use_icon && props.orders_button_browse_use_icon === 'on' && props.orders_button_browse_icon ){
			const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.orders_button_browse_icon);
			const position = props.orders_button_browse_icon_placement ? props.orders_button_browse_icon_placement : 'right';
			additionalCss.push([{
				selector:    `%%order_class%% .woocommerce-MyAccount-content .orders-wrapper .woocommerce-Message.woocommerce-Message--info .button:${position === 'left' ? 'before' : 'after'}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		if( props.orders_no_items_bg_color  ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-MyAccount-content .orders-wrapper .woocommerce-Message.woocommerce-Message--info',
				declaration: `background-color:  ${props.orders_no_items_bg_color} !important;`
			}]);
		}


		if( props.downloads_button_view_use_icon && props.downloads_button_view_use_icon === 'on' && props.downloads_button_view_icon ){
			const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.downloads_button_view_icon);
			const position = props.downloads_button_view_icon_placement ? props.downloads_button_view_icon_placement : 'right';
			additionalCss.push([{
				selector:    `%%order_class%% .woocommerce-MyAccount-content .downloads-wrapper table.woocommerce-table--order-downloads td.download-file .button:${position === 'left' ? 'before' : 'after'}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		if( props.downloads_button_browse_use_icon && props.downloads_button_browse_use_icon === 'on' && props.downloads_button_browse_icon ){
			const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.downloads_button_browse_icon);
			const position = props.downloads_button_browse_icon_placement ? props.downloads_button_browse_icon_placement : 'right';
			additionalCss.push([{
				selector:    `%%order_class%% .woocommerce-MyAccount-content .downloads-wrapper .woocommerce-Message.woocommerce-Message--info .button:${position === 'left' ? 'before' : 'after'}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		if( props.downloads_no_items_bg_color  ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-MyAccount-content .downloads-wrapper .woocommerce-Message.woocommerce-Message--info',
				declaration: `background-color:  ${props.downloads_no_items_bg_color} !important;`
			}]);
		}

		if( props.account_details_submit_use_icon && props.account_details_submit_use_icon === 'on' && props.account_details_submit_icon ){
			const icon 		= DSWCP_Modules.builderApi.Utils.processFontIcon(props.account_details_submit_icon);
			const position  = props.account_details_submit_icon_placement ? props.account_details_submit_icon_placement : 'right';
			additionalCss.push([{
				selector:    `%%order_class%% .woocommerce-MyAccount-content .edit-account-wrapper .woocommerce-EditAccountForm.edit-account p button[type='submit']:${position === 'left' ? 'before' : 'after'}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		if( props.address_button_edit_use_icon && props.address_button_edit_use_icon === 'on' && props.address_button_edit_icon ){
			const icon	   = DSWCP_Modules.builderApi.Utils.processFontIcon(props.address_button_edit_icon);
			const position = props.address_button_edit_icon_placement ? props.address_button_edit_icon_placement : 'right';
			additionalCss.push([{
				selector:    `%%order_class%% .woocommerce-MyAccount-content .edit-address-wrapper .woocommerce-Address .woocommerce-Address-title a.edit::${position === 'left' ? 'before' : 'after'}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		if( props.address_billing_button_save_use_icon && props.address_billing_button_save_use_icon === 'on' && props.address_billing_button_save_icon ){
			const icon	   = DSWCP_Modules.builderApi.Utils.processFontIcon(props.address_billing_button_save_icon);
			const position = props.address_billing_button_save_icon_placement ? props.address_billing_button_save_icon_placement : 'right';
			additionalCss.push([{
				selector:    `%%order_class%% .woocommerce-MyAccount-content .edit-billing-wrapper .woocommerce-address-fields p button[type='submit']::${position === 'left' ? 'before' : 'after'}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		if( props.address_shipping_button_save_use_icon && props.address_shipping_button_save_use_icon === 'on' && props.address_shipping_button_save_icon ){
			const icon	   = DSWCP_Modules.builderApi.Utils.processFontIcon(props.address_shipping_button_save_icon);
			const position = props.address_shipping_button_save_icon_placement ? props.address_shipping_button_save_icon_placement : 'right';
			additionalCss.push([{
				selector:    `%%order_class%% .woocommerce-MyAccount-content .edit-shipping-wrapper .woocommerce-address-fields p button[type='submit']::${position === 'left' ? 'before' : 'after'}`,
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		return additionalCss;
	}

	render() {
		const currentItem = this.props.item ? this.props.item : 'dashboard';
		return (
			( 'edit-address' === this.props.current_view && currentItem ==='edit-address' && <div dangerouslySetInnerHTML={{ __html: this.getHTMLByType('edit-address') }}></div> ) ||
			( 'dashboard' === this.props.current_view && currentItem ==='dashboard' && <div dangerouslySetInnerHTML={{ __html: this.getHTMLByType('dashboard') }}></div> ) ||
			( 'subscriptions' === this.props.current_view && currentItem ==='subscriptions' && <div dangerouslySetInnerHTML={{ __html: this.getHTMLByType('subscriptions') }}></div> ) ||
			( 'edit-account' === this.props.current_view && currentItem ==='edit-account' && <div dangerouslySetInnerHTML={{ __html: this.getHTMLByType('edit-account') }}></div> ) ||
			( 'login' === this.props.current_view && currentItem ==='login' &&  this.getLoginHTML()  ) ||
			( 'lost-password' === this.props.current_view && currentItem ==='login' && <div dangerouslySetInnerHTML={{ __html: this.getLostPasswordHTML() }}></div>) ||
			( ['edit-billing', 'edit-shipping'].includes( this.props.current_view ) && currentItem === 'edit-address' && <div dangerouslySetInnerHTML={{ __html: this.getHTMLByType(this.props.current_view) }}></div> ) ||
			( 'view-order' === this.props.current_view && currentItem === 'orders' && this.getViewOrderHTML() ) ||
			( 'orders' === this.props.current_view && currentItem ==='orders' && this.getOrdersHTML() ) ||
			( 'downloads' === this.props.current_view && currentItem ==='downloads' && this.getDownloadsHTML() )

		);
  	}

	getHTMLByType( type = 'dashboard' ){
		const item = `${type}_html`;
		return window.DiviWoocommercePagesBuilderData.account_contents[item] ? window.DiviWoocommercePagesBuilderData.account_contents[item] : '';
	}

	getViewOrderHTML(){
		const props = this.props;
		return (
			<DSWCP_WooAccountViewOrder {...props}></DSWCP_WooAccountViewOrder>
		)
	}

	getOrdersHTML(){
		const props = this.props;
		return (
			<DSWCP_WooAccountOrders {...props}></DSWCP_WooAccountOrders>
		)
	}
	getDownloadsHTML(){
		const props = this.props;
		return (
			<DSWCP_WooAccountDownloads {...props}></DSWCP_WooAccountDownloads>
		)
	}
	getLoginHTML(){
		const props = this.props;
		return (
			<DSWCP_WooAccountLogin {...props}></DSWCP_WooAccountLogin>
		)
	}
	getLostPasswordHTML(){
		return window.DiviWoocommercePagesBuilderData.account_contents.lost_password_html ? window.DiviWoocommercePagesBuilderData.account_contents.lost_password_html : '';
	}


}

export default DSWCP_WooAccountContentItem;
