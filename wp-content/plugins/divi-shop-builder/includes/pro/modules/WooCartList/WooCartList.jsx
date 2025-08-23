/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/

// External Dependencies
import React, { Component, Fragment } from 'react';
import parse from 'html-react-parser';
import NumberFormat from 'react-number-format';
import Mixins from './../../../mixins';
import ReactDom from 'react-dom';
import $ from 'jquery';

// Internal Dependencies
import './style.scss';

import DSWCP_Modules from '../../../loader';

class DSWCP_WooCartList extends Component {

	static slug = 'ags_woo_cart_list';

	static css(props) {

		const additionalCss = [];

		if( props.remove_button_size && props.remove_button_size !== '1em' ){
			additionalCss.push([{
				selector:    '%%order_class%% .product-remove .remove',
				declaration: `width: ${props.remove_button_size} !important; height: ${props.remove_button_size} !important;`
			}]);

			additionalCss.push([{
				selector:    '%%order_class%% .product-remove .remove:after',
				declaration: `font-size: ${props.remove_button_size} !important;`
			}]);
		}

		if( props.remove_button_color !== 'red' ){
			additionalCss.push([{
				selector:    '%%order_class%% .product-remove .remove',
				declaration: `color: ${props.remove_button_color} !important;`
			}]);

			additionalCss.push([{
				selector:    '%%order_class%% .product-remove .remove:hover',
				declaration: `color: ${props.remove_button_color} !important;`
			}]);
		}

		const corners = { top: 0, right: 1, bottom: 2, left: 3 };

		if( props.table_heading_padding !== '.857em|.587em|.857em|.587em|on|on' ){
			const values = props.table_heading_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% table.shop_table.cart th',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.table_body_padding !== '.857em|.587em|.857em|.587em|on|on' ){
			const values = props.table_body_padding.split('|');
			Object.keys(corners).forEach(( corner ) => {
				additionalCss.push([{
					selector:    '%%order_class%% table.shop_table.cart td',
					declaration: `padding-${corner}: ${values[corners[corner]]} !important;`
				}]);
			});
		}

		if( props.thumbnail_size !== '32px' ){
			additionalCss.push([{
				selector:    '%%order_class%% .product-thumbnail img',
				declaration: `width: ${props.thumbnail_size} !important;`
			}]);
		}

		return additionalCss;
	}

	constructor(props) {
		super(props);
		this.state = {
			defaultColumns: window.DiviWoocommercePagesBuilderData.cart_list.columns,
			thumbnailSrc: window.DiviWoocommercePagesBuilderData.cart_list.thumbnail_src,
			isEmptyCart: false
		};

		this.classnames 	 	  = DSWCP_Modules.builderApi.Utils.classnames;
		this.processFontIcon 	  = DSWCP_Modules.builderApi.Utils.processFontIcon;
		this.componentWillUnmount = Mixins.componentWillUnmount.bind(this);
  	}

