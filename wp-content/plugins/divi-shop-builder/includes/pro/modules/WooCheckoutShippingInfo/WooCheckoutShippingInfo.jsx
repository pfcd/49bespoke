/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/

// External Dependencies
import React, { Component } from 'react';
import parse from 'html-react-parser';
import getResponsiveProp from './../Abstracts/Responsive';
import $ from 'jquery';
import ReactDom from 'react-dom';

// Internal Dependencies
import Mixins from './../../../mixins';
import './style.scss';

class DSWCP_WooCheckoutShippingInfo extends Component {

	static slug = 'ags_woo_checkout_shipping_info';

	constructor(props) {
		super(props);
		this.state = {
			isToggled: true,
		};
		this.getResponsiveProp = getResponsiveProp.bind(this);
		this.componentWillUnmount = Mixins.componentWillUnmount.bind(this);
  	}

	render() {

    	// woocommerce/templates/checkout/form-shipping.php
    	return (
			<form onSubmit={(e) => e.preventDefault()} className="checkout woocommerce-checkout">
				<div className="woocommerce-shipping-fields">
					<h3>
						<label className="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
							<input className="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" type="checkbox" onChange={() => this.setState({ isToggled: !this.state.isToggled })}/>
						</label>
						<span>{this.getResponsiveProp('shipping_title')}</span>
					</h3>
					{this.state.isToggled &&
					<div className="shipping_address">
						<div className="woocommerce-billing-fields__field-wrapper">
							<p className="form-row form-row-first">
								<label>{this.getResponsiveProp('first_name_label')} <abbr className="required" title="required">*</abbr></label>
								<span className="woocommerce-input-wrapper">
									<input type="text" className="input-text" />
								</span>
							</p>
							<p className="form-row form-row-last">
								<label>{this.getResponsiveProp('last_name_label')} <abbr className="required" title="required">*</abbr></label>
								<span className="woocommerce-input-wrapper">
									<input type="text" className="input-text" />
								</span>
							</p>
							<p className="form-row form-row-wide">
								<label>{this.getResponsiveProp('company_label')} (optional)</label>
								<span className="woocommerce-input-wrapper">
									<input type="text" className="input-text" />
								</span>
							</p>
							<p className="form-row form-row-wide">
								<label>{this.getResponsiveProp('country_label')} <abbr className="required" title="required">*</abbr></label>
								<span className="woocommerce-input-wrapper">
									<select className="country_to_state country_select">
										{
											Object.keys( this.getCountries() ).map( ( value ) =>
												<option key={value} value={value}>{parse( this.getCountries()[value] )}</option>
											)
										}
									</select>
								</span>
							</p>
							<p className="form-row form-row-wide">
								<label>{this.getResponsiveProp('address_1_label')} <abbr className="required" title="required">*</abbr></label>
								<span className="woocommerce-input-wrapper">
									<input type="text" className="input-text" placeholder="House number and street name"/>
								</span>
							</p>
							<p className="form-row form-row-wide">
								<label className="screen-reader-text"></label>
								<span className="woocommerce-input-wrapper">
									<input type="text" className="input-text" placeholder="Apartment, suite, unit, etc. (optional)"/>
								</span>
							</p>
							<p className="form-row form-row-wide">
								<label>{this.getResponsiveProp('city_label')} <abbr className="required" title="required">*</abbr></label>
								<span className="woocommerce-input-wrapper">
									<input type="text" className="input-text"/>
								</span>
							</p>
							<p className="form-row form-row-wide">
								<label>{this.getResponsiveProp('state_label')} (optional)</label>
								<span className="woocommerce-input-wrapper">
									<input type="text" className="input-text"/>
								</span>
							</p>
							<p className="form-row form-row-wide">
								<label>{this.getResponsiveProp('postcode_label')} <abbr className="required" title="required">*</abbr></label>
								<span className="woocommerce-input-wrapper">
									<input type="text" className="input-text"/>
								</span>
							</p>
							{this.props['show_order_notes'] !== 'off' &&
							<p className="form-row form-row-wide">
								<label>{this.getResponsiveProp('order_comments_label')} (optional)</label>
								<span className="woocommerce-input-wrapper">
									<textarea className="input-text" placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
								</span>
							</p>
							}
						</div>
					</div>
					}
				</div>
			</form>
    	);
  	}

	isToggled(){
		return this.state.isToggled;
	}

	getCountries(){
		return window.DiviWoocommercePagesBuilderData.billing_info.countries;
	}

	componentDidMount(){
		this.setUpSelect2Field();
	}

	componentDidUpdate(){
		this.setUpSelect2Field();
	}

	setUpSelect2Field(){
		// for some reason checkout script doesnt work
		// therefore we trigger it manually
		const node = ReactDom.findDOMNode(this);
		const countryField = $(node).find('.country_select');
		if( !countryField.hasClass('select2-hidden-accessible') ){
			countryField.selectWoo();
		}
	}
}

export default DSWCP_WooCheckoutShippingInfo;
