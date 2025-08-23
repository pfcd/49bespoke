// External Dependencies
import React, {Component} from "react";
import {generateStyles} from '../../../module_dependencies/styles';
import {apply_responsive} from "../../../module_dependencies/ags-responsive";

import './style.scss';

class DSWCP_WooProductsFilters_child extends Component {
    static slug = "ags_woo_products_filters_child";
    static main_css_element = '.et_pb_module.ags_woo_products_filters %%order_class%%.et_pb_module';

    constructor(props) {
        super(props);
        this.myRef = React.createRef();
		//this.handleToggleClick = this.handleToggleClick.bind(this);
    }
	
	isToggleOpenedDefault() {
		return this.props.toggle_default !== '0' && !(this.myRef.current && window.jQuery(this.myRef.current).closest('.ags-wc-filters-row').length);
	}

    componentDidMount() {
		//window.jQuery(this.myRef.current).closest('.et_pb_module').on('click', '.ags-wc-filters-section-title.ags-wc-filters-section-toggle', this.handleToggleClick);
		
		if (!window.et_gb.wp.hooks.hasAction('et.builder.store.module.settings.open', 'wpzone/dsb/wpfchild-moduleSettingsOpen')) {
			window.et_gb.wp.hooks.addAction(
				'et.builder.store.module.settings.open',
				'wpzone/dsb/wpfchild-moduleSettingsOpen',
				function(module) {
					if (module.props._key) {
						window.ags_divi_wc_toggle_state = {};
						window.ags_divi_wc_toggle_state[module.props._key] = true;
					}
				}
			);
		}
		
		if (!window.et_gb.wp.hooks.hasAction('et.builder.store.module.settings.close', 'wpzone/dsb/wpfchild-moduleSettingsClose')) {
			window.et_gb.wp.hooks.addAction(
				'et.builder.store.module.settings.close',
				'wpzone/dsb/wpfchild-moduleSettingsClose',
				function(module) {
					window.ags_divi_wc_toggle_state = {};
				}
			);
		}
		
		var moduleKey = window.jQuery(this.myRef.current).closest('.et_pb_module').attr('_key');
		var lastState = window.ags_divi_wc_toggle_state && window.ags_divi_wc_toggle_state.hasOwnProperty(moduleKey) ? window.ags_divi_wc_toggle_state[moduleKey] : null;
		this.toggleStateCheckInterval = setInterval(() => {
			var currentState = (window.ags_divi_wc_toggle_state && window.ags_divi_wc_toggle_state.hasOwnProperty(moduleKey) ? window.ags_divi_wc_toggle_state[moduleKey] : null);
			if (lastState !== currentState) {
				lastState = currentState;
				this.forceUpdate();
			}
		}, 500);
    }
	
	/*
	handleToggleClick() {
		if (!window.ags_divi_wc_toggle_state) {
			window.ags_divi_wc_toggle_state = {};
		}
		var moduleKey = window.jQuery(this.myRef.current).closest('.et_pb_module').attr('_key');
		window.ags_divi_wc_toggle_state[moduleKey] = window.ags_divi_wc_toggle_state.hasOwnProperty(moduleKey) ? !window.ags_divi_wc_toggle_state[moduleKey] : !this.isToggleOpenedDefault();
		window.jQuery(this.myRef.current).children(':first').toggleClass('ags-wc-filters-section-toggle-closed', !window.ags_divi_wc_toggle_state[moduleKey]);
	}
	*/
	
	/*
    shouldComponentUpdate(newProps, newState) {
		if (newProps.toggle_default != this.props.toggleDefault && this.myRef.current) {
			var moduleKey = window.jQuery(this.myRef.current).closest('.et_pb_module').attr('_key');
			if (moduleKey) {
				delete window.ags_divi_wc_toggle_state[moduleKey];
			}
		}
        return true;
    }
	*/

