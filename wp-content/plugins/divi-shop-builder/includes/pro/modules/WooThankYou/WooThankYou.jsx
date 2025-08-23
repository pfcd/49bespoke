/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JSX file) has been modified by Ahamed Arshad Azmi, Jonathan Hall and/or others.
This file (or the corresponding source JSX file) was last modified 2021-02-03
*/

// External Dependencies
import React, { Component, Fragment } from 'react';
import ReactDom from 'react-dom';
import NumberFormat from 'react-number-format';
import parse from 'html-react-parser';
import $ from 'jquery';

// Internal Dependencies
import './style.scss';

class DSWCP_WooThankYou extends Component {

	static slug = 'ags_woo_thank_you';

	static css(props) {

		const additionalCss = [];

		const corners = { top: 0, right: 1, bottom: 2, left: 3 };

		if( props.thank_you_msg_margin ){
			const values = props.thank_you_msg_margin.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-notice.woocommerce-thankyou-order-received',
					declaration: `margin-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.order_details_labels_padding ){
			const values = props.order_details_labels_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% ul.woocommerce-order-overview li[class^="woocommerce-order-overview__"]',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.order_details_labels_margin ){
			const values = props.order_details_labels_margin.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% ul.woocommerce-order-overview li[class^="woocommerce-order-overview__"]',
					declaration: `margin-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.order_details_labels_bg_color ){
			additionalCss.push([{
				selector:    '%%order_class%% ul.woocommerce-order-overview li[class^="woocommerce-order-overview__"]',
				declaration: `background-color: ${props.order_details_labels_bg_color} !important;`
			}]);
		}

		// downloads start
		if( props.downloads_table_margin ){
			const values = props.downloads_table_margin.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-order-downloads table.woocommerce-table--order-downloads',
					declaration: `margin-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.downloads_th_padding ){
			const values = props.downloads_th_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-order-downloads .woocommerce-table--order-downloads thead th',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.downloads_td_padding ){
			const values = props.downloads_td_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-table--order-downloads tbody td',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}
		// downloads end

		if( props.order_details_table_margin ){
			const values = props.order_details_table_margin.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-order-details table.woocommerce-table--order-details',
					declaration: `margin-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.order_details_th_padding ){
			const values = props.order_details_th_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-order-details .woocommerce-table--order-details thead th, %%order_class%% .woocommerce-order-details .woocommerce-table--order-details tfoot th',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.order_details_td_padding ){
			const values = props.order_details_td_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-order-details .woocommerce-table--order-details tbody td',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.billing_details_padding ){
			const values = props.billing_details_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-customer-details .woocommerce-column--billing-address address',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}
		
		if( props.billing_details_margin ){
			const values = props.billing_details_margin.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-customer-details .woocommerce-column--billing-address address',
					declaration: `margin-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.shipping_details_padding ){
			const values = props.shipping_details_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-customer-details .woocommerce-column--shipping-address address',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}
		
		if( props.shipping_details_margin ){
			const values = props.shipping_details_margin.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% .woocommerce-customer-details .woocommerce-column--shipping-address address',
					declaration: `margin-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.billing_details_bg_color ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-customer-details .woocommerce-column--billing-address address',
				declaration: `background-color: ${props.billing_details_bg_color} !important;`
			}]);
		}

		if( props.shipping_details_bg_color ){
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-customer-details .woocommerce-column--shipping-address address',
				declaration: `background-color: ${props.shipping_details_bg_color} !important;`
			}]);
		}

		// if( !props.border_style_all_order_details_table ){
		// 	additionalCss.push([{
		// 		selector:    '%%order_class%% .woocommerce-order-details table.woocommerce-table--order-details',
		// 		declaration: `border-style: solid !important;`
		// 	}]);
		// }


		if( props.title_margin ){
			const values = props.title_margin.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% h2, %%order_class%% h1, %%order_class%% h3,%%order_class%% h4, %%order_class%% h5, %%order_class%% h6',
					declaration: `margin-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}
		if( props.thankyou_order_details_padding ){
			const values = props.thankyou_order_details_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% ul.woocommerce-thankyou-order-details',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		return additionalCss;
	}

	constructor(props){
		super(props);
		this.state = {
			isEmptyOrder: false
		};
	}

	render() {
		return (
			<div className="woocommerce">
				<div className="woocommerce-order">
					{
						this.state.isEmptyOrder &&
						<p className="woocommerce-thankyou-order-not-found">{this.props.order_not_found_text}</p>
					}
					{
						!this.state.isEmptyOrder &&
						<Fragment>
							<p className="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
							{this.props.order_received_msg}
							</p>
							<ul className="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
								<li className="woocommerce-order-overview__order order">
									{this.props.order_number_text}
									<strong>123</strong>
								</li>
								<li className="woocommerce-order-overview__date date">
									{this.props.order_date_text}
									<strong>{this.orderDate()}</strong>
								</li>
								<li className="woocommerce-order-overview__email email">
									{this.props.order_email_text}
									<strong>{this.orderEmail()}</strong>
								</li>
								<li className="woocommerce-order-overview__total total">
									{this.props.order_total_text}
									<strong>{this.wcPrice()}</strong>
								</li>
								<li className="woocommerce-order-overview__payment-method method">
									{this.props.payment_method_text}
									<strong>Cash on delivery</strong>
								</li>
							</ul>
							<section className="woocommerce-order-downloads">
								<h2 className="woocommerce-order-downloads__title">Downloads</h2>

								<table
									className="woocommerce-table woocommerce-table--order-downloads shop_table shop_table_responsive order_details">
									<thead>
									<tr>
										<th className="download-product"><span className="nobr">Product</span></th>
										<th className="download-remaining"><span
											className="nobr">Downloads remaining</span></th>
										<th className="download-expires"><span className="nobr">Expires</span></th>
										<th className="download-file"><span className="nobr">Download</span></th>
									</tr>
									</thead>

									<tbody>
									<tr>
										<td className="download-product" data-title="Product">
											<a href="#">My Awesome Product</a>
										</td>
										<td className="download-remaining" data-title="Downloads remaining">
											∞
										</td>
										<td className="download-expires" data-title="Expires">
											Never
										</td>
										<td className="download-file" data-title="Download">
											<a href="#"
											   className="woocommerce-MyAccount-downloads-file button alt">Download</a>
										</td>
									</tr>
									</tbody>
								</table>
							</section>
							<section className="woocommerce-order-details">
								<h2 className="woocommerce-order-details__title">{this.props.order_details_text}</h2>
								<table className="woocommerce-table woocommerce-table--order-details shop_table order_details">
									<thead>
										<tr>
											<th className="woocommerce-table__product-name product-name">{this.localizedText('product')}</th>
											<th className="woocommerce-table__product-table product-total">{this.localizedText('total')}</th>
										</tr>
									</thead>
									<tbody>
										<tr className="woocommerce-table__line-item order_item">
											<td className="woocommerce-table__product-name product-name">
												<a>{this.localizedText('item_name')}</a>
												<strong className="product-quantity"> x 1</strong>
											</td>
											<td className="woocommerce-table__product-total product-total">
												{this.wcPrice()}
											</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<th scope="row">{this.localizedText('item_name') + ':'}</th>
											<td>{this.wcPrice()}</td>
										</tr>
										<tr>
											<th scope="row">{this.localizedText('shipping') + ':'}</th>
											<td>{this.wcPrice()}</td>
										</tr>
										<tr>
											<th scope="row">{this.localizedText('payment_method')}</th>
											<td>{this.wcPrice()}</td>
										</tr>
										<tr>
											<th scope="row">{this.localizedText('total')}</th>
											<td>{this.wcPrice()}</td>
										</tr>
									</tfoot>
								</table>
							</section>
							<section className="woocommerce-customer-details">
								<section className="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
									<div className="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">
										<h2 className="woocommerce-column__title">{this.props.billing_address_text}</h2>
										<address>
											John Doe<br/>
											123, New York Street<br/>
											10010<br/>
											USA
											<p className="woocommerce-customer-details--phone">+1234567890</p>
											<p className="woocommerce-customer-details--email">johndoe@gmail.com</p>
										</address>
									</div>
									<div className="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
										<h2 className="woocommerce-column__title">{this.props.shipping_address_text}</h2>
										<address>
											John Doe<br/>
											123, New York Street<br/>
											10010<br/>
											USA
										</address>
									</div>
								</section>
							</section>
						</Fragment>
					}
				</div>
			</div>
		);
  	}

	localizedText( key ){
		const translations = window.DiviWoocommercePagesBuilderData.thank_you.locals;
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

	orderDate(){
		return window.DiviWoocommercePagesBuilderData.thank_you.date;
	}

	orderEmail(){
		return window.DiviWoocommercePagesBuilderData.thank_you.email;
	}

	componentDidMount(){
		const topDocument = window.ET_Builder.Frames.top.document;
		$(topDocument).on('click', '.et-fb-form__toggle', this.onToggleActive.bind(this));
	}

	componentWillUnmount(){
		const topDocument = window.ET_Builder.Frames.top.document;
		$(topDocument).off('click', '.et-fb-form__toggle', this.onToggleActive.bind(this));
	}

	onToggleActive(e){

		const node	 = $(ReactDom.findDOMNode(this));
		const parent = node.parents( '.' + DSWCP_WooThankYou.slug );

		if( !parent.hasClass('et_fb_editing_enabled') ){
			return;
		}

		setTimeout( () => {
			this.setState({
				isEmptyOrder: $(e.currentTarget).hasClass('et-fb-form__toggle-opened') && ['not_found_text', 'not_found' ].includes( $(e.currentTarget).data('name') )
			});
		});
	}
}

export default DSWCP_WooThankYou;
