<?php

class Custmoizer_DiviPixel_Panel extends \WP_Customize_Panel {
    public $type  ="dipi";
    public $icon;

    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct($manager, $id, $args);
        if(isset($args['icon'])){
            $this->icon = $args['icon'];
        }
    }

    protected function render() {
        ?>
        <li id="accordion-panel-<?php echo sanitize_html_class($this->id); ?>" class="accordion-section control-section control-panel control-panel-<?php echo sanitize_html_class($this->type); ?>">
            <h3 class="accordion-section-title" tabindex="0">
                <?php if(isset($this->icon)): ?>
                <?php \DiviPixel\DIPI_Customizer_API::include_icon($this->icon); ?>
                <?php endif; ?>
                <?php echo esc_html($this->title); ?>
                <span class="screen-reader-text"><?php esc_html_e( 'Press return or enter to open this panel', 'dipi-divi-pixel' ); ?></span>
            </h3>
            <ul class="accordion-sub-container control-panel-content"></ul>
        </li>
        <?php
    }
    protected function render_content() {
        ?>
        <li class="panel-meta customize-info accordion-section <?php if(isset($this->description)) { echo sanitize_html_class('cannot-expand'); } ?>">
            <button class="customize-panel-back" tabindex="-1"><span class="screen-reader-text"><?php esc_html_e( 'Back', 'dipi-divi-pixel' ); ?></span></button>
            <div class="accordion-section-title">
                <span class="preview-notice">
                <?php
                    /* translators: %s: the site/panel title in the Customizer */
                    $html = sprintf('<strong class="panel-title">%1$s</strong>', $this->title);
                    echo sprintf( esc_html__('You are customizing  %s', 'dipi-divi-pixel') , esc_html($html) );
                ?>
                </span>
                <?php if(isset($this->description)): ?>
                    <button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text"><?php esc_attr_e( 'Help', 'dipi-divi-pixel' ); ?></span></button>
                <?php endif; ?>
            </div>
            <?php if(isset($this->description)): ?>
                <div class="description customize-panel-description">
                    <?php echo esc_html($this->description); ?>
                </div>
            <?php endif; ?>
            <div class="customize-control-notifications-container"></div>
        </li>
        <?php
    }
}