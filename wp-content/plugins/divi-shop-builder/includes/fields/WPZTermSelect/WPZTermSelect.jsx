/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.

Based on: divi-shop-builder\includes\fields\ValueMapper\ValueMapper.jsx
*/

// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import './style.scss';

class DSWC_Value_Mapper extends Component {
  
  static slug = 'WPZTermSelect';
  searchTimeout;
  
  constructor(props) {
	  super(props);
	  this.state = {
		value: [],
		displayValues: [],
		termSearch: '',
		showTermSuggestions: false,
		termSuggestionsLoading: true,
		termSuggestions: []
	  };
	  
	  if (props.value) {
		  
		  this.getTermsDisplay(props.value.split(',')).done( (terms) => {
			var value = [];
			var displayValues = [];
			for (var i = 0; i < terms.length; ++i) {
				value.push(terms[i].id);
				displayValues.push(terms[i].name);
			}
			this.setState({
				value: value,
				displayValues: displayValues
			});
		  } );
	  }
	  
	  this.getSuggestions();
  }
  
  getSuggestions(search) {
	  if (this.searchTimeout) {
		  clearTimeout(this.searchTimeout);
	  }
	  
	  this.searchTimeout = setTimeout(() => {
		 this.searchTimeout = null;
		 window.jQuery.get(
			window.DiviWoocommercePagesBuilderData.rest_base
					+ 'products/' + (this.props.fieldDefinition.attribute_field ? 'attributes/' + parseInt(this.props.moduleSettings[this.props.fieldDefinition.attribute_field]) + '/terms' : 'tags')
					+ '?_wpnonce=' + encodeURIComponent(window.DiviWoocommercePagesBuilderData.rest_nonce)
					+ (search ? '&search=' + encodeURIComponent(search) : '')
					+ this.state.value.map( (termId) => '&exclude[]=' + parseInt(termId) ),
			null,
			(response) => {
				this.setState({
					termSuggestions: response,
					termSuggestionsLoading: false
				});
			},
			'json'
		 );
	  }, 500);
  }
  
  selectTerm(term) {
	  var newValue = this.state.value.concat([term.id]);
	  if (this.props._onChange) {
		  this.props._onChange(this.props.name, newValue.join(','));
	  }
	  this.setState({
		 value: newValue,
		 displayValues: this.state.displayValues.concat([term.name]),
		 termSearch: '',
		 showTermSuggestions: false
	  });
  }
  
  unselectTerm(termId) {
	  var termIndex = this.state.value.indexOf(termId);
	  if (termIndex !== -1) {
		  var newValue = this.state.value.toSpliced(termIndex, 1);
		  if (this.props._onChange) {
			  this.props._onChange(this.props.name, newValue.join(','));
		  }
		  this.setState({
			  value: newValue,
			  displayValues: this.state.displayValues.toSpliced(termIndex, 1)
		  });
	  }
  }
  
  getTermsDisplay(termIds) {
	   return window.jQuery.get(
			window.DiviWoocommercePagesBuilderData.rest_base
					+ 'products/' + (this.props.fieldDefinition.attribute_field ? 'attributes/' + parseInt(this.props.moduleSettings[this.props.fieldDefinition.attribute_field]) + '/terms' : 'tags')
					+ '?_wpnonce=' + encodeURIComponent(window.DiviWoocommercePagesBuilderData.rest_nonce)
					+ '&per_page=' + termIds.length
					+ termIds.map( (termId) => '&include[]=' + parseInt(termId) ),
			null,
			null,
			'json'
		 );
  }
  
  componentDidUpdate(oldProps) {
	  if (this.props.fieldDefinition.attribute_field && this.props.moduleSettings[this.props.fieldDefinition.attribute_field] !== oldProps.moduleSettings[this.props.fieldDefinition.attribute_field]) {
		  this.setState({
				value: [],
				displayValues: [],
				termSearch: '',
				termSuggestions: [],
				termSuggestionsLoading: true
		  });
		  this.getSuggestions();
	  }
  }
  
  render() {
    return <div className="wpz-term-select">
		<ul className="wpz-term-select-selection" key="selection">
			{ this.state.value.map( (termId, termIndex) => <li key={'t' + termId}><span>{this.state.displayValues[termIndex]}</span><a href="#" onClick={(ev) => {ev.preventDefault(); this.unselectTerm(termId);}}>{window.wp.i18n.__('Remove', 'divi-shop-builder')}</a></li>) }
		</ul>
		<input type="text" className="wpz-term-select-search" placeholder="Search..." value={this.state.termSearch} onChange={(ev) => { this.setState({termSearch: ev.target.value}); this.getSuggestions(ev.target.value); }} onFocus={() => this.setState({showTermSuggestions: true})}  onBlur={() => setTimeout(() => this.setState({showTermSuggestions: false}), 250)} key="search-input" />
		{
			this.state.showTermSuggestions && <ul className="wpz-term-select-search-suggestions" key="search-suggestions">
				{ this.state.termSuggestions.length
						? this.state.termSuggestions.map( (term) => <li key={'t' + term.id}><a href="#" onClick={(ev) => {ev.preventDefault(); this.selectTerm(term);}}>{term.name}</a></li>)
						: (this.state.termSuggestionsLoading ? <li className="wpz-term-select-loading">{window.wp.i18n.__('Loading...', 'divi-shop-builder')}</li> : <li className="wpz-term-select-none">{window.wp.i18n.__('No results.', 'divi-shop-builder')}</li>)
				}
			</ul>
		}
	</div>;
  }
}

export default DSWC_Value_Mapper;