    componentDidUpdate(oldProps) {
        var $this = window.jQuery(this.myRef.current);
        var key = $this.closest('.et_pb_module').attr('_key');

        if (window.ags_wc_filters_cache && window.ags_wc_filters_cache[key] && window.ags_wc_filters_cache[key].html === this.props.__woofilters) {
			var displayAsToggle = this.props.parent_layout === 'horizontal' || this.props.display_as_toggle !== 'off';
            $this.empty().append(window.ags_wc_filters_cache[key].dom).children().first().toggleClass('ags-wc-filters-section-toggle-closed', !this.isToggleOpen()).find('.ags-wc-filters-section-title').toggleClass('ags-wc-filters-section-toggle', displayAsToggle);
        } else {
            window.ags_wc_filters_initFilters($this);
			window.ags_wc_filters_maybeToggleNoOptionsMessage($this);
			
			var $cbRadio = $this.find('.ags-wc-filters-list :checkbox:first, .ags-wc-filters-list :radio:first, .ags-wc-filters-dropdown-multi-options li input:first').prop('checked', true);
			$cbRadio.trigger('change');
			
			var $dropdownItem = $this.find('.ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a:first');
			$dropdownItem.trigger('click');
			
			if ($cbRadio.length || $dropdownItem.length) {
				$this.find('.ags-wc-filters-title-active-count:first').text('(1)');
			}
			
			$this.find(':input').attr('readonly', true);
		}
    }

    static css(props) {
        const additionalCss = [];

        // CSS
        additionalCss.push([
            {
                selector: `${this.main_css_element}[data-agswc-active-toggle="filter_select_dropdown"] .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options, ${this.main_css_element}[data-agswc-active-toggle="filter_select_dropdown"] .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, ${this.main_css_element}[data-agswc-active-toggle="filter_search"] .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container`,
                declaration: 'display: block !important;'
            },
            {
                selector: `${this.main_css_element}`,
                declaration: `background-color: ${props.filter_container_bg_color};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-section-title`,
                declaration: `background-color: ${props.filter_title_bg_color};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-section-inner`,
                declaration: `background-color: ${props.filter_inner_bg_color};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options`,
                declaration: `background-color: ${props.filter_select_dropdown_bg_color} !important;`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container`,
                declaration: `background-color: ${props.filter_search_dropdown_bg_color} !important;`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper:after`,
                declaration: `color: ${props.filter_search_icon_color};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper:focus-within:after`,
                declaration: `color: ${props.filter_search_focus_icon_color};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-selected`,
                declaration: `background-color: ${props.filter_price_range_slider_color};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-bg`,
                declaration: `background-color: ${props.filter_price_range_slider_bg_color};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-selected, ${this.main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-bg`,
                declaration: `border-radius: ${props.filter_price_range_slider_radius};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-pointer`,
                declaration: `background-color: ${props.filter_price_range_slider_pointer_color};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-pointer`,
                declaration: `border-radius: ${props.filter_price_range_slider_pointer_radius};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-tooltip`,
                declaration: `color: ${props.filter_price_range_slider_tooltip_color};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-tooltip`,
                declaration: `background-color: ${props.filter_price_range_slider_tooltip_bg_color};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-tooltip`,
                declaration: `border-radius: ${props.filter_price_range_slider_tooltip_radius};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-stars .ags-wc-filters-star-filled`,
                declaration: `color: ${props.filter_rating_star_color};`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-stars .ags-wc-filters-star-empty`,
                declaration: `color: ${props.filter_rating_star_placeholder_color}`
            },
            {
                selector: `${this.main_css_element} .ags-wc-filters-stars .ags-wc-filters-star-hover`,
                declaration: `color: ${props.filter_rating_star_hover_color}`
            },
        ]);


        // Toggled Title Arrow Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_title_toggle_arrow_color',
            selector: `${this.main_css_element} .ags-wc-filters-section-title.ags-wc-filters-section-toggle::after`,
            cssProperty: 'color',
        }));

        // Radio buttons
        if (props.filter_radio_style_enable === 'on') {
            additionalCss.push([
                {
                    selector: `${this.main_css_element} .ags-wc-filters-radio-button-list li label`,
                    declaration: `display : inline-flex; flex-wrap : wrap; align-items : center; padding-left : 24px !important; min-height : 18px; min-width : 18px;`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-radio-button-list li label:before, ${this.main_css_element} .ags-wc-filters-radio-button-list li label:after`,
                    declaration: `content : "";  position : absolute; top : 50%; left : 0;  -webkit-transform : translateY(-50%); transform : translateY(-50%); width : 18px; height : 18px; border-radius : 50%;`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-radio-button-list li input[type=radio]`,
                    declaration: `padding : 0;  margin  : 0; height : 0; width : 0;display : none; position : absolute; -webkit-appearance : none;`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-radio-button-list li label:before`,
                    declaration: `background-color: ${props.radio_background_color};`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-radio-button-list li label:after`,
                    declaration: `display : none;  box-shadow : inset 0 0 0 4px ${props.radio_checked_background_color};`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-radio-button-list li input[type=radio]:checked ~ label:after, ${this.main_css_element} .ags-wc-filters-radio-button-list li label:before`,
                    declaration: `display : block;`
                },
            ]);
        }

