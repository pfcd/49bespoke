<?php

class Customizer_Toggle_Control extends \WP_Customize_Control {
	public $type = 'ios';

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since 3.4.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'customizer-toggle-control', plugin_dir_url(__FILE__) . '/js/customizer-toggle-control.js', array( 'jquery' ), rand(), true );
		wp_enqueue_style( 'pure-css-toggle-buttons', plugin_dir_url(__FILE__) . '/css/customizer-toggle-control.css', array(), false );

		$css = '
			.disabled-control-title {
				color: #a0a5aa;
			}
			input[type=checkbox].tgl-light:checked + .tgl-btn {
				background: #0085ba;
			}
			input[type=checkbox].tgl-light + .tgl-btn {
			  background: #a0a5aa;
			}
			input[type=checkbox].tgl-light + .tgl-btn:after {
			  background: #f7f7f7;
			}

			input[type=checkbox].tgl-ios:checked + .tgl-btn {
			  background: #0085ba;
			}

			input[type=checkbox].tgl-flat:checked + .tgl-btn {
			  border: 4px solid #0085ba;
			}
			input[type=checkbox].tgl-flat:checked + .tgl-btn:after {
			  background: #0085ba;
			}

		';
		wp_add_inline_style( 'pure-css-toggle-buttons', $css );
	}

	/**
	 * Render the control's content.
	 *
	 * @author soderlind
	 * @version 1.2.0
	 */
	public function render_content() {
		$value = $this->value();
		$value = $value === true || $value === 'on' || $value === 'yes' || $value === 'true' || $value === 1;
	
		?>
		<label class="customize-toogle-label">
			<div style="display:flex; flex-direction: row; justify-content: flex-start; align-items: center;">
				<span class="customize-control-title" style="flex: 2 0 0; vertical-align: middle;"><?php echo esc_html( $this->label ); ?></span>
				<input id="cb<?php echo esc_attr($this->instance_number); ?>" 
					   type="checkbox" 
					   class="tgl tgl-<?php echo esc_attr($this->type); ?>" 
					   value="on"
					   <?php $this->link(); ?>
					   <?php checked( $value );?>
				 />
				<label for="cb<?php echo esc_attr($this->instance_number); ?>" class="tgl-btn" style="margin-top: 5px;"></label>
			</div>
			<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
			<?php endif; ?>
		</label>
		<?php
	}

}
