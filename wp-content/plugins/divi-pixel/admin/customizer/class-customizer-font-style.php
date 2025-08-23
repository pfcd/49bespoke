<?php

class Customizer_Font_Style extends \WP_Customize_Control {

    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct($manager, $id, $args);
        // if(isset($args['cta'])){
        //     $this->show_cta = $args['cta'];
        // }
    }

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'customizer-font-style', plugin_dir_url(__FILE__) . '/js/customizer-font-style.js', array( 'jquery' ), false, true );
		wp_enqueue_style( 'customizer-font-style', plugin_dir_url(__FILE__) . '/css/customizer-font-style.css', array(), false );
	}

	/**
	 * Render the control's content.
	 *
	 * @author Jan Thielemann
	 * @version 1.0.0
	 */
	public function render_content() {
		?>
		<label>
			<div class="dipi_customizer_control_font_style">
                <span class="dipi_customizer_control_font_style_label customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <input  type="text" 
                        id="font_style_<?php echo sanitize_html_class($this->instance_number); ?>" 
                        class="dipi_font_style dipi_font_style-<?php echo sanitize_html_class($this->type); ?>" 
                        value="<?php echo esc_attr( $this->value() ); ?>"
                        <?php $this->input_attrs(); ?>
                        <?php $this->link(); ?>
                    >
                <div class="dipi_customizer_control_font_style_buttons">
                    <div class="button button_italic">I</div>
                    <div class="button button_uppercase">TT</div>
                    <div class="button button_small_caps">Tt</div>
                    <div class="button button_underline">U</div>
                    <div class="button button_strike_through">S</div>
                </div>
			</div>
			<?php if ( ! empty( $this->description ) ) : ?>
			<span class="dipi_customizer_control_font_style_description description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>
		</label>
		<?php
	}
}
