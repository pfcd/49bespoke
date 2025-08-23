/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/

// External Dependencies
import React, { Component } from 'react';
import parse from 'html-react-parser';
import NumberFormat from 'react-number-format';

// Internal Dependencies
import './style.scss';
import getResponsiveProp from './../Abstracts/Responsive';
import Mixins from './../../../mixins';
import DSWCP_Modules from '../../../loader';

class DSWCP_WooCheckoutOrderReview extends Component {

	static slug = 'ags_woo_checkout_order_review';

	constructor(props) {
		super(props);
		this.state = {
			checkedMethod: Object.keys( window.DiviWoocommercePagesBuilderData.order_review.payment_methods )[0]
		};
		this.getResponsiveProp = getResponsiveProp.bind(this);
		this.componentWillUnmount = Mixins.componentWillUnmount.bind(this);
		this.processFontIcon 	  = DSWCP_Modules.builderApi.Utils.processFontIcon;
  	}

	static css(props) {

		const additionalCss = [];

		if( props.payment_bg !== '#ebe9eb' ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-checkout-review-order .woocommerce-checkout-payment',
				declaration: `background-color: ${props.payment_bg} !important;`
			}]);
		}

		if( props.payment_desc_bg !== '#dfdcde' ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-checkout-review-order .woocommerce-checkout-payment div.payment_box',
				declaration: `background-color: ${props.payment_desc_bg} !important;`
			}]);

			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-checkout-review-order .woocommerce-checkout-payment div.payment_box::before',
				declaration: `border-bottom-color: ${props.payment_desc_bg} !important;`
			}]);
		}

		const corners = { top: 0, right: 1, bottom: 2, left: 3 };

		if( props.payment_padding && props.payment_padding !== '||||false|false' ){
			const values = props.payment_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-checkout-review-order .woocommerce-checkout-payment',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.payment_margin && props.payment_margin !== '||||false|false' ){
			const values = props.payment_margin.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-checkout-review-order .woocommerce-checkout-payment',
					declaration: `margin-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.table_heading_padding && props.table_heading_padding !== '9px|12px|9px|12px|on|on' ){
			const values = props.table_heading_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-checkout-review-order table.woocommerce-checkout-review-order-table th',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.table_body_padding && props.table_body_padding !== '9px|12px|9px|12px|on|on' ){
			const values = props.table_body_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-checkout-review-order table.woocommerce-checkout-review-order-table td',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}



		return additionalCss;
	}

	render() {

    	// woocommerce/templates/checkout/review-order.php
    	return (
			<form onSubmit={(e) => e.preventDefault()} className="checkout woocommerce-checkout">
				<h3 id="order_review_heading">{this.getResponsiveProp('order_review_heading')}</h3>
				<div id="order_review" className="woocommerce-checkout-review-order">
					<table className="shop_table woocommerce-checkout-review-order-table">
						<thead>
							<tr>
								<th className="product-name">{this.localizedText('product_th')}</th>
								<th className="product-total">{this.localizedText('subtotal_th')}</th>
							</tr>
						</thead>
						<tbody>
							<tr className="cart_item">
								<td className="product-name">{this.localizedText('cart_item_name')} <strong className="product-quantity">× 1</strong></td>
								<td className="product-total"></td>
							</tr>
						</tbody>
						<tfoot>
							<tr className="cart-subtotal">
								<th>{this.localizedText('subtotal_th')}</th>
								<td>{this.wcPrice()}</td>
							</tr>
							<tr className="woocommerce-shipping-totals shipping">
								<th>{this.localizedText('shipping_th')}</th>
								<td data-title="Shipping">{this.localizedText('shipping_name')}</td>
							</tr>
							<tr className="order-total">
								<th>{this.localizedText('total_th')}</th>
								<td><strong>{this.wcPrice()}</strong></td>
							</tr>
						</tfoot>
					</table>

					<div id="payment" className="woocommerce-checkout-payment">
						<ul className="wc_payment_methods payment_methods methods">
							{ this.paymentMethods().map( ( method ) =>
								<li key={method.id} className={`wc_payment_method payment_method_${method.id}`}>
									<input id={`payment_method_${method.id}`} type="radio" className="input-radio" name="payment_method" checked={this.state.checkedMethod ===  method.id} onChange={() => this.setState({checkedMethod: method.id})} />
									<label htmlFor={`payment_method_${method.id}`}>{ method.title }</label>
									{ this.state.checkedMethod === method.id  &&
									<div className={`payment_box payment_method_${method.id}`}>
										<p>{method.description}</p>
									</div>
									}
								</li>
							) }
						</ul>
						<div className="form-row place-order">
							<div className="woocommerce-terms-and-conditions-wrapper">
								{this.props['privacy_policy'] === 'on' &&
								<div className="woocommerce-privacy-policy-text">
									{parse(window.DiviWoocommercePagesBuilderData.order_review.checkout_policy_text)}
								</div>
								}
								{this.props['checkout_policy'] === 'on' &&
								<p className="form-row validate-required">
									<label className="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
										<input type="checkbox" className="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" id="terms" />
										<span className="woocommerce-terms-and-conditions-checkbox-text">{parse( window.DiviWoocommercePagesBuilderData.order_review.terms_and_condition_text )}</span> <span className="required">*</span>
									</label>
								</p>
								}
							</div>
							<button type="submit" className="button alt" name="woocommerce_checkout_place_order" id="place_order" value="Place order" data-value="Place order" data-icon={this.processFontIcon(this.props.place_order_button_icon)}>
								{this.getResponsiveProp('place_order_text')}
							</button>
						</div>
					</div>
				</div>
			</form>
    	);
	}

	localizedText( key ){
		const translations = window.DiviWoocommercePagesBuilderData.order_review.locals;
		return translations[key] ? translations[key] : '';
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

	paymentMethods(){

		const methods = window.DiviWoocommercePagesBuilderData.order_review.payment_methods;
		return Object.keys( methods ).filter((method) => methods[method].enabled === 'yes').map( (method) => methods[method] );
	}
}

export default DSWCP_WooCheckoutOrderReview;
