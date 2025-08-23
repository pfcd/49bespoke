<?php

class Customizer_Heading_Control extends \WP_Customize_Control {
    public $type = "dipi-heading";
    public $show_cta = false;
    public $icon;

    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct($manager, $id, $args);
        if(isset($args['cta'])){
            $this->show_cta = $args['cta'];
        }
        if(isset($args['icon'])){
            $this->icon = $args['icon'];
        }
    }

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_style( 'class-customizer-heading-control', plugin_dir_url(__FILE__) . '/css/class-customizer-heading-control.css', array(), false );
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
            <?php if(isset($this->icon) && $this->show_cta): ?>
            <div class="dipi_content_wrapper">  
                <?php \DiviPixel\DIPI_Customizer_API::include_icon($this->icon); ?>
                <div class="dipi_text_wrapper">
            <?php endif; ?>
			<div class="dipi_customizer_control_heading">
				<div class="dipi_customizer_control_heading_label customize-control-title">
                    <?php if(isset($this->icon) && !$this->show_cta): ?>
                    <?php \DiviPixel\DIPI_Customizer_API::include_icon($this->icon); ?>
                    <?php endif; ?>
                    <div class="dipi-label"><?php echo esc_html( $this->label ); ?></div>
                </div>
			</div>
			<?php if ( ! empty( $this->description ) ) : ?>
			<span class="dipi_customizer_control_heading_description description customize-control-description"><?php echo esc_html($this->description); ?></span>
			<?php endif; ?>
			<?php if ( $this->show_cta ) : ?>
			<div>
				<a href="<?php echo esc_url(admin_url("admin.php?page=divi_pixel_options")); ?>" class="dipi_customizer_control_heading_cta"><?php echo esc_html__('Divi Pixel Dashboard', 'dipi-divi-pixel');?></a>
			</div>
            <?php endif; ?>		
            <?php if(isset($this->icon) && $this->show_cta): ?>
            </div>        
            </div>        
            <?php endif; ?>	
		</label>
		<?php
	}
}
