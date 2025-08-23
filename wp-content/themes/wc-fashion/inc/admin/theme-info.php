<?php
$pro_purchase_url = "https://www.eaglevisionit.com/downloads/wc-fashion/";
$doc_url = "https://www.eaglevisionit.com/downloads/wc-fashion/";
$live_demo_url = "https://demos.eaglevisionit.com/wc-fashion-pro/";
$support_url = "https://www.eaglevisionit.com/contact-us/";

$theme_name = esc_html( $theme->Name );
$free_theme_name = str_replace( ' Pro', '',$theme_name );
?>
<div class="wc-fashion--about-page--wrapper">
    <div id="wc-fashion-admin-about-page">
        <div class="wc-fashion-admin-card-header">
            <div class="wc-fashion-header-left">
                <h2>
                    <?php echo esc_html( $theme->Name ); ?>
                </h2>
                <p>
                    <?php esc_html_e( 'WC Fashion - A Multipurpose, browser & device-friendly Full Site Editing Theme for WordPress', 'wc-fashion' ); ?>
                </p>

            </div>
            <div class="wc-fashion-header-right">
                <div class="wc-fashion-card-header-button-group">
                    <a href="<?php echo $live_demo_url; ?>" class="wc-fashion-admin-button premium-button" target="_blank"
                        rel="noreferrer"><span class="dashicons dashicons-book-alt"></span>
                        <?php esc_html_e( 'Pro Live Demo', 'wc-fashion' ); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="feature-list">
            <div class="wc-fashion-about-container">
                <div class="wc-fashion-admin-card features">
                    <div class="wc-fashion-about-container wc-fashion-compare-table">
                        <div class="admin-grid-1">
                            <h3>
                                <?php echo esc_html( $free_theme_name ); ?>
                                <?php esc_html_e( 'Free Vs Pro', 'wc-fashion' ); ?>
                            </h3>
                            <p class="wc-fashion-compare-table-subtitle"><a href="<?php echo $pro_purchase_url; ?>"
                                    target="__blank">
                                    <?php echo esc_html( 'Get WC Fashion Pro', 'wc-fashion' ); ?>
                                    <i class="dashicons dashicons-arrow-right-alt"></i>
                                </a></p>
                            <table>
                                <thead>
                                    <tr>
                                        <th>
                                            <?php echo esc_html( $theme->Name ); ?>
                                            <?php esc_html_e( 'Free', 'wc-fashion' ); ?>
                                            <?php esc_html_e( '( Limited blocks available )', 'wc-fashion' ); ?>
                                            
                                        </th>
                                        <th>
                                            <?php esc_html_e( 'Features', 'wc-fashion' ); ?>
                                        </th>
                                        <th>
                                            <?php esc_html_e( 'WC Fashion Pro ( More Blocks & Settings available )', 'wc-fashion' ); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Easy Setup', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Responsive Desgin', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'SEO Friendly', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( '24/7 premium support', 'wc-fashion' ); ?>
                                        </td>
                                        <td><?php esc_html_e( 'High-Priority Dedicated Support', 'wc-fashion' ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Different niches starter sites', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Secure transaction', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Lifetime Updates', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'No coding required', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'WooCommerce', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Mini Cart', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Upsells', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Multi Steps', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Sticky cart', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Bulk Variation', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Quick View', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Elementor', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Drag and Drop functionality', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'One Click Demo Import', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( ' Featured Slider', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Typography and color options', 'wc-fashion' ); ?>
                                        </td>
                                        <td><?php esc_html_e( 'Unlimited', 'wc-fashion' ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Import components/ templates', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'One Click Demo Import', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Gutenberg block editor', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Profile card (Block)', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Blog (block)', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Unlimited', 'wc-fashion' ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Carousel Post (Block)', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Unlimited', 'wc-fashion' ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Testimonials(block)', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'News Block', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Templates and block patterns', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Advanced Color Options', 'wc-fashion' ); ?>
                                        </td>
                                        <td><?php esc_html_e( 'Unlimited', 'wc-fashion' ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Theme Options', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Enable Mini Cart On Header', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Enable Testimonial Slider', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Enable Sponsor Slider', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Enable Sticky Header', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'WP Travel Plugin', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Booking system', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Google Maps zoom level settings', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Group discount', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Wishlist', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Tour extras', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Multiple prices and multiple dates', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Coupon', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Full Site Editing/Site Editor', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Limited Features', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Block themes', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Style variations', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-fashion' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Block patterns and template parts', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Global style Interface', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Edit each areas of website(header, footer, sidebar)', 'wc-fashion' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wc-fashion-about-side">
                <div class="wc-fashion-admin-card cart-two">
                    <h3 class="wc-fashion-admin-card-title is-small">
                        <?php esc_html_e( 'Questions Welcome - We\'re here to help', 'wc-fashion' ); ?>
                    </h3>
                    <p>
                        <?php esc_html_e( '"Fearless Setup - Our Dedicated Team will have your website up in minutes', 'wc-fashion' ); ?>
                    </p><a href="<?php echo $support_url; ?>" class="wc-fashion-admin-button primary large"
                        target="_blank">
                        <?php esc_html_e( 'Get Support', 'wc-fashion' ); ?>
                    </a>
                    <a href="<?php echo $pro_purchase_url; ?>" class="wc-fashion-admin-button primary large"
                        target="_blank">
                        <?php esc_html_e( 'Get Premium Version', 'wc-fashion' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>