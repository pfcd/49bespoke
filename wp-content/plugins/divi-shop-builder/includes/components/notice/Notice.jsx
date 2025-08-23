import React, { Component }from 'react';
import $ from 'jquery';

import './style.scss';

class Notice extends Component {


    componentDidMount(){
        window.et_pb_smooth_scroll( $('body'), false, 650 );
    }

    render(){

        return (
            <div className="et-fb-component-error">
                <h4 className="et-fb-component-error__heading">{this.props.heading}</h4>
                <div className="et-fb-error-container">{this.props.content}</div>
                { this.props.actions.length &&
                    <div className="et-fb-component-error__button-wrapper">
                        { this.props.actions.map( ( action, i ) =>
                            <button className="et-fb-button et-fb-component-error__button" key={i}
                                onClick={action.callback ? action.callback : (e) => e.preventDefault() }>
                                { action.label ? action.label : ''  }
                            </button>
                        ) }
                    </div>
                }
            </div>
        )

    }

}

export default Notice;