        // Radio buttons list item background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_radio_list_item_bg_color',
            selector: `${this.main_css_element} .ags-wc-filters-radio-button-list li`,
            cssProperty: 'background-color',
        }));

        // Radio buttons list item text color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_radio_list_item_color',
            selector: `${this.main_css_element} .ags-wc-filters-radio-button-list li`,
            cssProperty: 'color',
        }));

        // Checkboxes
        if (props.filter_checkbox_style_enable === 'on') {
            additionalCss.push([
                {
                    selector: `${this.main_css_element} .ags-wc-filters-checkbox-list li label`,
                    declaration: `display : inline-flex; flex-wrap : wrap; align-items : center; padding-left : 24px !important; min-height : 18px; min-width : 18px;`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-checkbox-list li label:before, ${this.main_css_element} .ags-wc-filters-checkbox-list li label:after`,
                    declaration: `content : "";  position : absolute; top : 50%; left : 0;  -webkit-transform : translateY(-50%); transform : translateY(-50%); width : 18px; height : 18px; display : block; -webkit-appearance : none;`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-checkbox-list li input[type=checkbox]`,
                    declaration: `padding : 0;  margin  : 0; height : 0; width : 0;display : none; position : absolute; -webkit-appearance : none;`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-checkbox-list li label:before`,
                    declaration: `background-color: ${props.checkbox_background_color};`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-checkbox-list input:checked + label:after`,
                    declaration: `content : "\\e803"; font-family : "Divi Shop Builder"; line-height : 18px; font-weight : normal; height : 18px; width : 18px; font-size : 19px; text-indent: -2px; text-align : center; color : ${props.checkbox_checked_color};`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-checkbox-list li input:checked + label:before`,
                    declaration: `background-color: ${props.checkbox_checked_background_color};`
                },
            ]);
        }

        // Checkbox list item background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_checkbox_list_item_bg_color',
            selector: `${this.main_css_element} .ags-wc-filters-checkbox-list li`,
            cssProperty: 'background-color',
        }));

        // Checkbox list item text color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_checkbox_list_item_color',
            selector: `${this.main_css_element} .ags-wc-filters-checkbox-list li`,
            cssProperty: 'color',
        }));

        // Select Dropdown Arrow
        if (props.filter_select_dropdown_arrow_enable === 'on') {
            let arrow_size = props.filter_select_dropdown_arrow_size;
            let arrow_alignment = props.filter_select_dropdown_arrow_alignment;

            if (arrow_alignment === 'left') {
                additionalCss.push([
                    {
                        selector: `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before`,
                        declaration: `left : ${props.filter_select_dropdown_arrow_offset};`
                    },
                ]);
            } else if (arrow_alignment === 'right') {
                additionalCss.push([
                    {
                        selector: `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before`,
                        declaration: `right : ${props.filter_select_dropdown_arrow_offset};`
                    },
                ]);
            } else {
                additionalCss.push([
                    {
                        selector: `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before`,
                        declaration: 'right : 50%; transform : translate(50%, 0);'
                    },
                ]);
            }

            additionalCss.push([
                {
                    selector: `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle`,
                    declaration: `position : absolute; width : 100%; top: 0;`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before`,
                    declaration: `content : ""; display: block;  top : -${arrow_size}; right : 30px; position : absolute; width : 0; height : 0; border-left : ${arrow_size} solid transparent; border-right : ${arrow_size} solid transparent; border-bottom-style : solid; border-bottom-width : ${arrow_size}; border-bottom-color : ${props.filter_select_dropdown_bg_color}; z-index : 1;`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options`,
                    declaration: `margin-top: ${arrow_size};`
                },
            ]);
        }

        // Select Dropdown Item background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_select_dropdown_item_bg_color',
            selector: `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a`,
            cssProperty: 'background-color',
        }));

        // Dropdown Item Text Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_select_dropdown_item_color',
            selector: `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a`,
            cssProperty: 'color',
        }));

        // Dropdown Item Selected Background Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_select_dropdown_item_selected_bg_color',
            selector: `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li.ags-wc-filters-active a`,
            cssProperty: 'background-color',
        }));


        // Dropdown Item Selected Text Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_select_dropdown_item_selected_color',
            selector: `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active > span, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options input:checked + label`,
            cssProperty: 'color',
        }));

        // Dropdown Item Selected Check Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_select_dropdown_item_selected_check_color',
            selector: `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active > span:after, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options input:checked + label:after`,
            cssProperty: 'color',
        }));

        // Search Dropdown Arrow
        if (props.filter_search_dropdown_arrow_enable === 'on') {
            let search_arrow_size = props.filter_search_dropdown_arrow_size;
            let search_arrow_alignment = props.filter_search_dropdown_arrow_alignment;

            if (search_arrow_alignment === 'left') {
                additionalCss.push([
                    {
                        selector: `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before`,
                        declaration: `left : ${props.filter_search_dropdown_arrow_offset};`
                    },
                ]);
            } else if (search_arrow_alignment === 'right') {
                additionalCss.push([
                    {
                        selector: `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before`,
                        declaration: `right : ${props.filter_search_dropdown_arrow_offset};`
                    },
                ]);
            } else {
                additionalCss.push([
                    {
                        selector: `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before`,
                        declaration: 'right : 50%; transform : translate(50%, 0);'
                    },
                ]);
            }

            additionalCss.push([
                {
                    selector: `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before`,
                    declaration: `position : absolute; width : 100%; top: 0;`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before`,
                    declaration: `content : ""; display: block;  top : -${search_arrow_size}; right : 30px; position : absolute; width : 0; height : 0; border-left : ${search_arrow_size} solid transparent; border-right : ${search_arrow_size} solid transparent; border-bottom-style : solid; border-bottom-width : ${search_arrow_size}; border-bottom-color : ${props.filter_search_dropdown_bg_color}; z-index : 1;`
                },
                {
                    selector: `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container`,
                    declaration: `margin-top: ${search_arrow_size};`
                },
            ]);
        }

        // Search Dropdown Item background
        if (props.filter_search_dropdown_item_bg_enable === 'on') {
            additionalCss.push(generateStyles({
                attrs: props,
                name: 'filter_search_dropdown_item_bg_color',
                selector: `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a`,
                cssProperty: 'background-color',
            }));
        }

        // Search Dropdown Item Text Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_search_dropdown_item_color',
            selector: `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a`,
            cssProperty: 'color',
        }));

        // Search Icon Position
        if (props.filter_search_icon_position === 'left') {
            additionalCss.push([
                {
                    selector: `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper`,
                    declaration: 'flex-direction: row-reverse;',
                },
            ]);
        }

        // Tagcloud Tag background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_tagcloud_tag_bg_color',
            selector: `${this.main_css_element} .ags-wc-filters-tagcloud li label`,
            cssProperty: 'background-color',
        }));

        // Tagcloud Tag color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_tagcloud_tag_text_color',
            selector: `${this.main_css_element} .ags-wc-filters-tagcloud li label`,
            cssProperty: 'color',
        }));

        // Tagcloud Tag Active background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_tagcloud_tag_active_bg_color',
            selector: `${this.main_css_element} .ags-wc-filters-tagcloud li input[type=radio]:checked + label`,
            cssProperty: 'background-color',
        }));

        // Tagcloud Tag Active color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_tagcloud_tag_active_text_color',
            selector: `${this.main_css_element} .ags-wc-filters-tagcloud li input[type=radio]:checked + label`,
            cssProperty: 'color',
        }));

        // Tagcloud Tag Active border color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_tagcloud_tag_active_border_color',
            selector: `${this.main_css_element} .ags-wc-filters-tagcloud li input[type=radio]:checked + label`,
            cssProperty: 'border-color',
        }));

        // Products number background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'products_number_bg_color',
            selector: `${this.main_css_element} .ags-wc-filters-product-count`,
            cssProperty: 'background-color',
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'attribute_border_color',
            selector: `${this.main_css_element} .ags-wc-filters-images`,
            cssProperty: '--ags-wc-attr-img-border-color',
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'attribute_selected_accent',
            selector: `${this.main_css_element}`,
            cssProperty: '--ags-wc-attr-selected-color'
        }));


        if (props.attr_image_position !== 'left') {
            additionalCss.push([
                {
                    selector: `${this.main_css_element} .ags-wc-filters-images .ags-wc-filters-product-att-label`,
                    declaration: 'flex-basis: 100%;text-align: center;',
                },
            ]);
        }

        if (props.attr_image_position === 'left') {
            additionalCss.push([
                {
                    selector: `${this.main_css_element} img`,
                    declaration: 'margin-right: 5px;',
                },
            ]);
        }


        additionalCss.push(generateStyles({
            attrs: props,
            name: 'attribute_bg_accent',
            selector: `${this.main_css_element}`,
            cssProperty: '--ags-wc-attr-bg-color',
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'attribute_selected_bg_accent',
            selector: `${this.main_css_element}`,
            cssProperty: '--ags-wc-attr-selected-bg-color',
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'attribute_selected_text_color',
            selector: `${this.main_css_element}  li input:checked + label`,
            cssProperty: 'color',
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'tooltip_bg_color',
            selector: `${this.main_css_element} .ags_wc_filters_tooltip`,
            cssProperty: 'background-color',
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'attr_color_products_number_color',
            selector: `${this.main_css_element} .ags-wc-filters-colors.ags-wc-filters-labels-hide label > .ags-wc-filters-product-count`,
            cssProperty: 'color',
        }));

        additionalCss.push(generateStyles({
            attrs: props,
            name: 'attr_color_products_number_bg_color',
            selector: `${this.main_css_element} .ags-wc-filters-colors.ags-wc-filters-labels-hide label > .ags-wc-filters-product-count`,
            cssProperty: 'background-color',
        }));


        // Responsive CSS
        let additionalCss_ = additionalCss;

        // Paddings and Margins

        // - Single Filter
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_container_padding', `${this.main_css_element}`, 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_container_margin', `${this.main_css_element}`, 'margin', true));

        // - Filter Title
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_title_padding', `${this.main_css_element} .ags-wc-filters-section-title`, 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_title_margin', `${this.main_css_element} .ags-wc-filters-section-title`, 'margin'));

        // - Filter Inner
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_inner_padding', `${this.main_css_element} .ags-wc-filters-section-inner`, 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_inner_margin', `${this.main_css_element} .ags-wc-filters-section-inner`, 'margin'));

        // - Radio List Item
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_radio_list_item_padding', `${this.main_css_element} .ags-wc-filters-radio-button-list li`, 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_radio_list_item_margin', `${this.main_css_element} .ags-wc-filters-radio-button-list li`, 'margin'));

        // - Checkbox List Item
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_checkbox_list_item_padding', `${this.main_css_element} .ags-wc-filters-checkbox-list li`, 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_checkbox_list_item_margin', `${this.main_css_element} .ags-wc-filters-checkbox-list li`, 'margin'));

        // - Select Dropdown
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_select_dropdown_padding', `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options`, 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_select_dropdown_margin', `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options`, 'margin', true));

        // - Select Dropdown Item
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_select_dropdown_item_padding', `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a label`, 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_select_dropdown_item_margin', `${this.main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, ${this.main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a label`, 'margin'));

        // - Search Dropdown
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_search_dropdown_padding', `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container`, 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_search_dropdown_margin', `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container`, 'margin', true));

        // - Search Dropdown Item
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_search_dropdown_item_padding', `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a`, 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_search_dropdown_item_margin', `${this.main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a`, 'margin'));

        // - Tagcloud
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_tagcloud_tag_padding', `${this.main_css_element} .ags-wc-filters-tagcloud li label`, 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_tagcloud_tag_margin', `${this.main_css_element} .ags-wc-filters-tagcloud li label`, 'margin'));

        // - Product Count
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'products_number_padding', `${this.main_css_element} .ags-wc-filters-product-count`, 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'products_number_margin', `${this.main_css_element} .ags-wc-filters-product-count`, 'margin'));

        // - Image Select
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'attr_select_padding', `${this.main_css_element} .ags-wc-filters-images li label`, 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'attr_select_margin', `${this.main_css_element} .ags-wc-filters-images li label`, 'margin'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'attr_image_margin', `${this.main_css_element} .ags-wc-filters-images li label img`, 'margin'));

        /// Search Icon
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_search_icon_size', `{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper:after`, 'font-size'));

        // Toggled Title Arrow
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_title_toggle_arrow_size', `${this.main_css_element} .ags-wc-filters-section-title.ags-wc-filters-section-toggle::after`, 'font-size'));

        // Rating
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_rating_spacing', `${this.main_css_element} .ags-wc-filters-stars`, 'letter-spacing'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_rating_size', `${this.main_css_element} .ags-wc-filters-stars`, 'font-size'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'color_swatches_size', `${this.main_css_element} .ags-wc-filters-colors label .ags_wc_filters_color_wrap`, 'font-size'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'attr_spacing', `${this.main_css_element}  .ags-wc-filters-colors li:not(:last-of-type), ${this.main_css_element} .ags-wc-filters-images li`, 'padding-bottom'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'attr_spacing', `${this.main_css_element}  .ags-wc-filters-colors li:not(:last-of-type),${this.main_css_element} .ags-wc-filters-images li`, 'padding-right'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'attr_image_width', `${this.main_css_element}  .ags-wc-filters-images li label img`, 'max-width'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'attr_image_height', `${this.main_css_element} .ags-wc-filters-images li label img`, 'max-height'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'attr_image_flex_basis', `${this.main_css_element} .ags-wc-filters-images li`, 'flex-basis'));

        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'attr_image_border_radius', `${this.main_css_element} .ags-wc-filters-images li label`, 'border-radius'));

        return additionalCss_;
    }

    render() {
		var displayAsToggle = this.props.parent_layout === 'horizontal' || this.props.display_as_toggle !== 'off';
		
		var html = this.props.__woofilters ? this.props.__woofilters : '';
		
		if (!displayAsToggle || this.isToggleOpen()) {
			html = html.replace(' ags-wc-filters-section-toggle-closed', '');
			
			if (!displayAsToggle) {
				html = html.replace(' ags-wc-filters-section-toggle', '');
			}
		}
		
        return (
            <div ref={this.myRef} dangerouslySetInnerHTML={{__html: html}}></div>
        );
    }
	
	isToggleOpen() {
		var toggleOpen = null;
		if ( this.myRef.current ) {
			var moduleKey = window.jQuery(this.myRef.current).closest('.et_pb_module').attr('_key');
			if (moduleKey && window.ags_divi_wc_toggle_state && window.ags_divi_wc_toggle_state.hasOwnProperty(moduleKey)) {
				toggleOpen = window.ags_divi_wc_toggle_state[moduleKey];
			}
		}
		if (toggleOpen === null) {
			toggleOpen = this.isToggleOpenedDefault();
		}
		return toggleOpen;
	}

    componentWillUnmount() {
        if (!window.ags_wc_filters_cache) {
            window.ags_wc_filters_cache = {};
        }
        var $this = window.jQuery(this.myRef.current);

        var key = $this.closest('.et_pb_module').attr('_key');
        window.ags_wc_filters_cache[key] = {
            html: this.props.__woofilters,
            dom: $this.children()
        };
		
		//$this.closest('.et_pb_module').off('click', '.ags-wc-filters-section-title.ags-wc-filters-section-toggle', this.handleToggleClick);
		
		if (this.toggleStateCheckInterval) {
			clearInterval(this.toggleStateCheckInterval);
		}
    }
}

export default DSWCP_WooProductsFilters_child;
