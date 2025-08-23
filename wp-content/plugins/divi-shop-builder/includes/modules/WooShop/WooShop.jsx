/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JSX file) has been modified by Jonathan Hall, Anna Kurowska, Ahamed Arshad and/or others.
*/

// External dependencies
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PureRenderMixin from 'react-addons-pure-render-mixin';
import $ from 'jquery';

import assign from 'lodash/assign';
import get from 'lodash/get';
import union from 'lodash/union';
import includes from 'lodash/includes';
import has from 'lodash/has';
import unset from 'lodash/unset';
import setWith from 'lodash/setWith';
import forEach from 'lodash/forEach';
import isUndefined from 'lodash/isUndefined';
import isEmpty from 'lodash/isEmpty';
import some from 'lodash/some';

import './style.scss';

// Internal dependencies
// import ETBuilderModule from '../../et-builder-module';
// import ETBuilderActions from '../../../actions/et-builder-actions';
import standardModulePropTypes from '../../module_dependencies/standard-module-prop-types';
import getReinitAttrsList from '../../module_dependencies/et-builder-module-reinit-attrs-common';
import Utils from '../../module_dependencies/utils';
// import { getComputedSettings, fetchAllComputedSettings } from '../../module_dependencies/computed-settings-resolver';

import {
  addModuleClassName,
  componentWillMount,
  componentWillReceiveProps,
  defaultClasses,
  globalModuleClass,
  globalSavingClass,
  hideOnMobileClassName,
  inheritModuleClassName,
  moduleClassName,
  moduleClassNameArray,
  moduleID,
  orderClassName,
  removeModuleClassName,
  textOrientationClassName,
} from '../../module_dependencies/et-builder-module-classes-mixin';

/*
import {
  _isDoneLoading,
  _shouldReinit,
  _updateLoadingStatus,
} from '../../module_dependencies/et-builder-module-ui-mixin';
import {
  _initParallaxImageBackground,
  _mountVideoBackground,
  _renderParallaxImageBackground,
  _renderVideoBackground,
  _unmountVideoBackground,
  _updateVideoBackground,
} from '../../module_dependencies/et-builder-module-background-mixin';
*/
import Hover from '../../module_dependencies/hover-options';
//import Sticky from '../../module_dependencies/sticky-options';
import Responsive from '../../module_dependencies/responsive-options';
//import { getAttrsTriggeringRequest, shouldMakeRequest } from '../../module_dependencies/et-builder-module-computed-based-mixin';
//import ETBuilderStore from '../../module_dependencies/et-builder-stlore';
import { generateStyles } from '../../module_dependencies/styles';
import { getStarRatingStyle } from '../../module_dependencies/woo';

/**
 * <AGSDiviWCModuleShop />.
 */
class ModuleShop extends Component {

	// includes\modules\HelloWorld\HelloWorld.jsx
    static slug = 'ags_woo_shop_plus';
	hasDoneFirstUpdate = false;

