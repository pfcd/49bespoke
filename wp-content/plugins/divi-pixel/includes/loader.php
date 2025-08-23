<?php

if ( ! class_exists( 'ET_Builder_Element' ) ) {
	return;
}

require_once plugin_dir_path(__FILE__) . 'modules/Base/DIPI_Builder_Module.php';
require_once plugin_dir_path(__FILE__) . 'modules/Base/DIPI_Builder_Module_Type_PostBased.php';
require_once plugin_dir_path(__FILE__) . 'modules/Base/DIPI_Swiper_Module.php';

 
if (!\DiviPixel\DIPI_Settings::get_option('md_masonry_gallery')){
	require_once plugin_dir_path(__FILE__) . 'modules/MasonryGallery/MasonryGallery.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_flip_box')){
	require_once plugin_dir_path(__FILE__) . 'modules/FlipBox/FlipBox.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_counter')){
	require_once plugin_dir_path(__FILE__) . 'modules/Counter/Counter.php';
}
if (!\DiviPixel\DIPI_Settings::get_option('md_reveal')){
	require_once plugin_dir_path(__FILE__) . 'modules/Reveal/Reveal.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_tilt_image')){
	require_once plugin_dir_path(__FILE__) . 'modules/TiltImage/TiltImage.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_floating_multi_images')){
	require_once plugin_dir_path(__FILE__) . 'modules/FloatingMultiImagesChild/FloatingMultiImagesChild.php';
	require_once plugin_dir_path(__FILE__) . 'modules/FloatingMultiImages/FloatingMultiImages.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_before_after_slider')){
	require_once plugin_dir_path(__FILE__) . 'modules/BeforeAfterSlider/BeforeAfterSlider.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_carousel')) {
	require_once plugin_dir_path(__FILE__) . 'modules/CarouselChild/CarouselChild.php';
	require_once plugin_dir_path(__FILE__) . 'modules/Carousel/Carousel.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_typing_text')) {
	require_once plugin_dir_path(__FILE__) . 'modules/TypingText/TypingText.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_breadcrumbs')) {
	require_once plugin_dir_path(__FILE__) . 'modules/Breadcrumbs/Breadcrumbs.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_star_rating')) {
	require_once plugin_dir_path(__FILE__) . 'modules/StarRating/StarRating.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_button_grid')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ButtonGridChild/ButtonGridChild.php';
	require_once plugin_dir_path(__FILE__) . 'modules/ButtonGrid/ButtonGrid.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_image_hotspot')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ImageHotspot/ImageHotspot.php';
	require_once plugin_dir_path(__FILE__) . 'modules/ImageHotspotChild/ImageHotspotChild.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_testimonial')) {
	require_once plugin_dir_path(__FILE__) . 'modules/Testimonial/Testimonial.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_countdown')) {
	require_once plugin_dir_path(__FILE__) . 'modules/Countdown/Countdown.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_pricelist')) {
	require_once plugin_dir_path(__FILE__) . 'modules/PriceList/PriceList.php';
	require_once plugin_dir_path(__FILE__) . 'modules/PriceListItem/PriceListItem.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_fancy_text')) {
	require_once plugin_dir_path(__FILE__) . 'modules/FancyText/FancyText.php';
	require_once plugin_dir_path(__FILE__) . 'modules/FancyTextChild/FancyTextChild.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_hover_box')) {
	require_once plugin_dir_path(__FILE__) . 'modules/HoverBox/HoverBox.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_blog_slider')) {
    require_once plugin_dir_path(__FILE__) . 'modules/BlogSlider/BlogSlider.php';
}

if(!\DiviPixel\DIPI_Settings::get_option('md_balloon')){
	require_once plugin_dir_path(__FILE__) . 'modules/Balloon/Balloon.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_accordion_image')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ImageAccordion/ImageAccordion.php';
	require_once plugin_dir_path(__FILE__) . 'modules/ImageAccordionChild/ImageAccordionChild.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_scroll_image')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ScrollImage/ScrollImage.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_panorama')) {
	require_once plugin_dir_path(__FILE__) . 'modules/Panorama/Panorama.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_reading_progress_bar')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ReadingProgressBar/ReadingProgressBar.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_image_magnifier')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ImageMagnifier/ImageMagnifier.php';
}
if (!\DiviPixel\DIPI_Settings::get_option('md_image_rotator')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ImageRotator/ImageRotator.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_lottie_icon')) {
	require_once plugin_dir_path(__FILE__) . 'modules/LottieIcon/LottieIcon.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_image_mask')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ImageMask/ImageMask.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_image_showcase')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ImageShowcase/ImageShowcase.php';
	require_once plugin_dir_path(__FILE__) . 'modules/ImageShowcaseChild/ImageShowcaseChild.php';
}