	render() {

		const emptyCartStyle = {};
		if( this.props.empty_cart_text_bg_color ){
			emptyCartStyle['backgroundColor'] = this.props.empty_cart_text_bg_color;
		}

    	// woocommerce/templates/cart/cart.php
    	return (
			<div>
				{ this.state.isEmptyCart &&
				<Fragment>
					<p className="cart-empty woocommerce-info" style={emptyCartStyle}>{this.props.empty_cart_text}</p>
					<p className="return-to-shop">
						<a className="button wc-backward" href="#" data-icon={this.processFontIcon(this.props.button_empty_cart_icon)}>{this.props.empty_cart_button_text}</a>
					</p>
				</Fragment>
				}
				{ !this.state.isEmptyCart &&
				<Fragment>
					<form className="woocommerce-cart-form" action="" method="post">
						<table className="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellSpacing="0">
							<thead>
								<tr>
									{
										/* dynamically loop through columns and check column visibility */
										Object.keys( this.state.defaultColumns ).map( ( column ) =>
											this.isColumnVisible( column ) &&
											<th className={'product-' + column} key={column}>{this.columnLabel(column)}</th>
										)
									}
								</tr>
							</thead>
							<tbody>
								<tr className="woocommerce-cart-form__cart-item cart_item">

									{ this.isColumnVisible( 'remove' ) &&
									<td className="product-remove" data-title={this.columnLabel('remove')}>
										{ ( this.props.remove_button_use_image === 'on' && this.props.remove_button_image ) &&
											<a href="#" className="remove" aria-label={this.localizedText('remove_label')}>
												<img src={this.props.remove_button_image} alt={this.localizedText('remove_label')} />
											</a>
										}
										{  ( this.props.remove_button_use_image !== 'on' || !this.props.remove_button_image ) &&
											<a href="#" className="remove"
												aria-label={this.localizedText('remove_label')} data-icon={this.processFontIcon(this.props.remove_button_icon ? this.props.remove_button_icon : 'M')}>
											</a>
										}
									</td>
									}

									{ this.isColumnVisible( 'thumbnail' ) &&
									<td className="product-thumbnail">
										<a href="#">
											<img width="300" height="300" className="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" src={this.state.thumbnailSrc}/>
										</a>
									</td>
									}

									{ this.isColumnVisible( 'name' ) &&
									<td className="product-name" data-title={this.columnLabel('name')}>
										<a href="#">{this.localizedText('cart_item_name')}</a>
									</td>
									}

									{ this.isColumnVisible( 'price' ) &&
									<td className="product-price" data-title={this.columnLabel('price')}>
										{this.wcPrice()}
									</td>
									}

									{ this.isColumnVisible( 'quantity' ) &&
									<td className="product-quantity" data-title={this.columnLabel('quantity')}>
										<div className="quantity">
											<label className="screen-reader-text" htmlFor="quantity_5f60ee1046206">{this.localizedText('cart_item_qty')}</label>
											<input type="number" id="quantity_5f60ee1046206" className="input-text qty text" step="1" min="0" max="" defaultValue="1" size="4" placeholder="" inputMode="numeric" />
										</div>
									</td>
									}

									{ this.isColumnVisible( 'subtotal' ) &&
									<td className="product-subtotal" data-title={this.columnLabel('subtotal')}>
										{this.wcPrice()}
									</td>
									}

								</tr>

								<tr>
									<td colSpan={Object.keys( this.state.defaultColumns ).filter( column => this.isColumnVisible(column) ).length}
										className="actions">
										{ this.getResponsiveProp( 'coupon_code_state', 'on' ) === 'on' &&
											<div className="coupon">
												<label htmlFor="coupon_code">{this.localizedText('coupon_text')}</label>
												<input type="text" name="coupon_code" className="input-text" id="coupon_code" placeholder={this.getResponsiveProp('coupon_code_input_text')} />
												<button type="submit" className="button" name="apply_coupon" value={this.localizedText('apply_coupon')} data-icon={this.processFontIcon(this.props.button_apply_coupon_icon)}>
													{this.getResponsiveProp('coupon_code_button_text')}
												</button>
											</div>
										}

										<button type="submit" className="button" name="update_cart" defaultValue={this.localizedText('update_cart')} data-icon={this.processFontIcon(this.props.button_update_cart_icon)}>
											{this.getResponsiveProp('update_cart_button_text')}
										</button>
									</td>
								</tr>

							</tbody>
						</table>
					</form>
				</Fragment>
				}
			</div>
    	);
  	}

	isColumnVisible( colName ){
		return this.getResponsiveProp( `col_${colName}_state`, "on" ) === "on";
	}

	columnLabel( colName ){
		return this.getResponsiveProp( `col_${colName}_text`, this.state.defaultColumns[colName] );
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

	componentDidMount(){
		const topDocument = window.ET_Builder.Frames.top.document;
		$(topDocument).on('click', '.et-fb-form__toggle', this.onToggleActive.bind(this));
	}

	onToggleActive(e){

		const node	 = $(ReactDom.findDOMNode(this));
		const parent = node.parents( '.' + DSWCP_WooCartList.slug );

		if( !parent.hasClass('et_fb_editing_enabled') ){
			return;
		}

		setTimeout( () => {
			this.setState({
				isEmptyCart: $(e.currentTarget).hasClass('et-fb-form__toggle-opened') &&
				['empty', 'empty_cart_button', 'empty_cart_text', 'empty_cart_button_url'].includes( $(e.currentTarget).data('name') )
			});
		});
	}
}

export default DSWCP_WooCartList;
