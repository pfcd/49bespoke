import React, { Component } from 'react';
class DSWCP_WooMiniCart_DropdownCart extends Component {
	render() {
		var removeIconData = window.ET_Builder.API.Utils.processIconFontData(this.props.remove_icon);
		if (this.props.action_click === 'dropdowncart') {
			var closeIconData = window.ET_Builder.API.Utils.processIconFontData(this.props.close_icon);
		}
		
		if (this.props._preview === 'dropdowncart_empty') {
			var cartEmptyIconData = window.ET_Builder.API.Utils.processIconFontData(this.props.empty_icon);
		} else {
			var product = <div className="dswcp-dropdown-cart-item">
								<div>
									<button className={'dswcp-remove et-pb-icon' + (removeIconData && removeIconData.iconFontFamily === 'FontAwesome' ? ' et-pb-fa-icon' : '')} title={this.props.remove_title}>
										{window.ET_Builder.API.Utils.processFontIcon(this.props.remove_icon)}
									</button>
								</div>
				{this.props.show_images === 'on' && <div className="dswcp-image-container"> <img src={window.DiviWoocommercePagesBuilderData.mini_cart.placeholderImage} /></div>}
								<div>
									<h3 className="dswcp-product-name">
										<a href="#">My Awesome Product</a>
										{this.props.show_product_quantity === 'after_title' &&  <span className="dswcp-quantity"> &times; 1</span> }
									</h3>
									<div className="dswcp-product-price">
											<span dangerouslySetInnerHTML={{__html: window.DiviWoocommercePagesBuilderData.mini_cart.placeholderAmount}}></span>
											{this.props.show_product_quantity === 'after_price' && <span className="dswcp-quantity"> &times; 1</span> }
									</div>
									{this.props.show_product_subtotal === 'on' &&
										<div className="dswcp-item-subtotal">
											<span>{this.props.product_subtotal_text}</span>
											<span dangerouslySetInnerHTML={{__html: window.DiviWoocommercePagesBuilderData.mini_cart.placeholderAmount}}></span>
										</div>
									}
								</div>
							</div>;
		}
		return <div className="dswcp-dropdown-cart-container">
			<div className="dswcp-dropdown-cart">
			<div className="dswcp-dropdown-cart-header">
				{this.props.display_cart_title === 'on' && <h2>{this.props.cart_title}</h2> }
				{this.props.action_click === 'dropdowncart' && <button className={'dswcp-close et-pb-icon' + (closeIconData && closeIconData.iconFontFamily === 'FontAwesome' ? ' et-pb-fa-icon' : '')} title={this.props.close_title}>
					{window.ET_Builder.API.Utils.processFontIcon(this.props.close_icon)}
				</button>}
			</div>
			{ this.props._preview === 'dropdowncart_empty'
				? <div className="dswcp-dropdown-cart-empty dswcp-cart-empty">
					{this.props.show_empty_icon === 'on' ?
						<div className={'dswcp-cart-empty-icon et-pb-icon' + (cartEmptyIconData && cartEmptyIconData.iconFontFamily === 'FontAwesome' ? ' et-pb-fa-icon' : '')}>{window.ET_Builder.API.Utils.processFontIcon(this.props.empty_icon)}</div> :
						<span className={'dswcp-cart-empty-icon dswcp-cart-icon icon-cart_icon_' + parseInt(this.props.empty_custom_icon)}></span>
					}
					<p>{this.props.empty_text}</p>
				</div>
				: <div className="dswcp-dropdown-cart-items">
					{product}
					{product}
				</div>
			}
			<div className="dswcp-dropdown-cart-footer">
				<div className="dswcp-subtotal">
					<label className="dswcp-subtotal-text">{this.props.subtotal_text}</label>
					<span className="dswcp-subtotal-value"  dangerouslySetInnerHTML={{__html: window.DiviWoocommercePagesBuilderData.mini_cart.placeholderTotal}}></span>
				</div>
				{this.props.footer_info_text && <p className="dswcp-info">{this.props.footer_info_text}</p>}
				<div className="dswcp-buttons">
					{ this.props._preview === 'dropdowncart_empty'
						? <a href="#" className="dswcp-btn-shop et_pb_button">{this.props.shop_btn_text}</a>
						: <>
							<a href="#" className="dswcp-btn-cart et_pb_button">{this.props.cart_btn_text}</a>
							<a href="#" className="dswcp-btn-checkout et_pb_button">{this.props.checkout_btn_text}</a>
						</>
					}
				</div>
			</div>
		</div>
		</div>;
	}
}

export default DSWCP_WooMiniCart_DropdownCart;