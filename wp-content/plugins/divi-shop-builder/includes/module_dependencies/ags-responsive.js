export function apply_responsive(props, key, selector, css_prop_key = 'padding', important = false) {
    let additionalCss = [];
    if (!props[key]) {
        return;
    }
    let importantValue = important ? '!important' : '';
    let desktop = props[key];
    const isLastEdit = props[key + "_last_edited"];
    const statusActive = isLastEdit && isLastEdit.startsWith("on");

    switch (css_prop_key) {
        case 'padding':
        case 'margin' :
		
			function getDeclaration (value) {
				value = value.split("|");
				var sides = ['top', 'right', 'bottom', 'left'];
				var declaration = [];
				for (var i = 0; i < sides.length; ++i) {
					if (value[i]) {
						declaration.push( css_prop_key + '-' + sides[i] + ': ' + value[i] + importantValue );
					}
				}
				return declaration.length ? declaration.join('; ') + ';' : '';
			}
			
            additionalCss.push([{
                selector,
                declaration: getDeclaration(props[key])
            }]);

            if (props[key + "_tablet"] && statusActive) {
                additionalCss.push([{
                    selector,
                    declaration: getDeclaration(props[key + "_tablet"]),
                    'device': 'tablet',
                }]);
            }
            if (props[key + "_phone"] && statusActive) {
                additionalCss.push([{
                    selector,
                    declaration: getDeclaration(props[key + "_phone"]),
                    'device': 'phone',
                }]);
            }
            return additionalCss;

        default:
            additionalCss.push([{
                selector,
                declaration: css_prop_key + ':' + props[key] + importantValue,
            }]);

            if (props[key + "_tablet"] && statusActive) {
                additionalCss.push([{
                    selector,
                    declaration: css_prop_key + ':' + props[key + "_tablet"] + importantValue,
                    device: 'tablet'
                }]);
            }
            if (props[key + "_phone"] && statusActive) {
                additionalCss.push([{
                    selector,
                    declaration: css_prop_key + ':' + props[key + "_phone"] + importantValue,
                    device: 'phone'
                }]);
            }
            return additionalCss;
    }

};