  constructor(props) {

    super(props);

    this.state = {};

    this.$shop = window.jQuery();

    this._paginationListener = this._paginationListener.bind(this);

    // Bind PureRenderMixin
    this.shouldComponentUpdate = PureRenderMixin.shouldComponentUpdate.bind(this);

    // Bind CSSModuleClassesMixin
    this.defaultClasses = defaultClasses.bind(this);
    this.componentWillMount = componentWillMount.bind(this);
    this.componentWillReceiveProps = componentWillReceiveProps.bind(this);
    this.inheritModuleClassName = inheritModuleClassName.bind(this);
    this.addModuleClassName = addModuleClassName.bind(this);
    this.removeModuleClassName = removeModuleClassName.bind(this);
    this.orderClassName = orderClassName.bind(this);
    this.hideOnMobileClassName = hideOnMobileClassName.bind(this);
    this.moduleClassNameArray = moduleClassNameArray.bind(this);
    this.moduleClassName = moduleClassName.bind(this);
    this.moduleID = moduleID.bind(this);
    this.globalSavingClass = globalSavingClass.bind(this);
    this.globalModuleClass = globalModuleClass.bind(this);
    this.textOrientationClassName = textOrientationClassName.bind(this);

    // Bind ModuleUIMixin
    this.reinitAttrsList = union([
      'hover_icon',
      'hover_icon_tablet',
      'hover_icon_phone',
      //Sticky.getStickyField('hover_icon'),
    ], getReinitAttrsList('unifiedBackground'));

    //this.attrsForAjaxRequest = getAttrsTriggeringRequest(this, ['__shop']);

	/*
    this.reinitAttrs          = {};
    this._shouldReinit        = _shouldReinit.bind(this);
    this._updateLoadingStatus = _updateLoadingStatus.bind(this);
    this._isDoneLoading       = _isDoneLoading.bind(this);
    this._shouldMakeRequest   = shouldMakeRequest.bind(this);
	*/

    // Bind ModuleBackgroundMixin
	/*
    this._initParallaxImageBackground   = _initParallaxImageBackground.bind(this);
    this._renderParallaxImageBackground = _renderParallaxImageBackground.bind(this);
    this._mountVideoBackground          = _mountVideoBackground.bind(this);
    this._unmountVideoBackground        = _unmountVideoBackground.bind(this);
    this._updateVideoBackground         = _updateVideoBackground.bind(this);
    this._renderVideoBackground         = _renderVideoBackground.bind(this);
	*/

    this.isComponentMounted = false;
  }

  getAttrs() {
	  return this.props;
  }

  componentDidMount() {
    this.isComponentMounted = true;

    // Apply custom hover icon
    this._applyCustomHoverIcon();
    this._addShopItemClass();

    const topDocument = window.ET_Builder.Frames.top.document;
    // topDocument.addEventListener( 'click', this.onToggleActive, true );
		window.jQuery(topDocument).on('click', '.et-fb-form__toggle', this.onToggleActive.bind(this));

    this.setupMultiview();

    // this._initParallaxImageBackground();
    // this._mountVideoBackground();

    // Update UI-related status
    // this._shouldReinit();
    // this._updateLoadingStatus();
/*
    Utils.$appDocument().trigger('et_fb_shop_componentDidMount', {
      $el: window.jQuery(ReactDOM.findDOMNode(this)),
      columnsNumber: this.getAttrs().columns_number,
    });
*/

    const node = ReactDOM.findDOMNode(this);

	/*
    if (node) {
      this.$shop = window.jQuery(node);
      this.$shop.on('click.et_pb_shop', '.wp-pagenavi a, .woocommerce-pagination a', this._paginationListener);
    }
	*/

  }

  componentWillUnmount() {
    this.isComponentMounted = false;
    //this._unmountVideoBackground();
    //this.$shop.off('click.et_pb_shop', '.wp-pagenavi a, .woocommerce-pagination a', this._paginationListener);
  }

  componentWillUpdate(nextProps) {
    //this.rerender = this._shouldReinit(nextProps.attrs);
  }

