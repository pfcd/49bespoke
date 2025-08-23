/*! @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
Contents of this file (or the corresponding source JSX file) have been modified by Essa Mamdani, Jonathan Hall, Anna Kurowska and/or others.
*/

// External Dependencies
import React from 'react';
import Swiper from 'react-id-swiper';
import AjaxComponent from "./components/ajax";

//
function apply_responsive(props, key, selector, css_prop_key = 'padding') {
    let additionalCss = [];
    if (!props[key]) {
		
		console.log('no prop ' + key);
		
        return;
    }
    // console.log(props[key]);
    const desktop = !["padding", "margin"].includes(css_prop_key) ? props[key] : props[key].split("|");
    const isLastEdit = props["".concat(key + "_last_edited")];
    const statusActive = isLastEdit && isLastEdit.startsWith("on");

    additionalCss.push([{
        selector,//: '%%order_class%%  .prev_icon,%%order_class%%  .next_icon',
        declaration: !["padding", "margin"].includes(css_prop_key) ? `${css_prop_key}: ${desktop};` : `${css_prop_key}-top: ${desktop[0]}; ${css_prop_key}-right: ${desktop[1]}; ${css_prop_key}-bottom: ${desktop[2]}; ${css_prop_key}-left: ${desktop[3]};`,
    }]);


    if (props["".concat(key + "_tablet")] && statusActive) {
        const tablet = !["padding", "margin"].includes(css_prop_key) ? props[key] : props["".concat(key + "_tablet")].split("|");
        additionalCss.push([{
            selector,//: '%%order_class%%  .prev_icon,%%order_class%%  .next_icon ',
            declaration: !["padding", "margin"].includes(css_prop_key) ? `${css_prop_key}: ${tablet};` : `${css_prop_key}-top: ${tablet[0]}; ${css_prop_key}-right: ${tablet[1]}; ${css_prop_key}-bottom: ${tablet[2]}; ${css_prop_key}-left: ${tablet[3]};`,
            'device': 'tablet',
        }]);
    }
    if (props["".concat(key + "_phone")] && statusActive) {
        const phone = !["padding", "margin"].includes(css_prop_key) ? props[key] : props["".concat(key + "_phone")].split("|");
        additionalCss.push([{
            selector,//: '%%order_class%%  .prev_icon,%%order_class%%  .next_icon ',
            declaration: !["padding", "margin"].includes(css_prop_key) ? `${css_prop_key}: ${phone};` : `${css_prop_key}-top: ${phone[0]}; ${css_prop_key}-right: ${phone[1]}; ${css_prop_key}-bottom: ${phone[2]}; ${css_prop_key}-left: ${phone[3]};`,
            'device': 'phone',
        }]);
    }
	
    return additionalCss;
};

class WoocommerceCarousel extends AjaxComponent {

    static slug = 'dswc_woocommerce_carousel';
	
	ajaxProps = ['product_view_type', 'product_count', 'products_category', 'products_tag', 'sort_by', 'sort_dir', 'out_of_stock'];
		
	swiperProps = ['column_layout', 'column_layout_tablet', 'column_layout_phone',
					'slide_by', 'slide_by_tablet', 'slide_by_phone',
					'slide_center',
					'space_between', 'space_between_tablet', 'space_between_phone', 'equal_height', 'loop', 'autoplay',
					'auto_speed', 'pause_slider', 'show_arrow', 'show_controls',
					'width', 'max_width', 'min_height', 'height', 'max_height'
					];
							
	static marginPaddingElements = {
		title: '%%order_class%% .swiper-slide.dswc_item_wrapper .dswc_title',
		image: '%%order_class%% .swiper-slide.dswc_item_wrapper .dswc-featured-image',
		rating: '%%order_class%% .swiper-slide.dswc_item_wrapper .star_rating_module_wrapper',
		price: '%%order_class%% .swiper-slide.dswc_item_wrapper .dswc_price',
		sale_badge: '%%order_class%% .swiper-slide.dswc_item_wrapper .sale_badge span',
		arrow: '%%order_class%% .prev_icon, %%order_class%% .next_icon',
		pagination: '%%order_class%% .swiper-pagination',
        view_cart: '%%order_class%% .dswc_buttons_wrapper .added_to_cart'
	};

