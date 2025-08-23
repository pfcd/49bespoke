<?php
$additional_class = isset($field["class"]) ? $field["class"] : "";

$options = [
    'ball-pulse' => 3,
    'ball-grid-pulse' => 9,
    'ball-clip-rotate' => 1,
    'ball-clip-rotate-pulse' => 2,
    'square-spin' => 1,
    'ball-clip-rotate-multiple' => 2,
    'ball-pulse-rise' => 5,
    'ball-rotate' => 1,
    'cube-transition' => 2,
    // 'ball-zig-zag' => 2,
    'ball-zig-zag-deflect' => 2,
    'ball-triangle-path' => 3,
    'ball-scale' => 1,
    'line-scale' => 5,
    'line-scale-party' => 4,
    'ball-scale-multiple' => 3,
    'ball-pulse-sync' => 3,
    'ball-beat' => 3,
    'line-scale-pulse-out' => 5,
    'line-scale-pulse-out-rapid' => 5,
    'ball-scale-ripple' => 1,
    'ball-scale-ripple-multiple' => 3,
    'ball-spin-fade-loader' => 8,
    'line-spin-fade-loader' => 8,
    'triangle-skew-spin' => 1,
    'pacman' => 5,
    'semi-circle-spin' => 1,
    'ball-grid-beat' => 9,
    'ball-scale-random' => 3,
];

if(!isset($value) || '' === $value) {
    $value = 'ball-pulse';
}

?>

<?php $this->render_ribbon($field); ?>
<div class="dipi_row">
    <div class="dipi_settings_option_description col-md-12">
        <div class="dipi_option_label">
            <?php echo esc_html($field["label"]); ?>
        </div>
        <?php if (isset($field["description"]) && '' !== $field["description"]) : ?>
        <div class="dipi_option_description">
            <?php echo wp_kses_post($field["description"]); ?>
        </div>        
        <?php endif; ?>
        <div class="dipi_settings_option_field dipi_settings_option_field_multiple_buttons <?php echo esc_attr($additional_class); ?>">
            <?php foreach($options as $option_id => $option) : ?>
            <div class="dipi_radio_option">
                <input type='radio'
                        name='<?php echo esc_attr($id); ?>'
                        id='<?php echo esc_attr($id . "_" . $option_id); ?>'
                        value='<?php echo esc_attr($option_id); ?>'
                        <?php checked( $option_id, $value ); ?>
                />
                <label for='<?php echo esc_attr($id . "_" . $option_id); ?>'>
                    <div class="dipi_preloader <?php echo esc_attr($option_id); ?>">
                    <?php for($i = 0; $i < $option; $i++): ?>
                        <div></div>
                    <?php endfor; ?>
                    </div>
                </label>
            </div>
            <?php endforeach; ?> 
        </div> 
    </div>
</div>