  componentDidUpdate(prevProps, prevState) {

    // At the first time we set the hover icon, this.rerender return false. So, we need to double
    // check it again to make sure the hover icon is rerendered correctly. It also need to check
    // if the preview width is changed.
    const previewChange = prevProps.previewWidth !== this.props.previewWidth;
    if ( this.hasDoneFirstUpdate || (this.props.hover_icon != prevProps.hover_icon || this.props.hover_icon_tablet != prevProps.hover_icon_tablet || this.props.hover_icon_phone != prevProps.hover_icon_phone) || previewChange ) {
      this._applyCustomHoverIcon();
    }

	  this.hasDoneFirstUpdate = true;

    if (/*this._isDoneLoading() ||*/ this.state.__shop !== prevState.__shop) {
      /*Utils.$appDocument().trigger('et_fb_shop_componentDidUpdate', {
        $el: window.jQuery(ReactDOM.findDOMNode(this)),
        columnsNumber: this.getAttrs().columns_number,
      });*/
    }

    if (/*this._isDoneLoading() || */this.rerender || this.state.__shop !== prevState.__shop) {
      const node = ReactDOM.findDOMNode(this);

	  /*
      if (node) {
        this.$shop = window.jQuery(node);

        this.$shop
          .off('click.et_pb_shop')
          .on('click.et_pb_shop', '.wp-pagenavi a, .woocommerce-pagination a', this._paginationListener);
      }
	  */

      //this._initParallaxImageBackground();

      this._applyCustomHoverIcon();
      this._addShopItemClass();
    }

    this.setViewCartIcon();

    //this._updateVideoBackground(prevProps, prevState);

    //this._updateLoadingStatus();
  }

  _applyCustomHoverIcon() {
    const $shop    = window.jQuery(ReactDOM.findDOMNode(this.refs.shop));
    const $overlay = $shop.find('.et_overlay');

    // Hover Icon Picker.
    const attrs     = this.getAttrs();
    const hoverIcons    = Responsive.getPropertyValues(attrs, 'hover_icon', '', false, true);
    const activeTabMode = Responsive.getModeByWidth(this.props.previewWidth);
    const hoverIcon     = get(hoverIcons, activeTabMode);

    if (Utils.hasValue(hoverIcon)) {
      $overlay.addClass('et_pb_inline_icon').attr('data-icon', window.ET_Builder.API.Utils.processFontIcon(hoverIcon));
    } else {
      $overlay.removeClass('et_pb_inline_icon');
    }

    // Sticky Icon
	/*
    const address             = get(this, 'props.address', '');
    const moduleStickyAddress = Sticky.getEnabledStickyPositionAddress(address);
    const stickyIcon          = false !== moduleStickyAddress ? Sticky.getValue('hover_icon', attrs, '') : '';
    if (Utils.hasValue(stickyIcon)) {
      $overlay.addClass('et_pb_inline_icon_sticky').attr('data-icon-sticky', Utils.processFontIcon(stickyIcon));
    } else {
      $overlay.removeClass('et_pb_inline_icon_sticky');
    }
	*/
  }

  _addShopItemClass() {
    const $shop      = window.jQuery(ReactDOM.findDOMNode(this.refs.shop));
    const $shopItems = $shop.find('li.product');
    const itemClass  = `et_pb_shop_item_${this.props.shortcode_index}`;

    if ($shopItems.length > 0) {
      $shopItems.each((idx, $item) => {
        window.jQuery($item).addClass(`${itemClass}_${idx}`);
      });
    }
  }

  _paginationListener(event) {

    event.preventDefault();

    const $target = window.jQuery(event.target);

    if ($target.length < 1 || ! window.jQuery.contains(this.$shop[0], $target[0])) {
      return;
    }

    let pageNumber = this.props.__page ? this.props.__page : 1;

    if ($target.closest('.woocommerce-pagination').length > 0) {
      // default wc pagination
      if ($target.is('.current')) {
        return false;
      }

      if ($target.is('.next')) {
        pageNumber++;
      } else if ($target.is('.prev')) {
        pageNumber--;
      } else if ($target.is('.page-numbers')) {
        pageNumber = parseInt($target.text());
      }
    } else {
      // wp-pagenavi plugin
      if ($target.hasClass('nextpostslink')) {
        pageNumber++;
      } else if ($target.hasClass('previouspostslink')) {
        pageNumber--;
      } else {
        pageNumber = parseInt($target.text());
      }
    }

    this.setState({
		__page: pageNumber
	});

    // ETBuilderActions.moduleSettingsChange(this, '__page', pageNumber);

    return false;
  }

