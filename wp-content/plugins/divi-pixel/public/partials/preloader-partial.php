<?php
namespace DiviPixel;

//Check if custom preloader image is enabled. If so but we don't have an image, we don't show it
$use_custom_preloader = DIPI_Settings::get_option('custom_preloader_image');
$upload_preloader = DIPI_Settings::get_option( 'upload_preloader');
if($use_custom_preloader && !$upload_preloader) {
    return;
}

//Check if Divi Pixel preloader is enabeld. If so but none is selected, we don't show it
$preloader_style = DIPI_Settings::get_option('custom_preloader_style');
if(!$use_custom_preloader && !$preloader_style){
    return;
}

//Get Theme Customizer Options
$preloader_color = DIPI_Customizer::get_option('preloader_color'); //FIXME: Default was #ff4200
$preloader_background_color = DIPI_Customizer::get_option('preloader_background_color'); //FIXME: Default was #fff
$preloader_reveal = DIPI_Customizer::get_option('preloader_reveal'); //FIXME: Default was fade
$preloader_reveal_duration = DIPI_Customizer::get_option('preloader_reveal_duration'); //FIXME: Default was 300
$preloader_reveal_delay = DIPI_Customizer::get_option('preloader_reveal_delay'); //FIXME: Default was 300

$dipi_preloaders = [
    'ball-pulse' => 3,
    'ball-grid-pulse' => 9,
    'ball-clip-rotate' => 1,
    'ball-clip-rotate-pulse' => 2,
    'square-spin' => 1,
    'ball-clip-rotate-multiple' => 2,
    'ball-pulse-rise' => 5,
    'ball-rotate' => 1,
    'cube-transition' => 2,
    'ball-zig-zag' => 2,
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

?>
<div class="dipi_preloader_wrapper_outer">
    <div class="dipi_preloader_wrapper_inner">
    <?php if($use_custom_preloader) : ?>
        <img class="dipi_preloader_image" src="<?php echo esc_url($upload_preloader); ?>" alt="Website Preloader">
    <?php else: ?>
        <div class="dipi_preloader <?php echo esc_attr($preloader_style);?>">
        <?php for($i = 0; $i < $dipi_preloaders[$preloader_style]; $i++) : ?>
            <div></div>
        <?php endfor; ?>
        </div>
    <?php endif; ?>
    </div>
</div>
<style>
.dipi_preloader_wrapper_outer {
    background: <?php echo esc_html($preloader_background_color); ?>;
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 10000000;
    animation-timing-function: ease;
    animation-duration: <?php echo esc_html($preloader_reveal_duration); ?>ms;
}

.dipi_preloader_wrapper_outer.finished{
    animation-name: <?php echo esc_html("dipi_" . $preloader_reveal); ?>;
    animation-fill-mode: forwards;
    -webkit-animation-fill-mode: forwards;
}

.dipi_preloader_wrapper_outer .dipi_preloader.ball-pulse>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-grid-pulse>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-clip-rotate-pulse>div:first-child,
.dipi_preloader_wrapper_outer .dipi_preloader.square-spin>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-pulse-rise>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-rotate>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-rotate>div:before,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-rotate>div:after,
.dipi_preloader_wrapper_outer .dipi_preloader.cube-transition>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-zig-zag>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-zig-zag-deflect>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-scale>div,
.dipi_preloader_wrapper_outer .dipi_preloader.line-scale>div,
.dipi_preloader_wrapper_outer .dipi_preloader.line-scale-party>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-scale-multiple>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-pulse-sync>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-beat>div,
.dipi_preloader_wrapper_outer .dipi_preloader.line-scale-pulse-out>div,
.dipi_preloader_wrapper_outer .dipi_preloader.line-scale-pulse-out-rapid>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-spin-fade-loader>div,
.dipi_preloader_wrapper_outer .dipi_preloader.line-spin-fade-loader>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-grid-beat>div,
.dipi_preloader_wrapper_outer .dipi_preloader.pacman>div:nth-child(3),
.dipi_preloader_wrapper_outer .dipi_preloader.pacman>div:nth-child(4),
.dipi_preloader_wrapper_outer .dipi_preloader.pacman>div:nth-child(5),
.dipi_preloader_wrapper_outer .dipi_preloader.pacman>div:nth-child(6),
.dipi_preloader_wrapper_outer .dipi_preloader.ball-scale-random>div {
    background-color: <?php echo esc_html($preloader_color); ?>;
}

.dipi_preloader_wrapper_outer .dipi_preloader.ball-clip-rotate>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-triangle-path>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-scale-ripple>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-scale-ripple-multiple>div {
    border-color: <?php echo esc_html($preloader_color); ?>;
}

.dipi_preloader_wrapper_outer .dipi_preloader.ball-clip-rotate>div {
    border-bottom-color: transparent;
}

.dipi_preloader_wrapper_outer .dipi_preloader.ball-clip-rotate-pulse>div:last-child,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-clip-rotate-multiple>div,
.dipi_preloader_wrapper_outer .dipi_preloader.ball-clip-rotate-multiple>div:last-child {
    border-color: <?php echo esc_html($preloader_color); ?> transparent;
}

.dipi_preloader_wrapper_outer .dipi_preloader.semi-circle-spin>div {
    background-image: linear-gradient(transparent 0, transparent 70%, <?php echo esc_html($preloader_color); ?> 30%, <?php echo esc_html($preloader_color); ?> 100%);
}

.dipi_preloader_wrapper_outer .dipi_preloader.triangle-skew-spin>div {
    border-bottom-color: <?php echo esc_html($preloader_color); ?>;
}

.dipi_preloader_wrapper_outer .dipi_preloader.pacman>div:first-of-type,
.dipi_preloader_wrapper_outer .dipi_preloader.pacman>div:nth-child(2) {
    border-top-color: <?php echo esc_html($preloader_color); ?>;
    border-left-color: <?php echo esc_html($preloader_color); ?>;
    border-bottom-color: <?php echo esc_html($preloader_color); ?>;
}

</style>