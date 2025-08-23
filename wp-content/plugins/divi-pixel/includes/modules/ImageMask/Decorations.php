<?php 
class DIPI_SVG_Decorations {
  private static $layerID = 0;
  private function getLayerId($prefix = 'SVG_'){
      self::$layerID++;
      return $prefix . self::$layerID;
  }

  public function decoration($name, $className, $horizontal_position, $vertical_position, $scale, $rotate ){
      switch($name) {
          case 'DottedSquare':
              return $this->_DottedSquare($className, $horizontal_position, $vertical_position, $scale, $rotate);
            break;
          case 'DottedCircle':
              return $this->_DottedCircle($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'DottedTraingle':
              return $this->_DottedTraingle($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'DottedShape':
              return $this->_DottedShape($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'StrokeTriangle':
              return $this->_StrokeTriangle($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'StrokeCircle':
              return $this->_StrokeCircle($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'StrokeSquare':
              return $this->_StrokeSquare($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'AbstractSquare':
              return $this->_AbstractSquare($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'AbstractCircle':
              return $this->_AbstractCircle($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'FilledCircle':
              return $this->_FilledCircle($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'FilledSquare':
              return $this->_FilledSquare($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'FilledTriangle':
              return $this->_FilledTriangle($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'LinedSquare':
              return $this->_LinedSquare($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'LinedCircle':
              return $this->_LinedCircle($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          case 'LinedTriangle':
              return $this->_LinedTriangle($className, $horizontal_position, $vertical_position, $scale, $rotate);
              break;
          default:
              return $this->_DottedSquare($className, $horizontal_position, $vertical_position, $scale, $rotate);
        }
  }
  
  private function _DottedSquare ($className, $horizontal_position, $vertical_position, $scale, $rotate) {
      $pattern_swatch_id = self::getLayerId('PATTERN_SWATCH_');
      $pattern_id = self::getLayerId('PATTERN_');
      return sprintf('
              <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg);transform-origin: center">
                <pattern width="28.2" height="28.2" patternUnits="userSpaceOnUse" id="%6$s" viewBox="0 -28.2 28.2 28.2" style="overflow: visible">
                  <g>
                    <rect y="-28.2" style="fill: none" width="28.2" height="28.2"/>
                    <circle class="%1$s"  cx="14.1" cy="-14.1" r="3.1"/>
                  </g>
                </pattern>
                <pattern  id="%7$s" xlink:href="#%6$s" patternTransform="matrix(1.0282 0 0 1.0282 194.9482 211.1005)">
                </pattern>
                <rect x="18.4" y="10.7" style="fill: url(#%7$s)" width="463.1" height="475.3" />
              </g>',
              $className,           // 1
              $horizontal_position, // 2
              $vertical_position,   // 3
              $scale,               // 4
              $rotate,              // 5
              $pattern_swatch_id,    // 6
              $pattern_id           // 7
      );
  }

  private function _DottedCircle($className, $horizontal_position, $vertical_position, $scale, $rotate){
      $pattern_swatch_id = self::getLayerId('PATTERN_SWATCH_');
      $pattern_id = self::getLayerId('PATTERN_');
      return sprintf('
          <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg); transform-origin: center">
            <pattern  width="31.2" height="31.2" patternUnits="userSpaceOnUse" id="%6$s" viewBox="0 -31.2 31.2 31.2" style="overflow: visible">
                <g>
                    <rect y="-31.2" style="fill: none" width="31.2" height="31.2"/>
                    <circle class="%1$s" cx="15.6" cy="-15.6" r="3.1"/>
                </g>
            </pattern>
            <circle style="fill: url(#%6$s)" cx="251.4" cy="252.2" r="238"/>
        
          </g>',
          $className,
          $horizontal_position,
          $vertical_position,
          $scale, 
          $rotate,
          $pattern_swatch_id,
          $pattern_id);
  }
  
  private function _DottedTraingle($className, $horizontal_position, $vertical_position, $scale, $rotate){
      $SVG1 = self::getLayerId('PATTERN_SWATCH_');
      $SVG2 = self::getLayerId('PATTERN_');
      return sprintf('
          <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg); transform-origin: center">
            <defs>
            <polygon id="%6$s" points="250.3,30.9 371.6,241 492.9,451.1 250.3,451.1 7.7,451.1 129,241 			"/>
            </defs>
            <clipPath id="%7$s">
              <use xlink:href="#%6$s" style="overflow: visible"/>
            </clipPath>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="476.7" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="476.7" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="493.2" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="443.6" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="443.6" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="460.1" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="410.5" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="410.5" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="427" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="377.4" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="377.4" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="394" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="344.4" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="344.4" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="360.9" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="311.3" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="311.3" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="327.8" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="278.2" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="278.2" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="294.8" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="245.1" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="245.1" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="261.7" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="212.1" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="212.1" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="228.6" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="179" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="179" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="195.5" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="145.9" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="145.9" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="162.5" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="112.8" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="112.8" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="129.4" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="79.8" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="79.8" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="96.3" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="46.7" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="46.7" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="63.2" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="13.6" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="13.6" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="30.2" cy="449.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="3.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="3.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="20" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="36.5" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="36.5" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="53" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="69.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="69.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="86.1" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="102.6" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="102.6" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="119.2" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="135.7" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="135.7" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="152.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="168.8" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="168.8" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="185.3" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="201.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="201.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="218.4" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="234.9" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="234.9" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="251.5" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="268" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="268" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="284.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="301.1" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="301.1" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="317.6" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="334.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="334.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="350.7" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="367.2" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="367.2" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="383.8" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="400.3" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="400.3" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="416.9" r="3.3"/>
              </g>
            </g>
            <g style="clip-path: url(#%7$s)">
              <rect x="-19.5" y="433.4" style="fill: none" width="33.1" height="33.1"/>
              <g>
                <rect x="-19.5" y="433.4" style="fill: none" width="33.1" height="33.1"/>
                <circle class="%1$s" cx="-2.9" cy="449.9" r="3.3"/>
              </g>
            </g>
          </g>',
          $className,
          $horizontal_position,
          $vertical_position,
          $scale,
            $rotate,
          $SVG1,
          $SVG2);
  }

  private function _DottedShape($className, $horizontal_position, $vertical_position, $scale, $rotate){
    $SVG1 = self::getLayerId('SVG_');
    $SVG2 = self::getLayerId('SVG_');
    return sprintf('
        <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg); transform-origin: center">
          <defs>
              <path id="%6$s" d="M37.8,19.4C78.1-11.3,143.7,17,265.1,69.5c139,60.1,212.1,91.7,223.1,155.9
              c15.5,90.5-104.1,175.3-139.2,200.3c-47.6,33.8-121.2,86-190.4,61.5c-66.4-23.6-89.4-104-116.5-198.8
              C18.5,205.9-21.8,65,37.8,19.4z"/>
          </defs>
          <clipPath id="%7$s">
              <use xlink:href="#%6$s" style="overflow:visible"/>
          </clipPath>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468"   y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="468" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="468" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="483.6" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="436.8" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="436.8" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="452.4" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="405.6" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="405.6" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="421.2" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="374.4" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="374.4" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="390" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="343.2" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="343.2" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="358.8" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="312" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="312" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="327.6" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="280.8" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="280.8" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="296.4" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="249.6" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="249.6" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="265.2" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="218.4" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="218.4" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="234" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="187.2" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="187.2" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="202.8" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="156" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="156" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="171.6" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="124.8" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="124.8" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="140.4" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="93.6" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="93.6" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="109.2" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="62.4" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="62.4" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="78" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect x="31.2" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect x="31.2" y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="46.8" cy="484.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="0.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="16.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="32" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="32" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="47.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="63.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="78.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="94.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="110" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="125.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="141.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="156.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="172.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="188" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="188" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="203.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="219.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="234.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="250.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="266" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="281.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="297.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="312.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="328.4" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="344" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="344" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="359.6" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="375.2" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="390.8" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="406.4" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="422" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="437.6" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="453.2" r="3.1"/>
              </g>
          </g>
          <g style="clip-path: url(#%7$s)">
              <rect y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <g>
              <rect y="468.8" style="fill:none" width="31.2" height="31.2"/>
              <circle class="%1$s" cx="15.6" cy="484.4" r="3.1"/>
              </g>
          </g>
        </g>',
        $className,
        $horizontal_position,
        $vertical_position,
        $scale, $rotate,
        $SVG1,
        $SVG2);
  }

    private function _StrokeTriangle ($className, $horizontal_position, $vertical_position, $scale, $rotate) {
      $pattern_swatch_id = self::getLayerId('PATTERN_SWATCH_');
      $pattern_id = self::getLayerId('PATTERN_');
      return sprintf('
              <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg);transform-origin: center">
                <path class="%1$s"  d="M482.9,446.8H14.5L248.7,41.2L482.9,446.8z M101.1,396.8h295.1L248.7,141.2L101.1,396.8z"/>
              </g>',
              $className,           // 1
              $horizontal_position, // 2
              $vertical_position,   // 3
              $scale,               // 4
              $rotate,              // 5
              $pattern_swatch_id,    // 6
              $pattern_id           // 7
      );
  }

  private function _StrokeCircle ($className, $horizontal_position, $vertical_position, $scale, $rotate) {
    $pattern_swatch_id = self::getLayerId('PATTERN_SWATCH_');
    $pattern_id = self::getLayerId('PATTERN_');
    return sprintf('
            <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg);transform-origin: center">
              <path class="%1$s" d="M250.4,484.7c-62.2,0-120.6-24.2-164.6-68.2c-44-44-68.2-102.4-68.2-164.6c0-62.2,24.2-120.6,68.2-164.6
                c44-44,102.4-68.2,164.6-68.2c62.2,0,120.6,24.2,164.6,68.2c44,44,68.2,102.4,68.2,164.6c0,62.2-24.2,120.6-68.2,164.6
                C371.1,460.4,312.6,484.7,250.4,484.7z M250.4,69.1c-100.8,0-182.8,82-182.8,182.8c0,100.8,82,182.8,182.8,182.8
                s182.8-82,182.8-182.8C433.2,151.1,351.2,69.1,250.4,69.1z"/>
            </g>',
            $className,           // 1
            $horizontal_position, // 2
            $vertical_position,   // 3
            $scale,               // 4
            $rotate,              // 5
            $pattern_swatch_id,    // 6
            $pattern_id           // 7
    );
  }

  private function _StrokeSquare ($className, $horizontal_position, $vertical_position, $scale, $rotate) {
    $pattern_swatch_id = self::getLayerId('PATTERN_SWATCH_');
    $pattern_id = self::getLayerId('PATTERN_');
    return sprintf('
            <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg);transform-origin: center">
              <path class="%1$s" d="M483.9,487.3H14.3V17.7h469.6V487.3z M64.3,437.3h369.6V67.7H64.3V437.3z" />
            </g>',
            $className,           // 1
            $horizontal_position, // 2
            $vertical_position,   // 3
            $scale,               // 4
            $rotate,              // 5
            $pattern_swatch_id,    // 6
            $pattern_id           // 7
    );
  }

  private function _FilledCircle ($className, $horizontal_position, $vertical_position, $scale, $rotate) {
    $pattern_swatch_id = self::getLayerId('PATTERN_SWATCH_');
    $pattern_id = self::getLayerId('PATTERN_');
    return sprintf('
            <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg);transform-origin: center">
              <circle class="%1$s" cx="248.5" cy="249.9" r="237.7"/>
            </g>',
            $className,           // 1
            $horizontal_position, // 2
            $vertical_position,   // 3
            $scale,               // 4
            $rotate,              // 5
            $pattern_swatch_id,    // 6
            $pattern_id           // 7
    );
  }

  private function _FilledSquare ($className, $horizontal_position, $vertical_position, $scale, $rotate) {
    $pattern_swatch_id = self::getLayerId('PATTERN_SWATCH_');
    $pattern_id = self::getLayerId('PATTERN_');
    return sprintf('
            <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg);transform-origin: center">
              <rect class="%1$s" x="28" y="30" width="444.9" height="444.9"/>
            </g>',
            $className,           // 1
            $horizontal_position, // 2
            $vertical_position,   // 3
            $scale,               // 4
            $rotate,              // 5
            $pattern_swatch_id,    // 6
            $pattern_id           // 7
    );
  }

  private function _FilledTriangle ($className, $horizontal_position, $vertical_position, $scale, $rotate) {
    $pattern_swatch_id = self::getLayerId('PATTERN_SWATCH_');
    $pattern_id = self::getLayerId('PATTERN_');
    return sprintf('
            <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg);transform-origin: center">
              <polygon class="%1$s" points="250,35.3 368.4,240.5 486.8,445.6 250,445.6 13.1,445.6 131.6,240.5 "/>
            </g>',
            $className,           // 1
            $horizontal_position, // 2
            $vertical_position,   // 3
            $scale,               // 4
            $rotate,              // 5
            $pattern_swatch_id,    // 6
            $pattern_id           // 7
    );
  }

  private function _AbstractSquare ($className, $horizontal_position, $vertical_position, $scale, $rotate) {
    $SVG1 = self::getLayerId('SVG_');
    $SVG2 = self::getLayerId('SVG_');
    return sprintf('
            <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg);transform-origin: center">
              <defs>
              <rect id="%6$s" x="16" y="15.3" width="466.3" height="466.3"/>
              </defs>
              <clipPath id="%7$s">
                <use xlink:href="#%6$s"  style="overflow: visible"/>
              </clipPath>
              <g style="clip-path: url(#%7$s)" class="%1$s">
                <path d="M838.9,198.9c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L900,198.5c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L840,198.5
                  C839.7,198.8,839.3,198.9,838.9,198.9z"/>
                <path d="M838.9,155.5c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L900,155.1c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L840,155.1
                  C839.7,155.4,839.3,155.5,838.9,155.5z"/>
                <path d="M838.9,112.1c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L900,111.7c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L840,111.7C839.7,112,839.3,112.1,838.9,112.1z
                  "/>
                <path d="M838.9,68.7c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0L538.7,65l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0L598.8,65l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0L658.8,65l28.9-28.9
                  c0.6-0.6,1.6-0.6,2.2,0L718.8,65l29-28.9c0.6-0.6,1.6-0.6,2.2,0L778.9,65l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0L838.9,65l28.9-28.9
                  c0.6-0.6,1.6-0.6,2.2,0L898.9,65l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9L900,68.3c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L840,68.3C839.7,68.6,839.3,68.7,838.9,68.7z"/>
                <path d="M838.9,25.3c-0.4,0-0.8-0.2-1.1-0.5L808.9-4l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L748.9-4l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0L688.8-4l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L628.8-4l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L568.8-4
                  l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L508.8-4l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L928.9-4L900,24.9c-0.6,0.6-1.6,0.6-2.2,0L868.9-4L840,24.9C839.7,25.2,839.3,25.3,838.9,25.3z"/>
        
                  <path class="st2" d="M838.9,415.9c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L900,415.5c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L840,415.5
                  C839.7,415.8,839.3,415.9,838.9,415.9z"/>
                <path class="st2" d="M838.9,372.5c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L900,372.1c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L840,372.1
                  C839.7,372.4,839.3,372.5,838.9,372.5z"/>
                <path class="st2" d="M838.9,329.1c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L900,328.7c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L840,328.7C839.7,329,839.3,329.1,838.9,329.1z
                  "/>
                <path class="st2" d="M838.9,285.7c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L900,285.3c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L840,285.3
                  C839.7,285.6,839.3,285.7,838.9,285.7z"/>
                <path class="st2" d="M838.9,242.3c-0.4,0-0.8-0.2-1.1-0.5L808.9,213l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L748.9,213l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0L688.8,213l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L628.8,213l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L568.8,213
                  l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L508.8,213l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L928.9,213L900,241.9c-0.6,0.6-1.6,0.6-2.2,0L868.9,213L840,241.9C839.7,242.2,839.3,242.3,838.9,242.3z
                  "/>
        
                  <path class="st3" d="M838.9,632.9c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L900,632.5c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L840,632.5
                  C839.7,632.8,839.3,632.9,838.9,632.9z"/>
                <path class="st3" d="M838.9,589.5c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L900,589.1c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L840,589.1
                  C839.7,589.4,839.3,589.5,838.9,589.5z"/>
                <path class="st3" d="M838.9,546.1c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L900,545.7c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L840,545.7C839.7,546,839.3,546.1,838.9,546.1z
                  "/>
                <path class="st3" d="M838.9,502.7c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L900,502.3c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L840,502.3
                  C839.7,502.6,839.3,502.7,838.9,502.7z"/>
                <path class="st3" d="M838.9,459.3c-0.4,0-0.8-0.2-1.1-0.5L808.9,430l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L748.9,430l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0L688.8,430l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L628.8,430l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L568.8,430
                  l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L508.8,430l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L928.9,430L900,458.9c-0.6,0.6-1.6,0.6-2.2,0L868.9,430L840,458.9C839.7,459.2,839.3,459.3,838.9,459.3z
                  "/>
        
                  <path class="st4" d="M355.6,198.9c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C356.4,198.8,356,198.9,355.6,198.9z"/>
                <path class="st4" d="M355.6,155.5c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C356.4,155.4,356,155.5,355.6,155.5z"/>
                <path class="st4" d="M355.6,112.1c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L85.5,82.8
                  l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L25.5,82.8l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9C356.4,112,356,112.1,355.6,112.1z
                  "/>
                <path class="st4" d="M355.6,68.7c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L85.5,39.4
                  L56.6,68.3c-0.6,0.6-1.6,0.6-2.2,0L25.5,39.4L-3.4,68.3c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0L55.5,65l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0L115.5,65l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0L175.5,65l28.9-28.9
                  c0.6-0.6,1.6-0.6,2.2,0L235.6,65l29-28.9c0.6-0.6,1.6-0.6,2.2,0L295.6,65l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0L355.6,65l28.9-28.9
                  c0.6-0.6,1.6-0.6,2.2,0L415.7,65l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9C356.4,68.6,356,68.7,355.6,68.7z"/>
                <path class="st4" d="M355.6,25.3c-0.4,0-0.8-0.2-1.1-0.5L325.7-4l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L265.6-4l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0L205.6-4l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L145.5-4l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L85.5-4
                  L56.6,24.9c-0.6,0.6-1.6,0.6-2.2,0L25.5-4L-3.4,24.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9L84.4-7.3c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L445.7-4l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L385.7-4l-28.9,28.9C356.4,25.2,356,25.3,355.6,25.3z"/>
        
                  <path class="st5" d="M355.6,415.9c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C356.4,415.8,356,415.9,355.6,415.9z"/>
                <path class="st5" d="M355.6,372.5c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C356.4,372.4,356,372.5,355.6,372.5z"/>
                <path class="st5" d="M355.6,329.1c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9C356.4,329,356,329.1,355.6,329.1z
                  "/>
                <path class="st5" d="M355.6,285.7c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0L55.5,282l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C356.4,285.6,356,285.7,355.6,285.7z"/>
                <path class="st5" d="M355.6,242.3c-0.4,0-0.8-0.2-1.1-0.5L325.7,213l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L265.6,213l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0L205.6,213l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L145.5,213l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L85.5,213
                  l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L25.5,213l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L445.7,213l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L385.7,213l-28.9,28.9C356.4,242.2,356,242.3,355.6,242.3z
                  "/>
        
                  <path class="st6" d="M355.6,632.9c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C356.4,632.8,356,632.9,355.6,632.9z"/>
                <path class="st6" d="M355.6,589.5c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C356.4,589.4,356,589.5,355.6,589.5z"/>
                <path class="st6" d="M355.6,546.1c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9C356.4,546,356,546.1,355.6,546.1z
                  "/>
                <path class="st6" d="M355.6,502.7c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0L55.5,499l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C356.4,502.6,356,502.7,355.6,502.7z"/>
                <path class="st6" d="M355.6,459.3c-0.4,0-0.8-0.2-1.1-0.5L325.7,430l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L265.6,430l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0L205.6,430l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L145.5,430l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L85.5,430
                  l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L25.5,430l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L445.7,430l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L385.7,430l-28.9,28.9C356.4,459.2,356,459.3,355.6,459.3z
                  "/>
              </g>
        
            </g>',
            $className,           // 1
            $horizontal_position, // 2
            $vertical_position,   // 3
            $scale,               // 4
            $rotate,              // 5
            $SVG1,    // 6
            $SVG2           // 7
    );
  }

  private function _AbstractCircle ($className, $horizontal_position, $vertical_position, $scale, $rotate) {
    $SVG1 = self::getLayerId('SVG_');
    $SVG2 = self::getLayerId('SVG_');
    return sprintf('
            <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg);transform-origin: center">
              <defs>
              <circle id="%6$s" cx="248.5" cy="251.1" r="239.8"/>
              </defs>
              <clipPath id="%7$s">
                    <use xlink:href="#%6$s"  style="overflow: visible"/>
                  </clipPath>
              <g style="clip-path: url(#%7$s)" class="%1$s">
                <path d="M814.9,195.6c-0.4,0-0.8-0.2-1.1-0.5L785,166.3L756,195.1c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,166.3l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,166.3L816,195.1C815.7,195.4,815.3,195.6,814.9,195.6
                  z"/>
                <path d="M814.9,152.2c-0.4,0-0.8-0.2-1.1-0.5L785,122.9L756,151.7c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,122.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,122.9L816,151.7C815.7,152,815.3,152.2,814.9,152.2z"
                  />
                <path d="M814.9,108.8c-0.4,0-0.8-0.2-1.1-0.5L785,79.5L756,108.3c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,79.5l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,79.5L816,108.3C815.7,108.6,815.3,108.8,814.9,108.8z"
                  />
                <path d="M814.9,65.4c-0.4,0-0.8-0.2-1.1-0.5L785,36.1L756,64.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0L875,61.7l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,36.1l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,36.1L816,64.9C815.7,65.2,815.3,65.4,814.9,65.4z"/>
                <path d="M814.9,22c-0.4,0-0.8-0.2-1.1-0.5L785-7.4L756,21.5c-0.6,0.6-1.6,0.6-2.2,0L724.9-7.4l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0L664.9-7.3l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L604.8-7.4l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L544.8-7.4
                  l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L484.8-7.3l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0L875,18.2l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905-7.3l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845-7.4L816,21.5C815.7,21.8,815.3,22,814.9,22z"/>
              
                <path class="st2" d="M814.9,412.6c-0.4,0-0.8-0.2-1.1-0.5L785,383.3L756,412.2c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,383.3l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,383.3L816,412.2C815.7,412.5,815.3,412.6,814.9,412.6
                  z"/>
                <path class="st2" d="M814.9,369.2c-0.4,0-0.8-0.2-1.1-0.5L785,339.9L756,368.8c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,339.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,339.9L816,368.8C815.7,369.1,815.3,369.2,814.9,369.2
                  z"/>
                <path class="st2" d="M814.9,325.8c-0.4,0-0.8-0.2-1.1-0.5L785,296.5L756,325.3c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,296.5l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,296.5L816,325.3C815.7,325.7,815.3,325.8,814.9,325.8
                  z"/>
                <path class="st2" d="M814.9,282.4c-0.4,0-0.8-0.2-1.1-0.5L785,253.1L756,281.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,253.1l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,253.1L816,281.9C815.7,282.2,815.3,282.4,814.9,282.4
                  z"/>
                <path class="st2" d="M814.9,239c-0.4,0-0.8-0.2-1.1-0.5L785,209.7L756,238.5c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,209.7l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,209.7L816,238.5C815.7,238.8,815.3,239,814.9,239z"/>
        
                <path class="st3" d="M814.9,629.6c-0.4,0-0.8-0.2-1.1-0.5L785,600.3L756,629.2c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,600.3l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,600.3L816,629.2C815.7,629.5,815.3,629.6,814.9,629.6
                  z"/>
                <path class="st3" d="M814.9,586.2c-0.4,0-0.8-0.2-1.1-0.5L785,556.9L756,585.8c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,556.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,556.9L816,585.8C815.7,586.1,815.3,586.2,814.9,586.2
                  z"/>
                <path class="st3" d="M814.9,542.8c-0.4,0-0.8-0.2-1.1-0.5L785,513.5L756,542.4c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,513.5l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,513.5L816,542.4C815.7,542.7,815.3,542.8,814.9,542.8
                  z"/>
                <path class="st3" d="M814.9,499.4c-0.4,0-0.8-0.2-1.1-0.5L785,470.1L756,499c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L696,499
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L635.9,499c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L575.9,499c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9
                  L515.9,499c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L455.9,499c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,470.1L876.1,499c-0.6,0.6-1.6,0.6-2.2,0L845,470.1L816,499C815.7,499.3,815.3,499.4,814.9,499.4z"
                  />
                <path class="st3" d="M814.9,456c-0.4,0-0.8-0.2-1.1-0.5L785,426.7L756,455.6c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L905,426.7l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L845,426.7L816,455.6C815.7,455.9,815.3,456,814.9,456z"/>
        
                <path class="st4" d="M331.7,195.6c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,166.3l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9L60.5,163c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C332.5,195.4,332.1,195.6,331.7,195.6z"/>
                <path class="st4" d="M331.7,152.2c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,122.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C332.5,152,332.1,152.2,331.7,152.2z"/>
                <path class="st4" d="M331.7,108.8c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L61.6,79.5
                  l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,79.5l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C332.5,108.6,332.1,108.8,331.7,108.8z"/>
                <path class="st4" d="M331.7,65.4c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L92.7,64.9c-0.6,0.6-1.6,0.6-2.2,0L61.6,36.1
                  L32.6,64.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,36.1l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9C332.5,65.2,332.1,65.4,331.7,65.4
                  z"/>
                <path class="st4" d="M331.7,22c-0.4,0-0.8-0.2-1.1-0.5L301.7-7.4l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L241.7-7.4l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0L181.6-7.3l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L121.6-7.4L92.7,21.5c-0.6,0.6-1.6,0.6-2.2,0L61.6-7.4
                  L32.6,21.5c-0.6,0.6-1.6,0.6-2.2,0L1.6-7.3l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0L421.8-7.3l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L361.7-7.4l-28.9,28.9C332.5,21.8,332.1,22,331.7,22z"/>
        
                <path class="st5" d="M331.7,412.6c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,383.3l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9L60.5,380c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C332.5,412.5,332.1,412.6,331.7,412.6z"/>
                <path class="st5" d="M331.7,369.2c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,339.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C332.5,369.1,332.1,369.2,331.7,369.2z"/>
                <path class="st5" d="M331.7,325.8c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,296.5l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C332.5,325.7,332.1,325.8,331.7,325.8z"/>
                <path class="st5" d="M331.7,282.4c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,253.1l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C332.5,282.2,332.1,282.4,331.7,282.4z"/>
                <path class="st5" d="M331.7,239c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,209.7l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9C332.5,238.8,332.1,239,331.7,239z
                  "/>
        
                  <path class="st6" d="M331.7,629.6c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,600.3l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9L60.5,597c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C332.5,629.5,332.1,629.6,331.7,629.6z"/>
                <path class="st6" d="M331.7,586.2c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,556.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C332.5,586.1,332.1,586.2,331.7,586.2z"/>
                <path class="st6" d="M331.7,542.8c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,513.5l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9
                  C332.5,542.7,332.1,542.8,331.7,542.8z"/>
                <path class="st6" d="M331.7,499.4c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9L272.8,499c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L152.7,499c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L92.7,499c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9
                  L32.6,499c-0.6,0.6-1.6,0.6-2.2,0L1.6,470.1L-27.3,499c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L392.8,499c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9L332.8,499
                  C332.5,499.3,332.1,499.4,331.7,499.4z"/>
                <path class="st6" d="M331.7,456c-0.4,0-0.8-0.2-1.1-0.5l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-29,28.9
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0
                  l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0L1.6,426.7l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0c-0.6-0.6-0.6-1.6,0-2.2l30-30
                  c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9
                  l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l29-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0
                  l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l28.9,28.9l28.9-28.9c0.6-0.6,1.6-0.6,2.2,0l30,30c0.6,0.6,0.6,1.6,0,2.2
                  c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9c-0.6,0.6-1.6,0.6-2.2,0l-28.9-28.9l-28.9,28.9C332.5,455.9,332.1,456,331.7,456z
                  "/>
              </g>
     
            </g>',
            $className,           // 1
            $horizontal_position, // 2
            $vertical_position,   // 3
            $scale,               // 4
            $rotate,              // 5
            $SVG1,    // 6
            $SVG2           // 7
    );
  }

  private function _LinedSquare ($className, $horizontal_position, $vertical_position, $scale, $rotate) {
    $SVG1 = self::getLayerId('SVG_');
    $SVG2 = self::getLayerId('SVG_');
    return sprintf('
            <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg);transform-origin: center">
              <defs>
              <rect id="%6$s" x="20" y="10.7" width="460.2" height="460.2"/>
              </defs>
              <clipPath id="%7$s">
                <use xlink:href="#%6$s"  style="overflow: visible"/>
              </clipPath>
              <g class="%1$s" style="clip-path: url(#%7$s)">
                <g>
                  <rect x="425" y="138.4" width="423.7" height="3"/>
                  <rect x="425" y="105.4" width="423.7" height="3"/>
                  <rect x="425" y="72.4" width="423.7" height="3"/>
                  <rect x="425" y="39.4" width="423.7" height="3"/>
                  <rect x="425" y="6.4" width="423.7" height="3"/>
        
              <rect x="425" y="303.4" width="423.7" height="3"/>
                  <rect x="425" y="270.4" width="423.7" height="3"/>
                  <rect x="425" y="237.4" width="423.7" height="3"/>
                  <rect x="425" y="204.4" width="423.7" height="3"/>
                  <rect x="425" y="171.4" width="423.7" height="3"/>
        
              <rect x="425" y="468.4" width="423.7" height="3"/>
                  <rect x="425" y="435.4" width="423.7" height="3"/>
                  <rect x="425" y="402.4" width="423.7" height="3"/>
                  <rect x="425" y="369.4" width="423.7" height="3"/>
                  <rect x="425" y="336.4" width="423.7" height="3"/>
        
              <rect x="1.3" y="138.4" width="423.7" height="3"/>
                  <rect x="1.3" y="105.4" width="423.7" height="3"/>
                  <rect x="1.3" y="72.4" width="423.7" height="3"/>
                  <rect x="1.3" y="39.4" width="423.7" height="3"/>
                  <rect x="1.3" y="6.4" width="423.7" height="3"/>
        
              <rect x="1.3" y="303.4" width="423.7" height="3"/>
                  <rect x="1.3" y="270.4" width="423.7" height="3"/>
                  <rect x="1.3" y="237.4" width="423.7" height="3"/>
                  <rect x="1.3" y="204.4" width="423.7" height="3"/>
                  <rect x="1.3" y="171.4" width="423.7" height="3"/>
        
              <rect x="1.3" y="468.4" width="423.7" height="3"/>
                  <rect x="1.3" y="435.4" width="423.7" height="3"/>
                  <rect x="1.3" y="402.4" width="423.7" height="3"/>
                  <rect x="1.3" y="369.4" width="423.7" height="3"/>
                  <rect x="1.3" y="336.4" width="423.7" height="3"/>
                </g>
              </g>
            
            </g>',
            $className,           // 1
            $horizontal_position, // 2
            $vertical_position,   // 3
            $scale,               // 4
            $rotate,              // 5
            $SVG1,    // 6
            $SVG2          // 7
    );
  }

