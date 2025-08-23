// External Dependencies
import React, { Component } from 'react';

class WPZParentSettingReflector extends Component {

  static slug = 'WPZParentSettingReflector';
  
  constructor(props) {
	  super(props);
	  this.props._onChange(
		this.props.name,
		this.props.parentModuleSettings[this.props.fieldDefinition.source]
	  )
  }

  render() {
	  return this.props.fieldDefinition.message && this.props.fieldDefinition.message[ this.props.parentModuleSettings[this.props.fieldDefinition.source] ]
		? <p className="ds-parent-setting-reflector-message">{this.props.fieldDefinition.message[ this.props.parentModuleSettings[this.props.fieldDefinition.source] ]}</p>
		: null;
  }
}

export default WPZParentSettingReflector;