// if (!\DiviPixel\DIPI_Settings::get_option('md_instagram')) {
// 	require_once plugin_dir_path(__FILE__) . 'modules/InstagramGrid/InstagramGrid.php';
// 	require_once plugin_dir_path(__FILE__) . 'modules/InstagramProfile/InstagramProfile.php';
// 	require_once plugin_dir_path(__FILE__) . 'modules/InstagramSlider/InstagramSlider.php';
// }

if (!\DiviPixel\DIPI_Settings::get_option('md_timeline')) {
	require_once plugin_dir_path(__FILE__) . 'modules/Timeline/Timeline.php';
	require_once plugin_dir_path(__FILE__) . 'modules/TimelineItem/TimelineItem.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_content_toggle')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ContentToggle/ContentToggle.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_faq')) {
	require_once plugin_dir_path(__FILE__) . 'modules/FAQ/FAQ.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_gallery_slider')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ImageGallery/ImageGallery.php';
	require_once plugin_dir_path(__FILE__) . 'modules/ImageGalleryChild/ImageGalleryChild.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_dual_heading')) {
	require_once plugin_dir_path(__FILE__) . 'modules/DualHeading/DualHeading.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_svg_animator')) {
	require_once plugin_dir_path(__FILE__) . 'modules/SVGAnimator/SVGAnimator.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_advanced_tabs')) {
	require_once plugin_dir_path(__FILE__) . 'modules/AdvancedTabs/AdvancedTabs.php';
	require_once plugin_dir_path(__FILE__) . 'modules/AdvancedTabsItem/AdvancedTabsItem.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_info_circle')) {
 	require_once plugin_dir_path(__FILE__) . 'modules/InfoCircle/InfoCircle.php';
 	require_once plugin_dir_path(__FILE__) . 'modules/InfoCircleItem/InfoCircleItem.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_text_highlighter')) {
	require_once plugin_dir_path(__FILE__) . 'modules/TextHighlighter/TextHighlighter.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_expanding_cta')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ExpandingCTA/ExpandingCTA.php';
}
if (!\DiviPixel\DIPI_Settings::get_option('md_horizontal_timeline')) {
	require_once plugin_dir_path(__FILE__) . 'modules/HorizontalTimeline/HorizontalTimeline.php';
	require_once plugin_dir_path(__FILE__) . 'modules/HorizontalTimelineItem/HorizontalTimelineItem.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_pricing_table')) {
	require_once plugin_dir_path(__FILE__) . 'modules/PricingTable/PricingTable.php';
	require_once plugin_dir_path(__FILE__) . 'modules/PricingTableItem/PricingTableItem.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_filterable_grid')) {
	require_once plugin_dir_path(__FILE__) . 'modules/FilterableGrid/FilterableGrid.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_tile_scroll')) {
	require_once plugin_dir_path(__FILE__) . 'modules/TileScroll/TileScroll.php';
	require_once plugin_dir_path(__FILE__) . 'modules/TileScrollItem/TileScrollItem.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_parallax_images')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ParallaxImages/ParallaxImages.php';
	require_once plugin_dir_path(__FILE__) . 'modules/ParallaxImagesItem/ParallaxImagesItem.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_filterable_gallery')) {
	require_once plugin_dir_path(__FILE__) . 'modules/FilterableGallery/FilterableGallery.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_table_of_contents')) {
	require_once plugin_dir_path(__FILE__) . 'modules/TableOfContent/TableOfContent.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_gravity_styler')){
	require_once plugin_dir_path(__FILE__) . 'modules/GravityFormsStyler/GravityFormsStyler.php';
}
if (!\DiviPixel\DIPI_Settings::get_option('md_content_slider')) {
	require_once plugin_dir_path(__FILE__) . 'modules/ContentSlider/ContentSlider.php';
	require_once plugin_dir_path(__FILE__) . 'modules/ContentSliderChild/ContentSliderChild.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_hover_gallery')) {
	require_once plugin_dir_path(__FILE__) . 'modules/HoverGallery/HoverGallery.php';
	require_once plugin_dir_path(__FILE__) . 'modules/HoverGalleryItem/HoverGalleryItem.php';
}
if (!\DiviPixel\DIPI_Settings::get_option('md_table_maker')) {
	require_once plugin_dir_path(__FILE__) . 'modules/TableMaker/TableMaker.php';
	require_once plugin_dir_path(__FILE__) . 'modules/TableMakerChild/TableMakerChild.php';
}

if (!\DiviPixel\DIPI_Settings::get_option('md_advanced_divider')) {
	require_once plugin_dir_path(__FILE__) . 'modules/Divider/Divider.php';
}