  private function _LinedCircle ($className, $horizontal_position, $vertical_position, $scale, $rotate) {
    $SVG1 = self::getLayerId('SVG_');
    $SVG2 = self::getLayerId('SVG_');
    return sprintf('
            <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg);transform-origin: center">
              <defs>
                <circle id="%6$s" cx="252.1" cy="249.5" r="232.8"/>
              </defs>
              <clipPath id="%7$s">
                <use xlink:href="#%6$s"  style="overflow: visible"/>
              </clipPath>
              <g style="clip-path: url(#%7$s)" class="%1$s">
                <rect x="408" y="135.3" class="st1" width="436.8" height="3.1"/>
                <rect x="408" y="101.2" class="st1" width="436.8" height="3.1"/>
                <rect x="408" y="67.2" class="st1" width="436.8" height="3.1"/>
                <rect x="408" y="33.2" class="st1" width="436.8" height="3.1"/>
                <rect x="408" y="-0.8" class="st1" width="436.8" height="3.1"/>
      
                <rect x="408" y="305.4" class="st2" width="436.8" height="3.1"/>
                <rect x="408" y="271.3" class="st2" width="436.8" height="3.1"/>
                <rect x="408" y="237.3" class="st2" width="436.8" height="3.1"/>
                <rect x="408" y="203.3" class="st2" width="436.8" height="3.1"/>
                <rect x="408" y="169.3" class="st2" width="436.8" height="3.1"/>
      
                <rect x="408" y="475.5" class="st3" width="436.8" height="3.1"/>
                <rect x="408" y="441.4" class="st3" width="436.8" height="3.1"/>
                <rect x="408" y="407.4" class="st3" width="436.8" height="3.1"/>
                <rect x="408" y="373.4" class="st3" width="436.8" height="3.1"/>
                <rect x="408" y="339.4" class="st3" width="436.8" height="3.1"/>
      
                <rect x="-28.7" y="135.3" class="st4" width="436.8" height="3.1"/>
                <rect x="-28.7" y="101.2" class="st4" width="436.8" height="3.1"/>
                <rect x="-28.7" y="67.2" class="st4" width="436.8" height="3.1"/>
                <rect x="-28.7" y="33.2" class="st4" width="436.8" height="3.1"/>
                <rect x="-28.7" y="-0.8" class="st4" width="436.8" height="3.1"/>
      
                <rect x="-28.7" y="305.4" class="st5" width="436.8" height="3.1"/>
                <rect x="-28.7" y="271.3" class="st5" width="436.8" height="3.1"/>
                <rect x="-28.7" y="237.3" class="st5" width="436.8" height="3.1"/>
                <rect x="-28.7" y="203.3" class="st5" width="436.8" height="3.1"/>
                <rect x="-28.7" y="169.3" class="st5" width="436.8" height="3.1"/>
      
                <rect x="-28.7" y="475.5" class="st6" width="436.8" height="3.1"/>
                <rect x="-28.7" y="441.4" class="st6" width="436.8" height="3.1"/>
                <rect x="-28.7" y="407.4" class="st6" width="436.8" height="3.1"/>
                <rect x="-28.7" y="373.4" class="st6" width="436.8" height="3.1"/>
                <rect x="-28.7" y="339.4" class="st6" width="436.8" height="3.1"/>
                
              </g>
      
            </g>',
            $className,           // 1
            $horizontal_position, // 2
            $vertical_position,   // 3
            $scale,               // 4
            $rotate,              // 5
            $SVG1,    // 6
            $SVG2           // 7
    );
  }

  private function _LinedTriangle ($className, $horizontal_position, $vertical_position, $scale, $rotate) {
    $SVG1 = self::getLayerId('SVG_');
    $SVG2 = self::getLayerId('SVG_');
    return sprintf('
            <g style="transform: translate(%2$s, %3$s) scale(%4$s) rotate(%5$sdeg);transform-origin: center">
              <defs>
                <polygon id="%6$s" points="251,39.6 371.3,247.9 491.6,456.2 251,456.2 10.5,456.2 130.8,247.9 			"/>
              </defs>
              <clipPath id="%7$s">
                <use xlink:href="#%6$s"  style="overflow: visible"/>
              </clipPath>
              <g style="clip-path: url(#%7$s)" class="%1$s">
                <rect x="198.3" y="141.6" width="308.3" height="2.2"/>
                <rect x="198.3" y="117.6" width="308.3" height="2.2"/>
                <rect x="198.3" y="93.6" width="308.3" height="2.2"/>
                <rect x="198.3" y="69.6" width="308.3" height="2.2"/>
                <rect x="198.3" y="45.6" width="308.3" height="2.2"/>
      
                <rect x="198.3" y="261.7" class="st2" width="308.3" height="2.2"/>
                <rect x="198.3" y="237.7" class="st2" width="308.3" height="2.2"/>
                <rect x="198.3" y="213.7" class="st2" width="308.3" height="2.2"/>
                <rect x="198.3" y="189.6" class="st2" width="308.3" height="2.2"/>
                <rect x="198.3" y="165.6" class="st2" width="308.3" height="2.2"/>
      
                <rect x="198.3" y="381.8" class="st3" width="308.3" height="2.2"/>
                <rect x="198.3" y="357.8" class="st3" width="308.3" height="2.2"/>
                <rect x="198.3" y="333.7" class="st3" width="308.3" height="2.2"/>
                <rect x="198.3" y="309.7" class="st3" width="308.3" height="2.2"/>
                <rect x="198.3" y="285.7" class="st3" width="308.3" height="2.2"/>
      
                <rect x="198.3" y="501.8" class="st4" width="308.3" height="2.2"/>
                <rect x="198.3" y="477.8" class="st4" width="308.3" height="2.2"/>
                <rect x="198.3" y="453.8" class="st4" width="308.3" height="2.2"/>
                <rect x="198.3" y="429.8" class="st4" width="308.3" height="2.2"/>
                <rect x="198.3" y="405.8" class="st4" width="308.3" height="2.2"/>
      
                <rect x="-110" y="141.6" class="st5" width="308.3" height="2.2"/>
                <rect x="-110" y="117.6" class="st5" width="308.3" height="2.2"/>
                <rect x="-110" y="93.6" class="st5" width="308.3" height="2.2"/>
                <rect x="-110" y="69.6" class="st5" width="308.3" height="2.2"/>
                <rect x="-110" y="45.6" class="st5" width="308.3" height="2.2"/>
      
                <rect x="-110" y="261.7" class="st6" width="308.3" height="2.2"/>
                <rect x="-110" y="237.7" class="st6" width="308.3" height="2.2"/>
                <rect x="-110" y="213.7" class="st6" width="308.3" height="2.2"/>
                <rect x="-110" y="189.6" class="st6" width="308.3" height="2.2"/>
                <rect x="-110" y="165.6" class="st6" width="308.3" height="2.2"/>
      
                <rect x="-110" y="381.8" class="st7" width="308.3" height="2.2"/>
                <rect x="-110" y="357.8" class="st7" width="308.3" height="2.2"/>
                <rect x="-110" y="333.7" class="st7" width="308.3" height="2.2"/>
                <rect x="-110" y="309.7" class="st7" width="308.3" height="2.2"/>
                <rect x="-110" y="285.7" class="st7" width="308.3" height="2.2"/>
      
                <rect x="-110" y="501.8" class="st8" width="308.3" height="2.2"/>
                <rect x="-110" y="477.8" class="st8" width="308.3" height="2.2"/>
                <rect x="-110" y="453.8" class="st8" width="308.3" height="2.2"/>
                <rect x="-110" y="429.8" class="st8" width="308.3" height="2.2"/>
                <rect x="-110" y="405.8" class="st8" width="308.3" height="2.2"/>
              </g>  
      
            </g>',
            $className,           // 1
            $horizontal_position, // 2
            $vertical_position,   // 3
            $scale,               // 4
            $rotate,              // 5
            $SVG1,    // 6
            $SVG2           // 7
    );
  }
}