    static css(props) {
        //const utils         = window.ET_Builder.API.Utils;
        const additionalCss = [];
        if (!props.border_style_all) {
            additionalCss.push([{
                selector: '%%order_class%% .swiper-slide.dswc_item_wrapper',
                declaration: 'border-style: solid;',
            }]);
        }

        //Pagination Active 
        additionalCss.push([{
            selector: '%%order_class%% .swiper-pagination .swiper-pagination-bullet-active',
            declaration: `background-color: ${props.pagination_bg_color};`,
        }]);


        // Pagination
        if (props.pagination_position === 'relative') {
            additionalCss.push([{
                selector: '%%order_class%% .swiper-pagination',
                declaration: `position: ${props.pagination_position};`,
            }]);
        }
        // Pagination
        if (props.buttons_position !== 'default') {
            additionalCss.push([{
                selector: '%%order_class%% .dswc_et_pb_button_module_wrapper',
                declaration: `display: flex; align-items: center; justify-content: ${props.buttons_position};`,
            }]);
        }

        if (props.slide_elements_position !== 'default') {
            additionalCss.push([{
                selector: '%%order_class%% .dswc_item_wrapper',
                declaration: `display: flex; flex-direction: column; justify-content:  ${props.slide_elements_position};`,
            }]);
        }


        // arrow css style
        additionalCss.push([{
            selector: '%%order_class%%  .prev_icon,%%order_class%%  .next_icon',
            declaration: `font-family: ETmodules;
                        content: attr(data-icon);
                        speak: none;
                        font-weight: 400;
                        -webkit-font-feature-settings: normal;
                        font-feature-settings: normal;
                        font-variant: normal;
                        text-transform: none;
                        line-height: 1;
                        -webkit-font-smoothing: antialiased;
                        font-style: normal;
                        display: inline-block;
                        -webkit-box-sizing: border-box;
                        box-sizing: border-box;
                        position: absolute;
                        z-index: 99999;
                        cursor: pointer;
                        font-size: ${props.icon_size};
                        color: ${props.arrow_icon_color};
                        background-color: ${props.arrow_icon_bg_color};`,
        }]);
        additionalCss.push([{
            selector: '%%order_class%% .next_icon.swiper-button-disabled,%%order_class%% .prev_icon.swiper-button-disabled',
            declaration: `display:none;`,
        }]);
		
        additionalCss.push([{
            selector: '%%order_class%% .dswc_arrows_outside  .next_icon',
            declaration: `right: -25px;`,
        }]);
        additionalCss.push([{
            selector: '%%order_class%% .dswc_arrows_outside  .prev_icon',
            declaration: `left: -25px;`,
        }]);
		
		
        additionalCss.push([{
            selector: '%%order_class%% .dswc_item_wrapper img',
            declaration: `border-style:solid;`,
        }]);


        // arrow position

        if ('center' === props.arrow_pos) {
            additionalCss.push([{
                selector: '%%order_class%%   .prev_icon',
                declaration: 'position: absolute;top: 45%;z-index: 999;left: 0px;cursor:pointer;',
            }]);

            additionalCss.push([{
                selector: '%%order_class%%  .next_icon',
                declaration: 'position: absolute;top: 45%;right: 0px;z-index: 9999;cursor:pointer;',
            }]);
        }

        if ('bottom' === props.arrow_pos) {
            additionalCss.push([{
                selector: '%%order_class%%   .prev_icon',
                declaration: 'position: absolute;bottom: 0%;z-index: 999;left: 0px;cursor:pointer;',
            }]);

            additionalCss.push([{
                selector: '%%order_class%%  .next_icon',
                declaration: 'position: absolute;bottom: 0%;right: 0px;z-index: 9999;cursor:pointer;',
            }]);
        }


        // overlay color apply css

        additionalCss.push([{
            selector: '%%order_class%% .swiper-slide.dswc_item_wrapper:hover .dswc-featured-image:before',
            declaration: `background-color: ${props.image_overlay_color};`,
        }]);


        // star rating
		
        const utils = window.ET_Builder.API.Utils;
        let starIcon = utils.processFontIcon(props.star_icon);
		starIcon = starIcon ? '\\' + starIcon.charCodeAt().toString(16) : '\\e033';
		
		let totalWidthEm = 5 + (props.rating_spacing * 4);
		
        additionalCss.push([
			{
				selector: '%%order_class%% .star_rating_module_wrapper',
				declaration: `font-size: ${props.rating_size}; text-align: ${props.rating_align};`
			},
			{
				selector: '%%order_class%% .star_rating_module_wrapper .star-rating::before, %%order_class%% .star_rating_module_wrapper .star-rating span::before',
				declaration: `
					content: "${starIcon}${starIcon}${starIcon}${starIcon}${starIcon}"!important;
					font-size: ${props.rating_size};
					letter-spacing: ${props.rating_spacing}em;
				`
			},
			{
				selector: '%%order_class%% .star_rating_module_wrapper .star-rating span::before',
				declaration: `color: ${props.rating_color_active};`
			},
			{
				selector: '%%order_class%% .star_rating_module_wrapper .star-rating::before',
				declaration: `color: ${props.rating_color}!important;`
			},
			{
				selector: '%%order_class%% .star_rating_module_wrapper .star-rating',
				declaration: `width: ${totalWidthEm}em;`
			}
		]);

        //sale badge

        additionalCss.push([{
            selector: '%%order_class%% .swiper-slide.dswc_item_wrapper .sale_badge span',
            declaration: `background-color: ${props.sale_badge_background};`,
        }]);

        let additionalCss_ = additionalCss;
		
		for ( let elementId in WoocommerceCarousel.marginPaddingElements ) {
			additionalCss_ = additionalCss_.concat(apply_responsive(props, elementId + '_padding', WoocommerceCarousel.marginPaddingElements[elementId]));
			additionalCss_ = additionalCss_.concat(apply_responsive(props, elementId + '_margin', WoocommerceCarousel.marginPaddingElements[elementId], 'margin'));
		}
        
        //additionalCss_ = additionalCss_.concat(apply_responsive(props, 'arrow_padding', '%%order_class%%  .prev_icon,%%order_class%%  .next_icon'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'icon_size', '%%order_class%%  .prev_icon,%%order_class%%  .next_icon', 'font-size'));

        return additionalCss_;
    }


