<?php
class Customizer_Quad_Control extends \WP_Customize_Control
{
    public $type = 'quad';
    private $labels;
    private $columns = 1; 

    public function __construct($manager, $id, $args = array())
    {
        $args['settings'] = [
            "{$id}_1",
            "{$id}_2",
            "{$id}_3",
            "{$id}_4",
        ];

        parent::__construct($manager, $id, $args);

        if(isset($args["labels"])) {
            $this->labels = $args["labels"];
        }

        if(isset($args["columns"])) {
            $this->columns = $args["columns"];
        } 
    }

    /**
     * Enqueue scripts/styles.
     *
     * @since 3.4.0
     */
    public function enqueue()
    {
        wp_enqueue_style( 'customizer-quad-control', plugin_dir_url(__FILE__) . '/css/customizer-quad-control.css', array(), false );
    }

    public function build_field_html($key)
    {
        $value = '';
        if (isset($this->settings[$key])) {
            $value = $this->settings[$key]->value();
        }
        ?>
        <div class="input-wrapper">
            <?php if (isset($this->labels[$key])) : ?>
                <div class="input-label"><?php echo esc_html($this->labels[$key]); ?></div>
            <?php endif; ?>
            <input type="text" value="<?php echo esc_attr($value); ?>" <?php echo wp_kses_post($this->get_link($key)); ?> />
        </div>
    <?php
    }
    /**
     * Render the control's content.
     *
     * @author soderlind
     * @version 1.2.0
     */
    public function render_content()
    {
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php if (!empty($this->description)) : ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>
            <div class="customize-control-quad columns-<?php echo sanitize_html_class($this->columns);?>">
                <?php foreach ($this->settings as $key => $value) : ?>
                    <?php $this->build_field_html($key); ?>
                <?php endforeach; ?>
            </div>
        </label>
    <?php
    }

    public static function add_settings($wp_customize, $field_id, $options)
    {
        // $options["sanitize_callback"] = ["Customizer_Quad_Control", "sanitize_input"];
        if(isset($options['default'])){
            $defaults = explode("|", $options['default']);
            $options1 = $options;
            $options2 = $options;
            $options3 = $options;
            $options4 = $options;
            switch(count($defaults)){
                case 1:
                    $options1['default'] = $defaults[0];
                    $options2['default'] = $defaults[0];
                    $options3['default'] = $defaults[0];
                    $options4['default'] = $defaults[0];
                    break;
                case 2:
                    $options1['default'] = $defaults[0];
                    $options2['default'] = $defaults[1];
                    $options3['default'] = $defaults[0];
                    $options4['default'] = $defaults[1];
                    break;
                case 4:
                    $options1['default'] = $defaults[0];
                    $options2['default'] = $defaults[1];
                    $options3['default'] = $defaults[2];
                    $options4['default'] = $defaults[3];
                    break;
            }
            $wp_customize->add_setting("{$field_id}_1", $options1);
            $wp_customize->add_setting("{$field_id}_2", $options2);
            $wp_customize->add_setting("{$field_id}_3", $options3);
            $wp_customize->add_setting("{$field_id}_4", $options4);
        } else {
            $wp_customize->add_setting("{$field_id}_1", $options);
            $wp_customize->add_setting("{$field_id}_2", $options);
            $wp_customize->add_setting("{$field_id}_3", $options);
            $wp_customize->add_setting("{$field_id}_4", $options);
        }
    }
}
