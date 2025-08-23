// External Dependencies
import React, {Component} from 'react';
import {generateStyles} from '../../../module_dependencies/styles';
import DSWCP_Modules from "../../loader";

import {apply_responsive} from "../../../module_dependencies/ags-responsive";

import './style.scss';

class DSWCP_WooProductsFilters extends Component {

    static slug = 'ags_woo_products_filters';

    static marginPaddingElements = {
        filter_title: '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-title',
        filter_inner: '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-inner',
        filter_radio_list: '%%order_class%% .ags-wc-filters-radio-button-list li',
        filter_checkbox_list: '%%order_class%% .ags-wc-filters-checkbox-list li',
        filter_tagcloud: '%%order_class%% .ags-wc-filters-tagcloud li label',
        products_number: '%%order_class%% .ags-wc-filters-product-count',
        filters_buttons_container: '%%order_class%% .ags-wc-filters-buttons',
        selected_filters_container: '%%order_class%% .ags-wc-filters-selected-main',
        selected_filters_title: '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-section-title',
        selected_filters_inner: '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-body',
        selected_filter: '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner',
    };

    static css(props) {
        const additionalCss = [];
		
		// VB only CSS
		if (props.active_count !== 'on') {
			 additionalCss.push([
            {
                selector: '%%order_class%% .ags-wc-filters-title-active-count',
                declaration: 'display: none !important;'
            },
			]);
		}

        // CSS
        additionalCss.push([
            {
                selector: '%%order_class%%[data-agswc-active-toggle="filter_select_dropdown"] .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options, %%order_class%%[data-agswc-active-toggle="filter_select_dropdown"] .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, %%order_class%%[data-agswc-active-toggle="filter_search"] .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container',
                declaration: 'display: block !important;'
            },
            {
                selector: '%%order_class%% .ags_woo_products_filters_child',
                declaration: `background-color: ${props.filter_container_bg_color};`
            },
            {
                selector: '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-title',
                declaration: `background-color: ${props.filter_title_bg_color};`
            },
            {
                selector: '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-inner',
                declaration: `background-color: ${props.filter_inner_bg_color};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options',
                declaration: `background-color: ${props.filter_select_dropdown_bg_color} !important;`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container',
                declaration: `background-color: ${props.filter_search_dropdown_bg_color} !important;`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper:after',
                declaration: `color: ${props.filter_search_icon_color};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper:focus-within:after',
                declaration: `color: ${props.filter_search_focus_icon_color};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-selected',
                declaration: `background-color: ${props.filter_price_range_slider_color};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-bg',
                declaration: `background-color: ${props.filter_price_range_slider_bg_color};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-selected, %%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-bg',
                declaration: `border-radius: ${props.filter_price_range_slider_radius};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-pointer',
                declaration: `background-color: ${props.filter_price_range_slider_pointer_color};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-pointer',
                declaration: `border-radius: ${props.filter_price_range_slider_pointer_radius};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-tooltip',
                declaration: `color: ${props.filter_price_range_slider_tooltip_color};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-tooltip',
                declaration: `background-color: ${props.filter_price_range_slider_tooltip_bg_color};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-tooltip',
                declaration: `border-radius: ${props.filter_price_range_slider_tooltip_radius};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-stars .ags-wc-filters-star-filled',
                declaration: `color: ${props.filter_rating_star_color};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-stars .ags-wc-filters-star-empty',
                declaration: `color: ${props.filter_rating_star_placeholder_color}`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-stars .ags-wc-filters-star-hover',
                declaration: `color: ${props.filter_rating_star_hover_color}`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-buttons',
                declaration: `background-color: ${props.filters_buttons_container_bg_color};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-selected-main',
                declaration: `background-color: ${props.selected_filters_container_bg_color};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-section-title',
                declaration: `background-color: ${props.selected_filters_title_bg_color};`
            },
            {
                selector: '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-body',
                declaration: `background-color: ${props.selected_filters_inner_bg_color};`
            },
        ]);

        // Toggled Title Arrow Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_title_toggle_arrow_color',
            selector: '%%order_class%% .ags-wc-filters-section-title.ags-wc-filters-section-toggle::after',
            cssProperty: 'color',
        }));

        // Radio buttons
        if (props.filter_radio_style_enable === 'on') {
            additionalCss.push([
                {
                    selector: '%%order_class%% .ags-wc-filters-radio-button-list li label',
                    declaration: `display : inline-flex; flex-wrap : wrap; align-items : center; padding-left : 24px !important; min-height : 18px; min-width : 18px;`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-radio-button-list li label:before, %%order_class%% .ags-wc-filters-radio-button-list li label:after',
                    declaration: `content : "";  position : absolute; top : 50%; left : 0;  -webkit-transform : translateY(-50%); transform : translateY(-50%); width : 18px; height : 18px; border-radius : 50%;`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-radio-button-list li input[type=radio]',
                    declaration: `padding : 0;  margin  : 0; height : 0; width : 0;display : none; position : absolute; -webkit-appearance : none;`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-radio-button-list li label:before',
                    declaration: `background-color: ${props.radio_background_color};`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-radio-button-list li label:after',
                    declaration: `display : none;  box-shadow : inset 0 0 0 4px ${props.radio_checked_background_color};`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-radio-button-list li input[type=radio]:checked ~ label:after, %%order_class%% .ags-wc-filters-radio-button-list li label:before',
                    declaration: `display : block;`
                },
            ]);
        }

        // Radio buttons list item background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_radio_list_item_bg_color',
            selector: '%%order_class%% .ags-wc-filters-radio-button-list li',
            cssProperty: 'background-color',
        }));

        // Radio buttons list item text color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_radio_list_item_color',
            selector: '%%order_class%% .ags-wc-filters-radio-button-list li',
            cssProperty: 'color',
        }));

        // Checkboxes
        if (props.filter_checkbox_style_enable === 'on') {
            additionalCss.push([
                {
                    selector: '%%order_class%% .ags-wc-filters-checkbox-list li label',
                    declaration: `display : inline-flex; flex-wrap : wrap; align-items : center; padding-left : 24px !important; min-height : 18px; min-width : 18px;`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-checkbox-list li label:before, %%order_class%% .ags-wc-filters-checkbox-list li label:after',
                    declaration: `content : "";  position : absolute; top : 50%; left : 0;  -webkit-transform : translateY(-50%); transform : translateY(-50%); width : 18px; height : 18px; display : block; -webkit-appearance : none;`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-checkbox-list li input[type=checkbox]',
                    declaration: `padding : 0;  margin  : 0; height : 0; width : 0;display : none; position : absolute; -webkit-appearance : none;`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-checkbox-list li label:before',
                    declaration: `background-color: ${props.checkbox_background_color};`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-checkbox-list input:checked + label:after',
                    declaration: `content : "\\e803"; font-family : "Divi Shop Builder"; line-height : 18px; font-weight : normal; height : 18px; width : 18px; font-size : 19px; text-indent: -2px; text-align : center; color : ${props.checkbox_checked_color};`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-checkbox-list li input:checked + label:before',
                    declaration: `background-color: ${props.checkbox_checked_background_color};`
                },
            ]);
        }

        // Checkbox list item background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_checkbox_list_item_bg_color',
            selector: '%%order_class%% .ags-wc-filters-checkbox-list li',
            cssProperty: 'background-color',
        }));

        // Checkbox list item text color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_checkbox_list_item_color',
            selector: '%%order_class%% .ags-wc-filters-checkbox-list li',
            cssProperty: 'color',
        }));

        // Select Dropdown Arrow
        if (props.filter_select_dropdown_arrow_enable === 'on') {
            let arrow_size = props.filter_select_dropdown_arrow_size;
            let arrow_alignment = props.filter_select_dropdown_arrow_alignment;

            if (arrow_alignment === 'left') {
                additionalCss.push([
                    {
                        selector: '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before',
                        declaration: `left : ${props.filter_select_dropdown_arrow_offset};`
                    },
                ]);
            } else if (arrow_alignment === 'right') {
                additionalCss.push([
                    {
                        selector: '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before',
                        declaration: `right : ${props.filter_select_dropdown_arrow_offset};`
                    },
                ]);
            } else {
                additionalCss.push([
                    {
                        selector: '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before',
                        declaration: 'right : 50%; transform : translate(50%, 0);'
                    },
                ]);
            }

            additionalCss.push([
                {
                    selector: '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle',
                    declaration: `position : absolute; width : 100%; top: 0;`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before',
                    declaration: `content : ""; display: block;  top : -${arrow_size}; right : 30px; position : absolute; width : 0; height : 0; border-left : ${arrow_size} solid transparent; border-right : ${arrow_size} solid transparent; border-bottom-style : solid; border-bottom-width : ${arrow_size}; border-bottom-color : ${props.filter_select_dropdown_bg_color}; z-index : 1;`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options',
                    declaration: `margin-top: ${arrow_size};`
                },
            ]);
        }

        // Select Dropdown Item background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_select_dropdown_item_bg_color',
            selector: '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a',
            cssProperty: 'background-color',
        }));

        // Dropdown Item Text Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_select_dropdown_item_color',
            selector: '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a',
            cssProperty: 'color',
        }));

        // Dropdown Item Selected Background Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_select_dropdown_item_selected_bg_color',
            selector: '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li.ags-wc-filters-active a',
            cssProperty: 'background-color',
        }));

        // Dropdown Item Selected Text Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_select_dropdown_item_selected_color',
            selector: '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active > span, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options input:checked + label',
            cssProperty: 'color',
        }));

        // Dropdown Item Selected Check Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_select_dropdown_item_selected_check_color',
            selector: '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active > span:after, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options input:checked + label:after',
            cssProperty: 'color',
        }));

        // Search Dropdown Arrow
        if (props.filter_search_dropdown_arrow_enable === 'on') {
            let search_arrow_size = props.filter_search_dropdown_arrow_size;
            let search_arrow_alignment = props.filter_search_dropdown_arrow_alignment;

            if (search_arrow_alignment === 'left') {
                additionalCss.push([
                    {
                        selector: '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before',
                        declaration: `left : ${props.filter_search_dropdown_arrow_offset};`
                    },
                ]);
            } else if (search_arrow_alignment === 'right') {
                additionalCss.push([
                    {
                        selector: '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before',
                        declaration: `right : ${props.filter_search_dropdown_arrow_offset};`
                    },
                ]);
            } else {
                additionalCss.push([
                    {
                        selector: '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before',
                        declaration: 'right : 50%; transform : translate(50%, 0);'
                    },
                ]);
            }

            additionalCss.push([
                {
                    selector: '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before',
                    declaration: `position : absolute; width : 100%; top: 0;`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before',
                    declaration: `content : ""; display: block;  top : -${search_arrow_size}; right : 30px; position : absolute; width : 0; height : 0; border-left : ${search_arrow_size} solid transparent; border-right : ${search_arrow_size} solid transparent; border-bottom-style : solid; border-bottom-width : ${search_arrow_size}; border-bottom-color : ${props.filter_search_dropdown_bg_color}; z-index : 1;`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container',
                    declaration: `margin-top: ${search_arrow_size};`
                },
            ]);
        }

        // Search Dropdown Item background
        if (props.filter_search_dropdown_item_bg_enable === 'on') {
            additionalCss.push(generateStyles({
                attrs: props,
                name: 'filter_search_dropdown_item_bg_color',
                selector: '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a',
                cssProperty: 'background-color',
            }));
        }

        // Search Dropdown Item Text Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_search_dropdown_item_color',
            selector: '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a',
            cssProperty: 'color',
        }));

        // Search Icon Position
        if (props.filter_search_icon_position === 'left') {
            additionalCss.push([
                {
                    selector: '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper',
                    declaration: 'flex-direction: row-reverse;',
                },
            ]);
        }

        // Tagcloud Tag background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_tagcloud_tag_bg_color',
            selector: '%%order_class%% .ags-wc-filters-tagcloud li label',
            cssProperty: 'background-color',
        }));

        // Tagcloud Tag color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_tagcloud_tag_text_color',
            selector: '%%order_class%% .ags-wc-filters-tagcloud li label',
            cssProperty: 'color',
        }));

        // Tagcloud Tag Active background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_tagcloud_tag_active_bg_color',
            selector: '%%order_class%% .ags-wc-filters-tagcloud li input[type=radio]:checked + label',
            cssProperty: 'background-color',
        }));

        // Tagcloud Tag Active color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_tagcloud_tag_active_text_color',
            selector: '%%order_class%% .ags-wc-filters-tagcloud li input[type=radio]:checked + label',
            cssProperty: 'color',
        }));

        // Tagcloud Tag Active border color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'filter_tagcloud_tag_active_border_color',
            selector: '%%order_class%% .ags-wc-filters-tagcloud li input[type=radio]:checked + label',
            cssProperty: 'border-color',
        }));

        // Products number background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'products_number_bg_color',
            selector: '%%order_class%% .ags-wc-filters-product-count',
            cssProperty: 'background-color',
        }));

        // Selected Filter Background
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'selected_filter_bg_color',
            selector: '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner',
            cssProperty: 'background-color',
        }));

        // Selected Filter Clear Icon Posiition & Spacing
        if (props.selected_filter_clear_icon_position === 'before') {
            additionalCss.push([
                {
                    selector: '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner .ags-wc-filters-remove',
                    declaration: `margin-right: ${props.selected_filter_clear_icon_spacing};`
                },
            ]);
        }

        if (props.selected_filter_clear_icon_position === 'after') {
            additionalCss.push([
                {
                    selector: '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner .ags-wc-filters-remove',
                    declaration: `margin-left: ${props.selected_filter_clear_icon_spacing};`
                },
                {
                    selector: '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner',
                    declaration: `flex-direction: row-reverse;`
                },
            ]);
        }

        // Selected Filter Remove Icon Color
        additionalCss.push(generateStyles({
            attrs: props,
            name: 'selected_filter_clear_icon_color',
            selector: '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner .ags-wc-filters-remove:before',
            cssProperty: 'color',
        }));

        // Clear Button Icon
        if (props.clear_filters_button_use_icon && props.clear_filters_button_use_icon === 'on' && props.clear_filters_button_icon) {
            const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.clear_filters_button_icon);
            const position = props.clear_filters_button_icon_placement ? props.clear_filters_button_icon_placement : 'right';
            additionalCss.push([{
                selector: `%%order_class%% .ags-wc-filters-button-clear::${position === 'left' ? 'before' : 'after'}`,
                declaration: `content: '${icon}' !important;`
            }]);
        }

        // Apply Button Icon
        if (props.apply_filters_button_use_icon && props.apply_filters_button_use_icon === 'on' && props.apply_filters_button_icon) {
            const icon = DSWCP_Modules.builderApi.Utils.processFontIcon(props.apply_filters_button_icon);
            const position = props.apply_filters_button_icon_placement ? props.apply_filters_button_icon_placement : 'right';
            additionalCss.push([{
                selector: `%%order_class%% .ags-wc-filters-button-apply::${position === 'left' ? 'before' : 'after'}`,
                declaration: `content: '${icon}' !important;`
            }]);
        }

        // Responsive CSS
        let additionalCss_ = additionalCss;

        // Paddings and Margins
        for (let elementId in DSWCP_WooProductsFilters.marginPaddingElements) {
            additionalCss_ = additionalCss_.concat(apply_responsive(props, elementId + '_padding', DSWCP_WooProductsFilters.marginPaddingElements[elementId]));
            additionalCss_ = additionalCss_.concat(apply_responsive(props, elementId + '_margin', DSWCP_WooProductsFilters.marginPaddingElements[elementId], 'margin'));
        }

        // - Filter Container
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_container_padding', '%%order_class%% .ags_woo_products_filters_child', 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_container_margin', '%%order_class%% .ags_woo_products_filters_child', 'margin', true));

        // - Radio List Item
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_radio_list_item_padding', '%%order_class%% .ags-wc-filters-radio-button-list li', 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_radio_list_item_margin', '%%order_class%% .ags-wc-filters-radio-button-list li', 'margin'));

        // - Checkbox List Item
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_checkbox_list_item_padding', '%%order_class%% .ags-wc-filters-checkbox-list li', 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_checkbox_list_item_margin', '%%order_class%% .ags-wc-filters-checkbox-list li', 'margin'));

        // - Select Dropdown
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_select_dropdown_padding', '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options', 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_select_dropdown_margin', '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options', 'margin', true));

        // - Select Dropdown Item
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_select_dropdown_item_padding', '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a label', 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_select_dropdown_item_margin', '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a label', 'margin'));

        // - Search Dropdown
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_search_dropdown_padding', '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container', 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_search_dropdown_margin', '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container', 'margin', true));

        // - Search Dropdown Item
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_search_dropdown_item_padding', '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a', 'padding'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_search_dropdown_item_margin', '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a', 'margin'));

        /// Search Icon
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_search_icon_size', '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper:after', 'font-size'));

        // Toggled Title Arrow
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_title_toggle_arrow_size', '%%order_class%% .ags-wc-filters-section-title.ags-wc-filters-section-toggle::after', 'font-size'));

        // Rating
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_rating_spacing', '%%order_class%% .ags-wc-filters-stars', 'letter-spacing'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filter_rating_size', '%%order_class%% .ags-wc-filters-stars', 'font-size'));

        // Buttons Alignment
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'filters_buttons_alignment', '%%order_class%% .ags-wc-filters-buttons', 'justify-content'));

        // Selected Filters
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'selected_filters_alignment', '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected', 'justify-content'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'selected_filters_clear_button_alignment', '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-body', 'justify-content'));
        additionalCss_ = additionalCss_.concat(apply_responsive(props, 'selected_filter_clear_icon_size', '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner .ags-wc-filters-remove:before', 'font-size'));

        return additionalCss_;
    }

    render() {
		
		var selectedFilters = <div className={'ags-wc-filters-selected-main ags-wc-filters-selected-display-' + this.props.selected_filters}>
                        <div className="ags-wc-filters-selected-outer">
                            {this.props.display_selected_filters_title === 'on' ? <div className="ags-wc-filters-section-title"><h4>{this.props.selected_filters_title_text}</h4></div> : ''}
                            <div className="ags-wc-filters-selected-body">
                                <div className="ags-wc-filters-selected">
                                    <p className="ags-wc-filters-selected-inner" data-filter="preview:1">
                                        <span className="ags-wc-filters-remove">x&nbsp;</span>
                                        {window.wp.i18n.__('Filter One', 'divi-shop-builder')}
                                    </p>
                                    <p className="ags-wc-filters-selected-inner" data-filter="preview:2">
                                        <span className="ags-wc-filters-remove">x&nbsp;</span>
                                        {window.wp.i18n.__('Filter Two', 'divi-shop-builder')}
                                    </p>
                                </div>
                                {this.props.clear_all_filters_button === 'selected_filters' && <button className="ags-wc-filters-button ags-wc-filters-button-clear et_pb_button">{this.props.clear_all_filters_button_text}</button>}
                            </div>
                        </div>
                    </div>;

        return (
            <div className={('ags-wc-filters-' + (this.props.layout === 'horizontal' ? 'row' + (this.props.floating === 'on' ? ' ags-wc-filters-floating' : '') : 'sidebar'))} data-no-options-text={this.props.no_options_text}>

                {(this.props.clear_all_filters_button === 'top' || this.props.apply_filters_button === 'top') &&
                    <div className="ags-wc-filters-buttons">
                        {this.props.clear_all_filters_button === 'top' && <button className="ags-wc-filters-button ags-wc-filters-button-clear et_pb_button">{this.props.clear_all_filters_button_text}</button>}
                        {this.props.apply_filters_button === 'top' && <button className="ags-wc-filters-button ags-wc-filters-button-apply et_pb_button">{this.props.apply_filters_button_text}</button>}
                    </div>
                }

                {this.props.selected_filters === 'top' && selectedFilters}

                <div className="ags-wc-filters-sections">{this.props.content}</div>
                {(this.props.layout === 'horizontal' && (this.props.clear_all_filters_button !== 'bottom' && this.props.apply_filters_button !== 'bottom') && <div className="ags-wc-filters-break"></div>)}

                {(this.props.selected_filters === 'bottom' && this.props.layout !== 'horizontal') && selectedFilters}

                {(this.props.clear_all_filters_button === 'bottom' || this.props.apply_filters_button === 'bottom') &&
                    <div className="ags-wc-filters-buttons">
                        {this.props.clear_all_filters_button === 'bottom' && <button className="ags-wc-filters-button ags-wc-filters-button-clear et_pb_button">{this.props.clear_all_filters_button_text}</button>}
                        {this.props.apply_filters_button === 'bottom' && <button className="ags-wc-filters-button ags-wc-filters-button-apply et_pb_button">{this.props.apply_filters_button_text}</button>}
                    </div>
                }
                {(this.props.layout === 'horizontal' && (this.props.clear_all_filters_button !== 'bottom' || this.props.apply_filters_button !== 'bottom') && <div className="ags-wc-filters-break"></div>)}


                {(this.props.selected_filters === 'bottom' && this.props.layout === 'horizontal') && selectedFilters}

            </div>
        );
    }

}

export default DSWCP_WooProductsFilters;
