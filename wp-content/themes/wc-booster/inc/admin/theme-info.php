<?php
$pro_purchase_url = "https://www.eaglevisionit.com/downloads/wc-booster/";
$doc_url = "https://www.eaglevisionit.com/downloads/wc-booster/";
$live_demo_url = "https://demos.eaglevisionit.com/wc-booster-pro/";
$support_url = "https://www.eaglevisionit.com/contact-us/";

$theme_name = esc_html( $theme->Name );
$free_theme_name = str_replace( ' Pro', '',$theme_name );
?>
<div class="wc-booster--about-page--wrapper">
    <div id="wc-booster-admin-about-page">
        <div class="wc-booster-admin-card-header">
            <div class="wc-booster-header-left">
                <h2>
                    <?php echo esc_html( $theme->Name ); ?>
                </h2>
                <p>
                    <?php esc_html_e( 'WC Booster - A Multipurpose, browser & device-friendly Full Site Editing Theme for WordPress', 'wc-booster' ); ?>
                </p>

            </div>
            <div class="wc-booster-header-right">
                <div class="wc-booster-card-header-button-group">
                    <a href="<?php echo esc_url( $live_demo_url ); ?>" class="wc-booster-admin-button premium-button" target="_blank"
                        rel="noreferrer"><span class="dashicons dashicons-book-alt"></span>
                        <?php esc_html_e( 'Pro Live Demo', 'wc-booster' ); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="feature-list">
            <div class="wc-booster-about-container">
                <div class="wc-booster-admin-card features">
                    <div class="wc-booster-about-container wc-booster-compare-table">
                        <div class="admin-grid-1">
                            <h3>
                                <?php echo esc_html( $free_theme_name ); ?>
                                <?php esc_html_e( 'Free Vs Pro', 'wc-booster' ); ?>
                            </h3>
                            <p class="wc-booster-compare-table-subtitle"><a href="<?php echo esc_url( $pro_purchase_url ) ; ?>"
                                    target="__blank">
                                    <?php echo esc_html( 'Get WC Booster Pro', 'wc-booster' ); ?>
                                    <i class="dashicons dashicons-arrow-right-alt"></i>
                                </a></p>
                            <table>
                                <thead>
                                    <tr>
                                        <th>
                                            <?php echo esc_html( $theme->Name ); ?>
                                            <?php esc_html_e( 'Free', 'wc-booster' ); ?>
                                            <?php esc_html_e( '( Limited blocks available )', 'wc-booster' ); ?>
                                            
                                        </th>
                                        <th>
                                            <?php esc_html_e( 'Features', 'wc-booster' ); ?>
                                        </th>
                                        <th>
                                            <?php esc_html_e( 'WC Booster Pro ( More Blocks & Settings available )', 'wc-booster' ); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Easy Setup', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Responsive Desgin', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'SEO Friendly', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( '24/7 premium support', 'wc-booster' ); ?>
                                        </td>
                                        <td><?php esc_html_e( 'High-Priority Dedicated Support', 'wc-booster' ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Different niches starter sites', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Secure transaction', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Lifetime Updates', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'No coding required', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td class="table-header">
                                            <?php esc_html_e( 'WooCommerce', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Mini Cart', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Upsells', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Multi Steps', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Sticky cart', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Bulk Variation', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Quick View', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td  class="table-header">
                                            <?php esc_html_e( 'Elementor', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Drag and Drop functionality', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'One Click Demo Import', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( ' Featured Slider', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Typography and color options', 'wc-booster' ); ?>
                                        </td>
                                        <td><?php esc_html_e( 'Unlimited', 'wc-booster' ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Import components/ templates', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'One Click Demo Import', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td  class="table-header">
                                            <?php esc_html_e( 'Gutenberg block editor', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Profile card (Block)', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Blog (block)', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Unlimited', 'wc-booster' ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Carousel Post (Block)', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Unlimited', 'wc-booster' ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Testimonials(block)', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'News Block', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Templates and block patterns', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Advanced Color Options', 'wc-booster' ); ?>
                                        </td>
                                        <td><?php esc_html_e( 'Unlimited', 'wc-booster' ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td  class="table-header">
                                            <?php esc_html_e( 'Theme Options', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Enable Mini Cart On Header', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Enable Testimonial Slider', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Enable Sponsor Slider', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Enable Sticky Header', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td  class="table-header">
                                            <?php esc_html_e( 'Full Site Editing/Site Editor', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Limited Features', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Block themes', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-no"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Style variations', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e( 'Limited', 'wc-booster' ); ?>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Block patterns and template parts', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Global style Interface', 'wc-booster' ); ?>
                                        </td>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="dashicons dashicons-yes"></span>
                                        </td>
                                        <td>
                                            <?php esc_html_e( 'Edit each areas of website(header, footer, sidebar)', 'wc-booster' ); ?>
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
            <div class="wc-booster-about-side">
                <div class="wc-booster-admin-card cart-two">
                    <h3 class="wc-booster-admin-card-title is-small">
                        <?php esc_html_e( 'Questions Welcome - We\'re here to help', 'wc-booster' ); ?>
                    </h3>
                    <p>
                        <?php esc_html_e( 'Fearless Setup - Our Dedicated Team will have your website up in minutes', 'wc-booster' ); ?>
                    </p><a href="<?php echo esc_url(  $support_url ); ?>" class="wc-booster-admin-button primary large"
                        target="_blank">
                        <?php esc_html_e( 'Get Support', 'wc-booster' ); ?>
                    </a>
                    <a href="<?php echo $pro_purchase_url; ?>" class="wc-booster-admin-button primary large"
                        target="_blank">
                        <?php esc_html_e( 'Get Premium Version', 'wc-booster' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>