    constructor(props) {
        super(...arguments);
        this.goNext = this.goNext.bind(this);
        this.goPrev = this.goPrev.bind(this);
        this.swiper = null;
        this.props = props;
    }

    componentDidUpdate(prevProps) {
        super.componentDidUpdate(prevProps);

    }

    goNext() {
        if (this.swiper) this.swiper.slideNext()
    }

    goPrev() {
        if (this.swiper) this.swiper.slidePrev()
    }

    _shouldReload(oldProps, newProps) {
		
		
		for ( var i = 0; i < this.ajaxProps.length; ++i ) {
			if ( !window.ET_Builder.API.Utils._.isEqual( oldProps[this.ajaxProps[i]], newProps[this.ajaxProps[i]] ) ) {
				return 'ajax';
			}
		}
								
		for ( var k = 0; k < this.swiperProps.length; ++k ) {
			if ( !window.ET_Builder.API.Utils._.isEqual( oldProps[this.swiperProps[k]], newProps[this.swiperProps[k]] ) ) {
				return 'rerender';
			}
		}
		
        return false;
    }


    _reloadData(props) {
		
		let requestData = {
            action: "dswc_woocommerce_products_list",
            nonce: window.dswc_woocommerce.nonce,
        };
		
		for ( var i = 0; i < this.ajaxProps.length; ++i ) {
			requestData[this.ajaxProps[i]] = props[this.ajaxProps[i]];
		}
		
        return requestData;
    }

