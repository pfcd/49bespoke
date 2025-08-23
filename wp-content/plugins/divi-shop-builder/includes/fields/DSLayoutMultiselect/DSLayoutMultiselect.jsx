// External Dependencies
import React, { Component } from 'react';
// Internal Dependencies

import './style.scss';

class DSLayoutMultiselect extends React.Component {
    static slug = 'DSLayoutMultiselect';

    constructor() {
        super();

        this.state = {
            activeOption: [],
        };

        this._onChange = this._onChange.bind(this);
        this.switchButton = this.switchButton.bind(this);
        this.getProcessedValue = this.getProcessedValue.bind(this);
    }

    shouldComponentUpdate(newProps, newState) {
        return this.state.activeOption.join('|') !== newState.activeOption.join('|') || this.props.activeTabMode !== newProps.activeTabMode;
    }

    componentDidMount() {
        this.setState({
            activeOption: this.getProcessedValue(),
        });
    }

    componentDidUpdate() {
        this.setState({
            activeOption: this.getProcessedValue(),
        });
    }

    getProcessedValue() {
        const value = this.props.value || this.props.default;

        if (typeof value === 'undefined' || '' === value) {
            return [];
        }

        // Support toggleable, multi selection, on tablet and phone. Convert 'none' value as empty
        // array because it has been modified on mobile.
        if (this.props.emptyMobileNone && 'none' === value) {
            return [];
        }

        return value.split('|');
    }

    switchButton(event) {
        event.preventDefault();

        const $clickedButton = window.jQuery(event.target).closest('.et-fb-multiple-buttons-toggle');
        const clickedButtonVal = $clickedButton.data('option_value');
        let newProcessedValue = this.state.activeOption;

        // support multi selection
        if (this.props.toggleable && this.state.activeOption.indexOf(clickedButtonVal) !== -1) {
            if (this.props.multi_selection) {
                newProcessedValue = newProcessedValue.filter( (item) => {
                    return item !== clickedButtonVal;
                } ).join('|');
            } else {
                newProcessedValue = this.props.default;
            }
        } else {
            // support multi selection
            if (this.props.multi_selection) {
                newProcessedValue.push(clickedButtonVal);
            }
            newProcessedValue = this.props.multi_selection ? newProcessedValue.join('|') : clickedButtonVal;
        }

        // Support toggleable, multi selection, on tablet and phone. Set empty value as 'none' to ensure
        // this value can be used as a flag to tell VB if current option has been modified on mobile.
        if (this.props.emptyMobileNone && '' === newProcessedValue) {
            newProcessedValue = 'none';
        }

        this._onChange(newProcessedValue);
    }

    _onChange(newValue) {
        const {name, _onChange} = this.props;

        let activeOption = newValue;

        // Support toggleable, multi selection, on tablet and phone. Convert 'none' value as empty
        // string because it has been modified on mobile.
        if (this.props.emptyMobileNone && 'none' === newValue) {
            activeOption = '';
        }
        this.setState({
            activeOption: ( typeof activeOption === 'string' ? activeOption : activeOption.toString() ).split('|'),
        });

        _onChange(name, newValue);
    }

    render() {
        const thisClass = this;
        const optionsSet = thisClass.props.fieldDefinition.options;
        const customClass = thisClass.props.fieldDefinition.customClass ?  thisClass.props.fieldDefinition.customClass : '';
        const buttonsOutput = Object.entries(optionsSet).map(function (entry) {

            const optionData = entry[1];
            const optionValue = entry[0];
            const isActiveButton = thisClass.state.activeOption.indexOf(optionValue) !== -1;

            const buttonClasses = 'et-fb-multiple-buttons-toggle-internal' + (isActiveButton ? ' et-fb-multiple-buttons-toggle-internal__active' : '') ;

			const buttonAttrs = {
				className: buttonClasses
			};

			if (optionData.iconSvg) {
				buttonAttrs.dangerouslySetInnerHTML = {
					__html: optionData.iconSvg
				};
			}

            return React.createElement(
                'li',
                {
                    className: "et-fb-multiple-buttons-toggle",
                    'data-tooltip': optionData.title,
                    'data-option_value': optionValue,
                    onClick: thisClass.switchButton,
                    key: optionValue
                },
                React.createElement(
                    'span',
                    buttonAttrs,
					optionData.iconPng
						? React.createElement(
							'img',
							{
								src: optionData.iconPng,
								alt: optionData.title
							}
						)
						: null
                )
            )

        });

        return React.createElement(
            'div',
            {
                className: "et-fb-multiple-buttons-outer " +  customClass
            },
            React.createElement(
                'ul',
                {
                    className: "et-fb-multiple-buttons-container"
                },
                buttonsOutput
            )
        );
    }
}

export default DSLayoutMultiselect;