/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/

// External Dependencies
import React, { Component, Fragment } from 'react';
import parse from 'html-react-parser';
import NumberFormat from 'react-number-format';
import Mixins from './../../../mixins';

// Internal Dependencies
import './style.scss';

import DSWCP_Modules from '../../../loader';

class DSWCP_WooCartTotals extends Component {

	static slug = 'ags_woo_cart_totals';

	static css(props) {

		const additionalCss = [];

		if( props.checkout_button_width !== '100%' ){
			additionalCss.push([{
				selector:    '%%order_class%% .cart-collaterals .wc-proceed-to-checkout .checkout-button',
				declaration: `width: ${props.checkout_button_width} !important;`
			}]);
		}

		const corners = { top: 0, right: 1, bottom: 2, left: 3 };

		if( props.table_heading_padding !== '9px|12px|9px|12px|on|on' ){
			const values = props.table_heading_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .cart-collaterals table.shop_table th',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});

		}

		if( props.table_body_padding !== '9px|12px|9px|12px|on|on' ){
			const values = props.table_body_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .cart-collaterals table.shop_table td',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});

		}

		return additionalCss;
	}

	constructor(props) {
		super(props);

		this.classnames 	 	  = DSWCP_Modules.builderApi.Utils.classnames;
		this.processFontIcon 	  = DSWCP_Modules.builderApi.Utils.processFontIcon;
		this.componentWillUnmount = Mixins.componentWillUnmount.bind(this);
  	}

	render() {

    	// woocommerce/templates/cart/cart.php
    	return (
			<div>
				<div className="cart-collaterals">
					<div className="cart_totals ">
						<h2>{this.getResponsiveProp('cart_totals_title')}</h2>

						<table cellSpacing="0" className="shop_table shop_table_responsive">
							<tbody>
								<tr className="cart-subtotal">
									<th>{this.getResponsiveProp('cart_totals_subtotal_text')}</th>
									<td data-title={this.getResponsiveProp('cart_totals_subtotal_text')}><span className="woocommerce-Price-amount amount">{this.wcPrice()}</span></td>
								</tr>
								<tr className="order-total">
									<th>{this.getResponsiveProp('cart_totals_total_text')}</th>
									<td data-title={this.getResponsiveProp('cart_totals_total_text')}><strong><span className="woocommerce-Price-amount amount">{this.wcPrice()}</span></strong> </td>
								</tr>

							</tbody>
						</table>

						<div className="wc-proceed-to-checkout">
							<a href="#" className="checkout-button button alt wc-forward" data-icon={this.processFontIcon(this.props.button_checkout_icon)}>
							{this.getResponsiveProp('checkout_button_text')}</a>
						</div>

					</div>
				</div>
			</div>
    	);
	}

	getResponsiveProp( prop, defaultVal = '' ){

		const view = window.ET_Builder.Frames.app.ET_Builder.API.State.View_Mode;

		let value;

		if( view.isTablet() ){
			// checks if state is set for the tablet or assign the main view
			value = typeof( this.props[`${prop}_tablet`] ) !== 'undefined' ? this.props[`${prop}_tablet`] : this.props[prop];
		}else if( view.isPhone() ){
			// checks if state is set for the mobile or assign the parent views by descending order ( phone ->tablet -> desktop )
			value = typeof( this.props[`${prop}_phone`] ) !== 'undefined' ?
				this.props[`${prop}_phone`] : typeof( this.props[`${prop}_tablet`] ) !== 'undefined' ?
					this.props[`${prop}_tablet`] : this.props[prop];
		}else{
			value = this.props[prop];
		}

		return value ? value : defaultVal;
	}

	wcPrice( price = '0.00' ){
		const { thousand_separator, decimal_separator, decimals, price_format, currency } = window.DiviWoocommercePagesBuilderData.price_format;
		return (
			<NumberFormat
				value={parseFloat(price)} displayType={'text'}
				thousandSeparator={thousand_separator} decimalSeparator={decimal_separator}
				decimalScale={decimals} fixedDecimalScale={true}
				renderText={value => parse( price_format.replace('%1$s', currency).replace('%2$s', value) )}
			/>
		);
	}

	localizedText( key ){
		const translations = window.DiviWoocommercePagesBuilderData.cart_list.locals;
		return translations[key] ? translations[key] : '';
	}
}

export default DSWCP_WooCartTotals;
