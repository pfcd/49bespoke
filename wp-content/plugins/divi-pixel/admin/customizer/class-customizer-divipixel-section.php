<?php

class Custmoizer_DiviPixel_Section extends \WP_Customize_Section {
    public $type  ="dipi";
    public $icon;

    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct($manager, $id, $args);
        if(isset($args['icon'])){
            $this->icon = $args['icon'];
        }
    }

    protected function render() {
        if ( $this->panel ) {
			/* translators: &#9656; is the unicode right-pointing triangle, and %s is the section title in the Customizer */
			$ustomizeAction = sprintf( __( 'Customizing &#9656; %s' ), esc_html( $this->manager->get_panel( $this->panel )->title ) );
		} else {
			$ustomizeAction = __( 'Customizing' );
		}
        ?>
        <li id="accordion-section-<?php echo sanitize_html_class($this->id); ?>" class="accordion-section control-section control-section-<?php echo sanitize_html_class($this->type); ?>">
        <h3 class="accordion-section-title" tabindex="0">
            <?php if(isset($this->icon)): ?>
            <?php \DiviPixel\DIPI_Customizer_API::include_icon($this->icon); ?>
            <?php endif; ?>
            <?php echo esc_html($this->title); ?>
            <span class="screen-reader-text"><?php esc_html_e( 'Press return or enter to open this section', 'dipi-divi-pixel' ); ?></span>
        </h3>
        <ul class="accordion-section-content">
            <li class="customize-section-description-container section-meta <?php if ( $this->description_hidden ) { echo 'customize-info'; } ?>">
                <div class="customize-section-title">
                    <button class="customize-section-back" tabindex="-1">
                        <span class="screen-reader-text"><?php esc_html_e( 'Back', 'dipi-divi-pixel' ); ?></span>
                    </button>
                    <h3>
                        <span class="customize-action">
                            <?php echo esc_html($ustomizeAction); ?>
                        </span>
                        <?php echo esc_html($this->title); ?>
                    </h3>
                    <?php if(isset($this->description) && $this->description_hidden): ?>
                        <button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text"><?php esc_html_e( 'Help', 'dipi-divi-pixel' ); ?></span></button>
                        <div class="description customize-section-description">
                            <?php echo esc_html($this->description); ?>
                        </div>
                    <?php endif; ?>

                    <div class="customize-control-notifications-container"></div>
                </div>

                <?php if(isset($this->description) && !$this->description_hidden): ?>
                    <div class="description customize-section-description">
                        <?php echo esc_html($this->description); ?>
                    </div>
                <?php endif; ?>
            </li>
        </ul>
    </li>
    <?php
    }
  

}