    _renderButton() {
        const props = this.props;
        const utils = window.ET_Builder.API.Utils;
        const buttonIcon = props.add_cart_button_icon ? utils.processFontIcon(props.add_cart_button_icon) : '';
        const buttonClassName = {
            et_bt_add_to_cart: true,
            et_pb_button: true,
            et_pb_custom_button_icon: props.add_cart_button_icon,
        };

        let view_cart = (props.button_action === "cart" && props.button_ajax === 'on' )  ? <a href="/#" className="added_to_cart wc-forward"> {window.wc_add_to_cart_params.i18n_view_cart ? window.wc_add_to_cart_params.i18n_view_cart : 'View Cart' } </a> : '' ;


        return (
            <div key={'cart_' + props.moduleInfo.order + 10001} className='dswc_et_pb_button_module_wrapper'>
                <a className={utils.classnames(buttonClassName)}
                    href="/#"

                    rel={utils.linkRel(props.button_rel)}
                    data-icon={buttonIcon}>
                    {props.add_cart_button_text}
                </a>
                {view_cart}
            </div>
        );
    }

    render() {
        return super.render();
    }

    doRender(key, src) {
		
        let data = <></>;
        const props = this.props;
        if (key.props && key.props.attrs && key.props.attrs.item) {
			
			
            switch (key.props.attrs.item) {
                case 'not_found':
                    data = <p className='dswc_no_record' key={'not_found' + props.moduleInfo.order + 100123}>{src}</p>
                    break;
                case 'title':
				
					switch(props.title_tag) {
						case 'h1':
							data = <h1 className='dswc_title' key={'title_' + props.moduleInfo.order + 10001}>{src.name}</h1>;
							break;
						case 'h2':
							data = <h2 className='dswc_title' key={'title_' + props.moduleInfo.order + 10001}>{src.name}</h2>;
							break;
						case 'h3':
							data = <h3 className='dswc_title' key={'title_' + props.moduleInfo.order + 10001}>{src.name}</h3>;
							break;
						case 'h4':
							data = <h4 className='dswc_title' key={'title_' + props.moduleInfo.order + 10001}>{src.name}</h4>;
							break;
						case 'h5':
							data = <h5 className='dswc_title' key={'title_' + props.moduleInfo.order + 10001}>{src.name}</h5>;
							break;
						case 'h6':
							data = <h6 className='dswc_title' key={'title_' + props.moduleInfo.order + 10001}>{src.name}</h6>;
							break;
						case 'strong':
							data = <strong className='dswc_title' key={'title_' + props.moduleInfo.order + 10001}>{src.name}</strong>;
							break;
                        case 'p':
                        default:
                            data = <p className='dswc_title' key={'title_' + props.moduleInfo.order + 10001}>{src.name}</p>;
                            break;
					}
                    
                    break;
                case 'badge':
					if (props.sale_badge_pos === "no_overlay" || key.props.attrs._image_badge) {
                        data = src.sale ? <div key={'sale_badge_' + props.moduleInfo.order + 1000123} className={'sale_badge dswc_badge_' + props.sale_badge_pos}><span> {props.sale_badge_text} </span></div> : '';

                    }
                    break;
                case 'image':
					
					let badges = [];
					if (props.sale_badge_pos !== "no_overlay") {
						for ( let k in props.content ) {
							if (props.content[k].props && props.content[k].props.attrs && props.content[k].props.attrs.item === 'badge') {
								props.content[k].props.attrs._image_badge = true;
								badges.push( this.doRender(props.content[k], src) );
								props.content[k].props.attrs._image_badge = false;
							}
						}
					}
					
					
                    data =
                        <span key={'featured_image_' + props.moduleInfo.order + 10001} className="dswc-featured-image">
							{badges}
							<span dangerouslySetInnerHTML={{__html: src.image_html}}></span>
                        </span>;
                    break;
                case 'ratings':
                    data =
                        <div key={'ratings_' + props.moduleInfo.order + 10001} className="star_rating_module_wrapper" dangerouslySetInnerHTML={{__html:src.rating_html}}></div>;
                    break;
                case 'price':
                    data = <div key={'price_' + props.moduleInfo.order + 10001} className="dswc_price" dangerouslySetInnerHTML={{__html:src.price_html}}></div>;
                    break;
                case 'button':
                    data = <div key={'buttons_' + props.moduleInfo.order + 10001} className="dswc_buttons_wrapper">
                        {this._renderButton()}
                    </div>;
                    break;
                default:
                    data = <></>;
            }
        }
		
        return data;
    }


