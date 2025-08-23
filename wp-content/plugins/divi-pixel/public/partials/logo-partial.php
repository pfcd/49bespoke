<?php
namespace DiviPixel;

$use_fixed_logo = DIPI_Settings::get_option('fixed_logo');
$fixed_logo_image = DIPI_Settings::get_option('fixed_logo_image');
$use_mobile_logo = DIPI_Settings::get_option('mobile_logo');
$mobile_logo_url = DIPI_Settings::get_option('mobile_logo_url');
$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();
?>
<style>
/*#main-header .logo_container img,
header.et-l--header .et_pb_menu__logo > img {
    display: none;
}*/
</style>
<script type="text/javascript" id="dipi-logo-js">
jQuery(document).ready(function($) {

    var currentLogoMode = '';


    let $mainHeader = $('header#main-header');
    let $tbHeader = $('header.et-l--header');
    <?php if ($use_mobile_logo || $use_fixed_logo): ?>
    if ($tbHeader.length) {
        let $tbLogos = $('header.et-l--header .et_pb_menu__logo img');
        $tbLogos.each(function(i, $tblogo) {
            dipi_update_logo($($tblogo), true)
        })
    } else {
        let $logo = $('#logo'); 
        dipi_update_logo($logo)   
    }
    <?php endif;?>
    function dipi_update_logo($logo, $is_tb_logo) {
        // Clone $logo so we can replace it rather than just change src attr (because this causes a bug in Safari browser) 
        let $mainLogo = $logo.clone();
        let $tbLogoContainer = $logo.closest(".et_pb_menu__logo")
        let $tbLogoContainer_a = $logo.closest(".et_pb_menu__logo a")
        let $tbLogoWrapper = $tbLogoContainer_a.length ? $tbLogoContainer_a : $tbLogoContainer
        if($mainLogo.length) {
            $mainLogo.attr("data-logo-type", "main");
            $mainLogo.attr("data-actual-width", $mainLogo[0].naturalWidth);
            $mainLogo.attr("data-actual-height", $mainLogo[0].naturalHeight);
        }
        // Clone $logo to use in fixed header. If fixed header logo is not enabled, we simple use the original logo
        <?php if($use_fixed_logo): ?>  
            let fixedLogoUrl = "<?php echo esc_url($fixed_logo_image); ?>";
            let $fixedLogo = $logo.clone().attr("src", fixedLogoUrl)
            $fixedLogo.attr("data-logo-type", "fixed");
        <?php else: ?>
            let $fixedLogo = $logo.clone();
        <?php endif;?>
        if($fixedLogo.length) {
            $fixedLogo.attr("data-actual-width", $fixedLogo[0].naturalWidth);
            $fixedLogo.attr("data-actual-height", $fixedLogo[0].naturalHeight);
        }
        
        // Clone $logo to use in mobile. If mobile logo is not enabled, we simple use the original logo
        let $use_mobile_logo = <?php echo $use_mobile_logo === true ? 'true' : 'false'; ?>;
        <?php if($use_mobile_logo): ?>
        let mobileLogoUrl = "<?php echo esc_url($mobile_logo_url); ?>";
        let $mobileLogo = $logo.clone().attr("src", mobileLogoUrl);
        if($mobileLogo.length){
            $mobileLogo.attr("data-logo-type", "mobile");
            $mobileLogo.attr("data-actual-height", $mobileLogo[0].naturalHeight);
        }
        <?php else: ?>
        let $mobileLogo = $logo.clone();
        <?php endif;?>
        
        if($use_mobile_logo && ($(window).width() <= <?php echo intval($breakpoint_mobile); ?>)){
            setTimeout( function(){
                $mobileLogo.show();
            }, 500)
        } else {
            setTimeout( function(){
                $fixedLogo.show();
                $mainLogo.show();
            }, 500)
        }

        $fixedLogo.removeAttr("srcset")
        $mobileLogo.removeAttr("srcset")
        function callback(mutationList, observer) {
            mutationList.forEach(function(mutation){
                if('attributes' != mutation.type || 'class' !== mutation.attributeName){
                    return;
                }
                if($is_tb_logo) {
                    dipi_tb_header_change();
                } else {
                    dipi_default_logo_change();
                }
            });
        }

        var targetNode = document.querySelector("#main-header,header.et-l--header > .et_builder_inner_content");
        var observerOptions = {
            childList: false,
            attributes: true,
            subtree: false
        }

        if(targetNode){
            var observer = new MutationObserver(callback);
            observer.observe(targetNode, observerOptions);
        }

        
        if($is_tb_logo) {
            // Observe resize events to switch between mobile/fixed logos
            $(window).resize(dipi_tb_header_change);
            // finally call the callback manually once to get started
            dipi_tb_header_change(true);
        } else {
            // Observe resize events to switch between mobile/fixed logos
            $(window).resize(dipi_default_logo_change);
            // finally call the callback manually once to get started
            dipi_default_logo_change(true);
        }

        
        function dipi_tb_header_change(first_loading = false) {
            if($mainLogo.length)
                $mainLogo.attr("data-actual-width", $mainLogo[0].naturalWidth);
            
            
            if($use_mobile_logo && $(window).width() <= <?php echo intval($breakpoint_mobile); ?> && currentLogoMode != 'mobile'){
                currentLogoMode = 'mobile';
                $tbLogoWrapper.find("img").remove();
                $tbLogoWrapper.append($mobileLogo);
            } else if ($(window).width() > <?php echo intval($breakpoint_mobile); ?>) {
                if ($tbHeader.find('.has_et_pb_sticky').length !== 0  && currentLogoMode != 'desktop-fixed'){
                    currentLogoMode = 'desktop-fixed';
                    $tbLogoWrapper.find("img").remove();
                    $tbLogoWrapper.append($fixedLogo);
                    <?php if ($use_fixed_logo): ?>  
                    if (!first_loading) {              
                        $tbLogoContainer.removeClass("animation-mainLogo")
                        $tbLogoContainer.addClass("animation-replaceLogo")
                    }
                    <?php endif;?>
                } else if($tbHeader.find('.has_et_pb_sticky').length == 0 && currentLogoMode != 'desktop-normal' ){
                    currentLogoMode = 'desktop-normal';
                    $tbLogoWrapper.find("img").remove();
                    $tbLogoWrapper.append($mainLogo);
                    <?php if ($use_fixed_logo): ?>
                    if (!first_loading) {              
                        $tbLogoContainer.removeClass("animation-replaceLogo")
                        $tbLogoContainer.addClass("animation-mainLogo")
                    }
                    <?php endif;?>
                }
            }
        }

        // Callback to fire when window is resized or scrolled
        function dipi_default_logo_change(first_loading = false) {
            if($mainLogo.length){
                $mainLogo.attr("data-actual-width", $mainLogo[0].naturalWidth);
            }

            if($use_mobile_logo && $(window).width() <= <?php echo intval($breakpoint_mobile); ?> && currentLogoMode != 'mobile'){
                currentLogoMode = 'mobile';
                let $a = $(".logo_container a");
                $a.find("#logo").remove();    
                $a.append($mobileLogo);
            } else if($(window).width() > <?php echo intval($breakpoint_mobile); ?>) {                
                if ($mainHeader.hasClass('et-fixed-header') && currentLogoMode != 'desktop-fixed'){
                    currentLogoMode = 'desktop-fixed';
                    let $a = $(".logo_container a");
                    $a.find("#logo").remove();    
                    $a.append($fixedLogo);
                    <?php if ($use_fixed_logo): ?>  
                    if (!first_loading) {
                        $a.find("#logo").removeClass("animation-mainLogo")        
                        $a.find("#logo").addClass("animation-replaceLogo")
                    }
                    <?php endif;?>
                } else if(!$mainHeader.hasClass('et-fixed-header') && currentLogoMode != 'desktop-normal') {
                    currentLogoMode = 'desktop-normal';
                    let $a = $(".logo_container a");
                    $a.find("#logo").remove(); 
                    $a.append($mainLogo);
                    <?php if ($use_fixed_logo): ?>
                    if (!first_loading) {
                        $a.find("#logo").removeClass("animation-replaceLogo")                
                        $a.find("#logo").addClass("animation-mainLogo")
                    }
                    <?php endif;?>
                }
            }
        }
    }

});
</script>