  setViewCartIcon(){
    const products = document.querySelectorAll('.product .added_to_cart');
    if( this.props.button_view_cart_icon && products.length ){
      products.forEach((el) => {
        el.setAttribute('data-icon', window.ET_Builder.API.Utils.processFontIcon(this.props.button_view_cart_icon))
      });
    }
  }

  static css(props) {

    let additionalCss             = [];
	let address = props.address;

	  /**
     * Module internal style.
     */
    // Sale Badge Color.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'sale_badge_color',
      selector: '%%order_class%% .ags-divi-wc-sale-badge span.onsale, %%order_class%% .woocommerce ul.products li.product .ags-divi-wc-sale-badge span.onsale',
      cssProperty: 'background-color',
      important: true,
    }));

    // Sale Percentage Badge Color.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'sale_percentage_badge_color',
      selector: '%%order_class%% .ags-divi-wc-sale-badge.ags-divi-wc-percentage-sale-badge span.onsale, %%order_class%% .woocommerce ul.products li.product .ags-divi-wc-sale-badge.ags-divi-wc-percentage-sale-badge span.onsale',
      cssProperty: 'background-color',
      important: true,
    }));

    // New Badge Color.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'new_badge_background',
      selector: 'div%%order_class%%.ags_woo_shop_plus .wc-new-badge',
      cssProperty: 'background-color',
      important: true,
    }));

    // Page Number Background Color.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'pagination_background',
      selector: '%%order_class%% .woocommerce-pagination .page-numbers',
      cssProperty: 'background-color',
      //important: true,
    }));

    // Current Page Number Background Color.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'pagination_background_current',
      selector: '%%order_class%% .woocommerce-pagination .page-numbers.current',
      cssProperty: 'background-color',
      //important: true,
    }));

    // Product Background Color.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'product_background',
      selector: '%%order_class%% li.product',
      cssProperty: 'background-color',
      //important: true,
    }));

    // Product Padding.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'product_padding',
      type: 'padding',
      selector: 'div%%order_class%% ul.products li.product',
      cssProperty: 'padding',
      //important: true,
    }));

    // Product Margin.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'product_margin',
      type: 'margin',
      selector: 'div%%order_class%% ul.products li.product',
      cssProperty: 'margin',
      //important: true,
    }));

    // Product Last Child Margin
    additionalCss.push([{
      selector:    'div%%order_class%% ul.products li.product.last',
      declaration: `margin-right: 0;`
    }]);

    // Product Description Padding.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'product_description_padding',
      type: 'padding',
      selector: 'div%%order_class%% ul.products li.product .ags-divi-wc-product-excerpt',
      cssProperty: 'padding',
      //important: true,
    }));

    // Product Description Margin.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'product_description_margin',
      type: 'margin',
      selector: 'div%%order_class%% ul.products li.product .ags-divi-wc-product-excerpt',
      cssProperty: 'margin',
      //important: true,
    }));

    // Icon Hover Color.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'icon_hover_color',
      selector: '%%order_class%% .et_shop_image .et_overlay:before',
      cssProperty: 'color',
      hover: false,
      important: true,
    }));

    // Hover Overlay Color.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'hover_overlay_color',
      selector: '%%order_class%% .et_shop_image .et_overlay',
      cssProperty: 'background',
      hover: false,
    }));

    // SKU bg Color.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'sku_bg',
      selector: '%%order_class%% .ags-divi-wc-sku',
      cssProperty: 'background-color',
      hover: false,
    }));

    // Taxonomy bg Color.
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'taxonomy_bg',
      selector: '%%order_class%% li.product .product-taxonomy',
      cssProperty: 'background-color',
      hover: false,
    }));

    // Hover Icon Data
    const extended_icon_data = window.ET_Builder.API.Utils.processIconFontData(props.hover_icon);

    if (extended_icon_data) {

      // Hover Icon Font Family.
      if (extended_icon_data.iconFontFamily) {
        additionalCss.push([{
          selector: '%%order_class%% .et_shop_image .et_overlay:before',
          declaration: `font-family: ${extended_icon_data.iconFontFamily}!important;`
        }]);
      }

      //Set Hover Icon font weight.
      if (extended_icon_data.iconFontWeight) {
        additionalCss.push([{
          selector: '%%order_class%% .et_shop_image .et_overlay:before',
          declaration: `font-weight: ${extended_icon_data.iconFontWeight}!important;`
        }]);
      }

    }



    const locations = ['top', 'right', 'bottom', 'left'];
    const margins   = props.multiview_margin.split('|');
    const paddings  = props.multiview_padding.split('|');
    locations.forEach((location,index) => {
      if( margins[index] ){
        additionalCss.push([{
          selector:    '%%order_class%% .ags_woo_shop_plus_multiview button',
          declaration: `margin-${location}: ${margins[index]} !important;`
			  }])
      }

      if( paddings[index] ){
        additionalCss.push([{
          selector:    '%%order_class%% .ags_woo_shop_plus_multiview button',
          declaration: `padding-${location}: ${paddings[index]} !important;`
			  }])
      }
    });

    additionalCss.push([{
      selector:    '%%order_class%% .ags_woo_shop_plus_multiview button',
      declaration: `color: ${ props.multiview_icon_color } !important; background-color: ${ props.multiview_bg } !important;`
    }]);

    additionalCss.push([{
      selector:    '%%order_class%% .ags_woo_shop_plus_multiview button.active',
      declaration: `color: ${ props.multiview_active_icon_color } !important; background-color: ${ props.multiview_active_bg } !important;`
    }]);

    additionalCss.push([{
      selector:    '%%order_class%% .ags_woo_shop_plus_multiview button.active',
      declaration: `border-color: ${ props.multiview_active_border_color }!important;`
    }]);

    const gridIcon = window.ET_Builder.API.Utils.processFontIcon(props.grid_view_icon);
    additionalCss.push([{
      selector:    '%%order_class%% .ags_woo_shop_plus_multiview .grid-view::before',
      declaration: `content: '${ gridIcon }' !important;`
    }]);

    const gridIconData = window.ET_Builder.API.Utils.processIconFontData(props.grid_view_icon);

    if (gridIconData) {
      if (gridIconData.iconFontFamily.length > 0) {
        additionalCss.push([{
          selector:    '%%order_class%% .ags_woo_shop_plus_multiview .grid-view::before',
          declaration: `font-family: '${ gridIconData.iconFontFamily }' !important;`
        }]);
      }

      if (gridIconData.iconFontWeight.length > 0) {
        additionalCss.push([{
          selector:    '%%order_class%% .ags_woo_shop_plus_multiview .grid-view::before',
          declaration: `font-weight: ${ gridIconData.iconFontWeight } !important;`
        }]);
      }
    }

    const listIcon = window.ET_Builder.API.Utils.processFontIcon(props.list_view_icon);
    additionalCss.push([{
      selector:    '%%order_class%% .ags_woo_shop_plus_multiview .list-view::before',
      declaration: `content: '${ listIcon }' !important;`
    }]);


   const listIconData = window.ET_Builder.API.Utils.processIconFontData(props.list_view_icon);
   if (listIconData) {
     if (listIconData.iconFontFamily.length > 0) {
       additionalCss.push([{
         selector: '%%order_class%% .ags_woo_shop_plus_multiview .list-view::before',
         declaration: `font-family: '${listIconData.iconFontFamily}' !important;`
       }]);
     }

     if (listIconData.iconFontWeight.length > 0) {
       additionalCss.push([{
         selector: '%%order_class%% .ags_woo_shop_plus_multiview .list-view::before',
         declaration: `font-weight: ${listIconData.iconFontWeight} !important;`
       }]);
     }
   }


    additionalCss.push([{
      selector:    '%%order_class%% .star-rating::before',
      declaration: `color: ${ props.rating_text_color_non_active } !important;`
    }]);

    additionalCss.push([{
      selector:    '%%order_class%% .woocommerce-pagination .page-numbers li span.current',
      declaration: `color: ${ props.pagination_active_text_color } !important;`
    }]);


    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'new_badge_padding',
      type: 'padding',
      selector: '%%order_class%%.ags_woo_shop_plus .wc-new-badge',
      cssProperty: 'padding',
      important: true,
    }));

     additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'new_badge_margin',
      type: 'margin',
      selector: '%%order_class%%.ags_woo_shop_plus .wc-new-badge',
      cssProperty: 'margin',
      important: true,
    }));

    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'sale_badge_padding',
      type: 'padding',
      selector: '%%order_class%%.ags_woo_shop_plus .woocommerce ul.products li.product .onsale',
      cssProperty: 'padding',
      important: true,
    }));

     additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'sale_badge_margin',
      type: 'margin',
      selector: '%%order_class%%.ags_woo_shop_plus .woocommerce ul.products li.product .onsale',
      cssProperty: 'margin',
      important: true,
    }));

    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'sale_percentage_badge_padding',
      type: 'padding',
      selector: '%%order_class%%.ags_woo_shop_plus .woocommerce ul.products li.product .ags-divi-wc-percentage-sale-badge .onsale',
      cssProperty: 'padding',
      important: true,
    }));

     additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'sale_percentage_badge_margin',
      type: 'margin',
      selector: '%%order_class%%.ags_woo_shop_plus .woocommerce ul.products li.product .ags-divi-wc-percentage-sale-badge .onsale',
      cssProperty: 'margin',
      important: true,
    }));

    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'image_padding',
      type: 'padding',
      selector: '%%order_class%%.et_pb_module .woocommerce li.product span.et_shop_image ',
      cssProperty: 'padding',
      important: true,
    }));

     additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'image_margin',
      type: 'margin',
      selector: '%%order_class%%.et_pb_module .woocommerce li.product span.et_shop_image',
      cssProperty: 'margin',
      important: true,
    }));

    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'sku_padding',
      type: 'padding',
      selector: '%%order_class%%.et_pb_module .woocommerce li.product .ags-divi-wc-sku',
      cssProperty: 'padding',
      important: true,
    }));

     additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'sku_margin',
      type: 'margin',
      selector: '%%order_class%%.et_pb_module .woocommerce li.product .ags-divi-wc-sku',
      cssProperty: 'margin',
      important: true,
    }));
    additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'taxonomy_padding',
      type: 'padding',
      selector: '%%order_class%% li.product .product-taxonomy',
      cssProperty: 'padding',
      important: true,
    }));

     additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'taxonomy_margin',
      type: 'margin',
      selector: '%%order_class%% li.product .product-taxonomy',
      cssProperty: 'margin',
      important: true,
    }));

     additionalCss.push(generateStyles({
      address,
      attrs: props,
      name: 'sale_price_margin',
      type: 'margin',
      selector: '%%order_class%% .woocommerce ul.products li.product .price ins .amount',
      cssProperty: 'margin',
    }));

    // No Products Found Background Color
    additionalCss.push(generateStyles({
      attrs: props,
      name: 'none_found_bg',
      selector: '%%order_class%% .ags-divi-wc-no-products-found',
      cssProperty: 'background-color',
      important: true,
    }));

    // No Products Found Padding
    additionalCss.push(generateStyles({
      attrs: props,
      name: 'none_found_padding',
      type: 'padding',
      selector: '%%order_class%% .ags-divi-wc-no-products-found',
      cssProperty: 'padding',
      important: true,
    }));

    // No Products Found Margin
    additionalCss.push(generateStyles({
      attrs: props,
      name: 'none_found_margin',
      type: 'margin',
      selector: '%%order_class%% .ags-divi-wc-no-products-found',
      cssProperty: 'margin',
      important: true,
    }));

    return additionalCss.concat(getStarRatingStyle(props, '%%order_class%% ul.products li.product .star-rating'));

  }

  render() {

    let attrs               = this.getAttrs();
    const address                 = get(this, 'props.address', '');
    //const videoBackground         = this._renderVideoBackground();
    //const parallaxImageBackground = this._renderParallaxImageBackground();



    // Data icon
    const dataIcon = ! Utils.hasValue(attrs.hover_icon) ? ''
      : window.ET_Builder.API.Utils.processFontIcon(attrs.hover_icon);


	/*
    if (Utils.hasValue(videoBackground)) {
      this.addModuleClassName('et_pb_section_video');
    }

    if (Utils.isOn(attrs.parallax)) {
      this.addModuleClassName('et_pb_section_parallax');
    }
	*/

    // Module class name
    if ('0' === attrs.columns_number) {
      this.addModuleClassName('et_pb_shop_grid');
    }
	
    if ('on' === attrs.filter_target) {
      this.addModuleClassName('ags-wc-filters-target');
    }
	
    if ('on' === attrs.ajax || 'on' === attrs.filter_target) {
      this.addModuleClassName('ags-divi-wc-shop-ajax');
    }

    // Add shop classname on non-shop module which uses shop for rendering its content
    // shop module rendering is used on WooCommerce Related Products and WooCommerce Up-sell module
    if (includes(['et_pb_wc_related_products', 'et_pb_wc_upsells'], this.props.type)) {
      this.addModuleClassName('et_pb_shop');
    }

    const { __shop } = this.props;

    return (
      <div>
		<div className="ags-divi-wc-no-products-found">
			{attrs.no_products_heading_text && <h4>{attrs.no_products_heading_text}</h4>}
			{attrs.no_products_text && <p>{attrs.no_products_text}</p>}
		</div>
        <div ref="shop" dangerouslySetInnerHTML={{ __html: __shop }} />
      </div>
    );
  }

  onToggleActive(e){
		const node	 = window.jQuery(`.${ModuleShop.slug}.et_fb_editing_enabled`);

    if( !node.length ){
      return;
    }

		setTimeout( () => {
      const target = window.jQuery(e.currentTarget);
      const self   = this;
			if( target.hasClass('et-fb-form__toggle-opened') && target.data('name') === 'button_view_cart' ){
        node.find('.product').each(function(){
          if( window.jQuery(this).find('.added_to_cart').length ){
            return;
          }
          window.jQuery('<a class="added_to_cart wc-forward" title="View cart">View cart</a>').insertAfter(window.jQuery(this).find('.button[data-product_id]'));
          self.setViewCartIcon();
        });
      }
		});
	}

  setupMultiview(){

    if( this.props.layout !== 'both' ){
      return;
    }

    const node = ReactDOM.findDOMNode(this);

    // multiview needs a small delay to be available
    setTimeout(() => {

      $('.ags_woo_shop_plus_multiview', $(node)).each(function(){
        var parent  = $(this).parents('.ags_woo_shop_plus');
        var activeView = $(this).find('.active').first().hasClass('grid-view') ? 'grid' : 'list';
        var views = parent.find('.ags-divi-wc-layout-grid, .ags-divi-wc-layout-list');
        var actions = $('button', this);

        actions.on( 'click', function() {

          if( $(this).hasClass('active') ){
            return;
          }

          actions.removeClass('active');
          $(this).addClass('active');

          var newView = $(this).hasClass('grid-view') ? 'grid' : 'list';
          views.fadeOut(200);
          views.filter('.ags-divi-wc-layout-' + newView).fadeIn(200);
        });

        views.not('.ags-divi-wc-layout-' + activeView ).fadeOut(200);
      });

    }, 100);
  }
}

ModuleShop.propTypes = standardModulePropTypes;

export default ModuleShop;
