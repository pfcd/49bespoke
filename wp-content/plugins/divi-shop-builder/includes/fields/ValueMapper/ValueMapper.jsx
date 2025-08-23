/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JSX file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JSX file) was last modified 2020-11-25
*/

// External Dependencies
import React, { Component } from 'react';
import get from 'lodash/get';

// Internal Dependencies
import './style.css';

class DSWC_Value_Mapper extends Component {

  static slug = 'ags_divi_wc_value_mapper';
  
  maybeUpdateValue() {
	  
	let sourceField = get(this.props.fieldDefinition, 'sourceField', null);
	let valueMap = get(this.props.fieldDefinition, 'valueMap', null);
	
	if (sourceField !== null && valueMap !== null) {
		
		let sourceFieldValue = get(this.props.moduleSettings, sourceField, null);
		let value = sourceFieldValue === null ? '' : get(valueMap, sourceFieldValue, '');
		
		if (value !== this.props.value) {
			this.props._onChange(this.props.name, value);
		}
		
	}
  }
  
  shouldComponentUpdate() {
	  return true;
  }
  
  componentDidMount() {
	  this.maybeUpdateValue();
  }
  
  componentDidUpdate() {
	  this.maybeUpdateValue();
  }

  render() {
    return '';
  }
}

export default DSWC_Value_Mapper;