    _render() {
        let { props } = this;
        const utils = window.ET_Builder.API.Utils;
        const orderClass = `${props.moduleInfo.type}_${props.moduleInfo.order}`;
        let moduleClasses = /*orderClass + */' woocommerce';
		
		if ( props.arrows_outside === 'on' ) {
			moduleClasses += ' dswc_arrows_outside';
		}
		
        let params = {
            renderPrevButton: () => <span className="prev_icon"
                onClick={this.goPrev}>{utils.processFontIcon(props.prev_icon)}</span>,
            renderNextButton: () => <span className="next_icon"
                onClick={this.goNext}>{utils.processFontIcon(props.next_icon)}</span>,
            //slidesPerView: props.column_layout,
            //spaceBetween: parseInt(props.space_between),
            centeredSlides: props.slide_center === 'on',
            autoHeight: props.equal_height === 'on',
            breakpointsInverse: true,
            loop: props.loop === 'on',
            mousewheel: props.mousewheel === 'on',
            grabCursor: true,
            rtl: props.is_rtl > 0,
            breakpoints: {
                980: {
                    slidesPerView: props.column_layout,
                    spaceBetween: props.space_between,
					slidesPerGroup: props.slide_by,
                },
                768: {
                    slidesPerView: props.column_layout_tablet || props.column_layout,
                    spaceBetween: props.space_between_tablet || props.space_between,
					slidesPerGroup: props.slide_by_tablet || props.slide_by,
                },
                0: {
                    slidesPerView: props.column_layout_phone || props.column_layout,
                    spaceBetween: props.space_between_phone || props.space_between,
					slidesPerGroup: props.slide_by_phone || props.slide_by,
                },
            }
        };
        if (props.show_arrow === "on") {
            params.navigation = {
                nextEl: '.next_icon',
                prevEl: '.prev_icon'
            };
        }

        if (props.show_controls === "on") {
            params.pagination = {
                el: '.swiper-pagination',
                clickable: true
            };
        }
        if (props.autoplay === "on") {
            params.autoplay = {
                delay: props.auto_speed || 5000,
                // disableOnInteraction: props.stop_slider_touch === 'on',
            };
        }

        let dswc_woocommerce_carousel_item = props.content ? Object.values({ ...props.content }) : [];

        let output = (<div key={orderClass}>
            {this.state.result && this.state.result.products && this.state.result.products.length > 0 ?
                <div key={props.moduleInfo.order + 1000} className={moduleClasses}>
                    { props.show_arrow === 'on' &&
                        <div>
                            <span className="prev_icon" onClick={this.goPrev}>{utils.processFontIcon(props.prev_icon)}</span>
                            <span className="next_icon" onClick={this.goNext}>{utils.processFontIcon(props.next_icon)}</span>
                        </div>}

                    <Swiper containerClass='dswc swiper-container' {...params} ref={node => {
                        if (node) {
                            this.swiper = node.swiper;
							
							// woocommerce-carousel-for-divi\scripts\frontend.js
							if ( this.swiper.$el && 'on' === props.autoplay && 'on' === props.pause_slider ) {
								
								window.jQuery(this.swiper.$el).mouseover(function() {
									this.swiper.autoplay.stop();
								});
								
								window.jQuery(this.swiper.$el).mouseout(function() {
									this.swiper.autoplay.start();
								});
							}
                        }
                    }}>
                        {this.state.result.products.map((src, index) => <div key={index} data-src={src}
                            data-alt={`${props.className}-${index}`}>

                            <div className="dswc_item_wrapper swiper-slide">{dswc_woocommerce_carousel_item.map((v, k) => this.doRender(v, src))}</div>
                        </div>)}
                    </Swiper>
                </div> : this.doRender('not_found', "No results to display")}
        </div>)
		
		
		
		return output;
    }
}

export default WoocommerceCarousel;
