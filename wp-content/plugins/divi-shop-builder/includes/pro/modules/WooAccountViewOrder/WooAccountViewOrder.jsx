// External Dependencies
import React, { Component } from 'react';
import parse from 'html-react-parser';
import NumberFormat from 'react-number-format';

import DSWCP_Modules from '../../../loader';
import './style.scss';

class DSWCP_WooAccountViewOrder extends Component {

	static slug = 'ags_woo_account_view_order';

	static css(props) {

		const additionalCss = [];

		if( props.button_view_use_icon === 'on' && props.button_view_icon ){
			const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.button_view_icon);
			additionalCss.push([{
				selector:    '%%order_class%% .woocommerce-MyAccount-content table.woocommerce-orders-table .woocommerce-orders-table__cell-order-actions .button::after',
				declaration: `content:  '${icon}' !important;`
			}]);
		}

		return additionalCss;
	}

	render() {
		return (
			<div className="woocommerce-MyAccount-content">
				<div className="view-order-wrapper">
					<p dangerouslySetInnerHTML={{__html:this.orderPlacedHTML()}}></p>
					<section className="woocommerce-order-downloads">
						<h2 className="woocommerce-order-downloads__title">Downloads</h2>

						<table
							className="woocommerce-table woocommerce-table--order-downloads shop_table shop_table_responsive order_details">
							<thead>
							<tr>
								<th className="download-product"><span className="nobr">Product</span></th>
								<th className="download-remaining"><span className="nobr">Downloads remaining</span>
								</th>
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
									<a href="#" className="woocommerce-MyAccount-downloads-file button alt">Download</a>
								</td>
							</tr>
							</tbody>
						</table>
					</section>
					<section className="woocommerce-order-details">
						<h2 className="woocommerce-order-details__title">{this.localizedText('order_details')}</h2>
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
										<a href="#">{this.localizedText('product_name')}</a> <strong className="product-quantity">× 1</strong>
									</td>
									<td className="woocommerce-table__product-total product-total">
										<span className="woocommerce-Price-amount amount">{this.wcPrice()}</span>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th scope="row">{`${this.localizedText('subtotal')}:`}</th>
									<td><span className="woocommerce-Price-amount amount">{this.wcPrice()}</span></td>
								</tr>
								<tr>
									<th scope="row">{`${this.localizedText('shipping')}:`}</th>
									<td><span className="woocommerce-Price-amount amount">{this.wcPrice()}</span></td>
								</tr>
								<tr>
									<th scope="row">{`${this.localizedText('payment_method')}:`}</th>
									<td>Cash on delivery</td>
								</tr>
								<tr>
									<th scope="row">{this.localizedText('total')}</th>
									<td><span className="woocommerce-Price-amount amount">{this.wcPrice()}</span></td>
								</tr>
							</tfoot>
						</table>
						<p className="order-again">
							<a href="#"
							   className="button">Order again</a>
						</p>
					</section>

					<section className="woocommerce-customer-details">
						<section className="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
							<div className="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">
								<h2 className="woocommerce-column__title">{this.localizedText('billing')}</h2>
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
								<h2 className="woocommerce-column__title">{this.localizedText('shipping')}</h2>
								<address>
									John Doe<br/>
									123, New York Street<br/>
									10010<br/>
									USA
								</address>
							</div>
						</section>
					</section>
				</div>
			</div>
		);
  	}

	orderPlacedHTML() {
		return window.DiviWoocommercePagesBuilderData.account_contents.i18n.order_placed;
	}

	localizedText(type){
		return window.DiviWoocommercePagesBuilderData.account_contents.i18n[type];
	}

	wcPrice( price = '0.00' ) {
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
}

export default DSWCP_WooAccountViewOrder;
