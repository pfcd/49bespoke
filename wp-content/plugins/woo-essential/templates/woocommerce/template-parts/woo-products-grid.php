<?php

$product_id     = get_the_ID();
$product        = wc_get_product( $product_id );
$dnwoo_nonce    = wp_create_nonce( 'dnwoo-essential-nonce' );
$thumbnail_size = isset( $_POST['thumbnail_size'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['thumbnail_size'] ) ) : '';
$thumbnail      = get_the_post_thumbnail_url( $product_id, $thumbnail_size);
$permalink      = get_permalink( $product_id );
$product_type   = esc_attr( $product->get_type() );
$categorie_list = wc_get_product_category_list( get_the_ID(), ', ', '<li>', '</li>');
$cart_text      = esc_html__( 'Add to Cart', 'dnwooe' );
$product_rating = wc_get_rating_html($product->get_average_rating(), $product->get_rating_count());
$demo_image     = "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDUwMCA1MDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiAgICA8ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxwYXRoIGZpbGw9IiNFQkVCRUIiIGQ9Ik0wIDBoNTAwdjUwMEgweiIvPgogICAgICAgIDxyZWN0IGZpbGwtb3BhY2l0eT0iLjEiIGZpbGw9IiMwMDAiIHg9IjY4IiB5PSIzMDUiIHdpZHRoPSIzNjQiIGhlaWdodD0iNTY4IiByeD0iMTgyIi8+CiAgICAgICAgPGNpcmNsZSBmaWxsLW9wYWNpdHk9Ii4xIiBmaWxsPSIjMDAwIiBjeD0iMjQ5IiBjeT0iMTcyIiByPSIxMDAiLz4KICAgIDwvZz4KPC9zdmc+Cg==";

$data_icon_quickview = 'data-icon=""';

$dnwoo_nonce            = wp_create_nonce( 'dnwoo-essential-nonce' );
$show_add_to_cart_icon  = isset( $_POST['show_add_to_cart_icon'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['show_add_to_cart_icon'] ) ) : '';
$show_wish_list_icon    = isset( $_POST['show_wish_list_icon'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['show_wish_list_icon'] ) ) : '';
$show_add_compare_icon  = isset( $_POST['show_add_compare_icon'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['show_add_compare_icon'] ) ) : '';
$show_quickview_icon    = isset( $_POST['show_quickview_icon'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['show_quickview_icon'] ) ) : '';
$show_rating            = isset( $_POST['show_rating'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['show_rating'] ) ) : '';
$show_category          = isset( $_POST['show_category'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['show_category'] ) ) : '';
$show_price_text        = isset( $_POST['show_price_text'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['show_price_text'] ) ) : '';
$show_add_to_cart       = isset( $_POST['show_add_to_cart'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['show_add_to_cart'] ) ) : '';
$show_quick_view_button = isset( $_POST['show_quick_view_button'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['show_quick_view_button'] ) ) : '';
$show_featured_product  = isset( $_POST['show_featured_product'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['show_featured_product'] ) ) : '';
$featured_text          = isset( $_POST['featured_text'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['featured_text'] ) ) : '';
$show_badge             = isset( $_POST['show_badge'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['show_badge'] ) ) : '';
$sale_text              = isset( $_POST['sale_text'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['sale_text'] ) ) : '';
$percentage_text        = isset( $_POST['percentage_text'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['percentage_text'] ) ) : '';
$hide_out_of_stock      = isset( $_POST['hide_out_of_stock'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['hide_out_of_stock'] ) ) : '';
$outofstock_text        = isset( $_POST['outofstock_text'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['outofstock_text'] ) ) : '';
$addtocart_text         = isset( $_POST['addtocart_text'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['addtocart_text'] ) ) : '';
$select_option_text     = isset( $_POST['select_option_text'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['select_option_text'] ) ) : '';
$quickview_text         = isset( $_POST['dnwoo_quick_view_text'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['dnwoo_quick_view_text'] ) ) : '';
$header_level           = isset( $_POST['header_level'] ) || wp_verify_nonce( sanitize_key( $dnwoo_nonce ), 'product_grid_pagination' ) ? sanitize_text_field( wp_unslash( $_POST['header_level'] ) ) : '';

$carousel_layouts = isset( $_POST['carousel_layouts'] ) ? sanitize_text_field( wp_unslash( $_POST['carousel_layouts'] ) ) : '';

$orderclass = isset( $_POST['orderclass'] ) ? sanitize_text_field( wp_unslash( $_POST['orderclass'] ) ) : '';

?>
<li class="dnwoo_product_grid_item product_type_<?php echo esc_attr($product_type) ?>">
    <?php if( 'two' === $carousel_layouts ) : ?>
    <div class="dnwoo_product_imgwrap dnwoo_product_grid_overlay">
        <a href="<?php echo esc_url( $permalink ); ?>" class="dnwoo_product_img">
            <img class="img-fluid"
                src="<?php echo esc_url( $thumbnail ) ? esc_url( $thumbnail ) : esc_attr( $demo_image ); ?>"
                alt="<?php echo esc_attr( $product->get_name() ) ?>">
        </a>
        <div class="dnwoo_product_grid_badge">
            <?php 
                    global $product;
                    $out_of_stock = false;
                    if (!$product->is_in_stock() && !is_product()) {
                        $out_of_stock = true;
                    }
                
                    if ($product->is_on_sale() && !$out_of_stock) {
                
                        if ($product->get_type() == 'variable') {
                
                            $available_variations = $product->get_variation_prices();
                            $max_percentage = 0;
                
                            foreach ($available_variations['regular_price'] as $key => $regular_price) {
                                $sale_price = $available_variations['sale_price'][$key];
                
                                if ($sale_price < $regular_price) {
                                    $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                
                                    if ($percentage > $max_percentage) {
                                        $max_percentage = $percentage;
                                    }
                                }
                            }
                
                        $percentage = $max_percentage;
                        } elseif ($product->get_type() == 'simple' || $product->get_type() == 'external') {
                            $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
                        }
                
                        if ( 'percentage' == $show_badge ) { 
                            echo '<span class="dnwoo-onsale percent">'.esc_html($percentage .'% '). esc_html($percentage_text).'</span>';
                        } else if('sale' == $show_badge ) {
                            echo '<span class="dnwoo-onsale">'.esc_html($sale_text).'</span>';
                                
                        } else if('none' == $show_badge ) {
                            echo '';
                                
                        }
                    }

                    //Hot label
                    if($product->is_featured() && !$out_of_stock && ('on' === $show_featured_product)){
                        echo '<span class="dnwoo-featured">'.esc_html( $featured_text).'</span>';
                    }
                
                    //Out of Stock
                    if($out_of_stock && ('off' === $hide_out_of_stock)){
                        echo '<span class="dnwoo-stockout">'.esc_html($outofstock_text).'</span>';
                    } 
                ?>
        </div>
        <div class="dnwoo_product_Wrap">
            <ul class="list-unstyled dnwoo_icon_wrapgrid">
                <?php if( "on" === $show_add_to_cart_icon && 'variable' === $product_type) : ?>
                <li><a href="<?php echo 'variable' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_choose_variable_option_icon icon_menu"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon="a"></a></li>
                <?php elseif( "on" === $show_add_to_cart_icon ) : ?>
                <li><a href="<?php echo 'simple' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> add_to_cart_button ajax_add_to_cart icon_cart"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon=""></a></li>
                <?php endif; ?>
                <?php if( "on" === $show_wish_list_icon && function_exists( 'dnwoo_add_to_wishlist_button') ) :?>
                <li><?php echo dnwoo_add_to_wishlist_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_add_compare_icon ) : ?>
                <li><?php echo dnwoo_product_compare_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_quickview_icon ) : ?>
                <li><a href="#" class="dnwoo_product_grid_quick_button dnwoo-quickview icon_quickview" data-icon=""
                        data-quickid="<?php echo esc_attr( $product->get_id() ); ?>"
                        data-orderclass="<?php echo esc_attr( $orderclass ) ?>"></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <?php if( 0 < $product->get_rating_count() && 'on' === $show_rating ) : ?>
    <div class="dnwoo_product_ratting">
        <div class="star-rating">
            <span style="width:0%"><?php esc_html__('Rated', 'dnwooe') ?>
                <strong class="rating"><?php esc_html__('0', 'dnwooe') ?></strong>
                <?php esc_html__('out of 5', 'dnwooe') ?>
            </span>
            <?php echo $product_rating; // phpcs:ignore  ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if( 'on' === $show_category ) : ?>
    <div class="dnwoo_product_categories">
        <ul class="list-unstyled">
            <?php echo $categorie_list; // phpcs:ignore ?>
        </ul>
    </div>
    <?php endif; ?>
    <?php echo wp_kses_post('<'.$header_level.' class="dnwoo_product_grid_title">'); ?>
    <a href="<?php echo esc_url( $permalink ) ?>">
        <?php echo esc_html( $product->get_name() ); ?>
    </a>
    <?php echo wp_kses_post('</'.$header_level.'>'); ?>
    <?php if( 'on' === $show_price_text ) : ?>
    <div class="dnwoo_product_grid_price">
        <?php echo $product->get_price_html(); // phpcs:ignore ?>
    </div>
    <?php endif; ?>
    <div class="dnwoo_product_grid_buttons">

        <?php if( 'on' === $show_add_to_cart && 'variable' === $product_type ) : ?>
        <a href="<?php echo esc_url( $permalink ) ?>"
            class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_choose_variable_option"> <span
                class="icon_cart_btn" data-icon="a"></span><?php echo esc_html($select_option_text); ?></a>
        <?php elseif('on' === $show_add_to_cart) : ?>
        <a href="<?php echo 'simple' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='.esc_attr( $product_id ) ?>"
            data-quantity="1"
            class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_product_addtocart add_to_cart_button ajax_add_to_cart dnwoo_cart_text_button"
            data-product_id="<?php echo esc_attr( $product_id ) ?>"> <span class="icon_cart_btn"
                data-icon=""></span><?php echo esc_html($addtocart_text); ?></a>
        <?php endif; ?>

        <?php if( 'on' === $show_quick_view_button ) : ?>
        <a href="#" class="dnwoo_product_grid_quick_button dnwoo-quick-btn dnwoo-quickview"
            data-quickid="<?php echo esc_attr( $product->get_id() ); ?>"
            data-orderclass="<?php echo esc_attr( $orderclass ); ?>">
            <span class="icon_quickview_btn" data-icon=""></span><?php echo esc_html($quickview_text); ?>
        </a>
        <?php endif; ?>
    </div>
    <!-- Hey! I am Layout 3. Start Markup-->
    <?php elseif( 'three' === $carousel_layouts ) : ?>

    <div class="dnwoo_product_imgwrap">
        <div class="dnwoo_img_wrap dnwoo_product_grid_overlay">
            <a href="<?php echo esc_url( $permalink ); ?>" class="dnwoo_product_img">
                <img class="img-fluid"
                    src="<?php echo esc_url( $thumbnail ) ? esc_url( $thumbnail ) : esc_attr( $demo_image ); ?>"
                    alt="<?php echo esc_attr( $product->get_name() ) ?>">
            </a>
            <div class="dnwoo_product_grid_badge">
                <?php 
                        global $product;
                        $out_of_stock = false;
                        if (!$product->is_in_stock() && !is_product()) {
                            $out_of_stock = true;
                        }
                    
                        if ($product->is_on_sale() && !$out_of_stock) {
                    
                            if ($product->get_type() == 'variable') {
                    
                                $available_variations = $product->get_variation_prices();
                                $max_percentage = 0;
                    
                                foreach ($available_variations['regular_price'] as $key => $regular_price) {
                                    $sale_price = $available_variations['sale_price'][$key];
                    
                                    if ($sale_price < $regular_price) {
                                        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                    
                                        if ($percentage > $max_percentage) {
                                            $max_percentage = $percentage;
                                        }
                                    }
                                }
                    
                            $percentage = $max_percentage;
                            } elseif ($product->get_type() == 'simple' || $product->get_type() == 'external') {
                                $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
                            }
                    
                            if ( 'percentage' == $show_badge ) { 
                                echo '<span class="dnwoo-onsale percent">'.esc_html($percentage .'% '). esc_html($percentage_text).'</span>';
                            } else if('sale' == $show_badge ) {
                                echo '<span class="dnwoo-onsale">'.esc_html($sale_text).'</span>';
                                    
                            } else if('none' == $show_badge ) {
                                echo '';
                                    
                            }
                        }

                        //Hot label
                        if($product->is_featured() && !$out_of_stock && ('on' === $show_featured_product)){
                            echo '<span class="dnwoo-featured">'.esc_html( $featured_text).'</span>';
                        }
                    
                        //Out of Stock
                        if($out_of_stock && ('off' === $hide_out_of_stock)){
                            echo '<span class="dnwoo-stockout">'.esc_html($outofstock_text).'</span>';
                        } 
                    ?>
            </div>
        </div>
        <div class="dnwoo_product_Wrap">
            <ul class="list-unstyled dnwoo_icon_wrapgrid">
                <?php if( "on" === $show_add_to_cart_icon && 'variable' === $product_type) : ?>
                <li><a href="<?php echo 'variable' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_choose_variable_option_icon icon_menu"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon="a"></a></li>
                <?php elseif( "on" === $show_add_to_cart_icon ) : ?>
                <li><a href="<?php echo 'simple' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> add_to_cart_button ajax_add_to_cart icon_cart"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon=""></a></li>
                <?php endif; ?>
                <?php if( "on" === $show_wish_list_icon && function_exists( 'dnwoo_add_to_wishlist_button') ) :?>
                <li><?php echo dnwoo_add_to_wishlist_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_add_compare_icon ) : ?>
                <li><?php echo dnwoo_product_compare_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_quickview_icon ) : ?>
                <li><a href="#" class="dnwoo_product_grid_quick_button dnwoo-quickview icon_quickview" data-icon=""
                        data-quickid="<?php echo esc_attr( $product->get_id() ); ?>"
                        data-orderclass="<?php echo esc_attr( $orderclass ) ?>"></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="dnwoo_product_details_wrap">
        <div class="dnwoo_product_details">
            <?php echo wp_kses_post('<'.$header_level.' class="dnwoo_product_grid_title">'); ?>
            <a href="<?php echo esc_url( $permalink ) ?>">
                <?php echo esc_html( $product->get_name() ); ?>
            </a>
            <?php echo wp_kses_post('</'.$header_level.'>'); ?>
            <?php if( 'on' === $show_category ) : ?>
            <div class="dnwoo_product_categories">
                <ul class="list-unstyled">
                    <?php echo $categorie_list; // phpcs:ignore ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <?php if( 'on' === $show_price_text ) : ?>
        <div class="dnwoo_product_grid_price">
            <?php echo $product->get_price_html(); // phpcs:ignore ?>
        </div>
        <?php endif; ?>
    </div>
    <?php if( 0 < $product->get_rating_count() && 'on' === $show_rating ) : ?>
    <div class="dnwoo_product_ratting">
        <div class="star-rating"><span style="width:0%"><?php esc_html__('Rated', 'dnwooe') ?><strong
                    class="rating"><?php esc_html__('0', 'dnwooe') ?></strong><?php esc_html__('out of 5', 'dnwooe') ?></span><?php echo $product_rating; // phpcs:ignore ?>
        </div>
    </div>
    <?php endif; ?>
    <!-- Hey! I am Layout 3. End Markup-->

    <!-- Hey! I am Layout 4. Start Markup-->
    <?php elseif( 'four' === $carousel_layouts ) : ?>
    <div class="dnwoo_product_imgwrap">
        <div class="dnwoo_img_wrap dnwoo_product_grid_overlay">
            <a href="<?php echo esc_url( $permalink ); ?>" class="dnwoo_product_img">
                <img class="img-fluid"
                    src="<?php echo esc_url( $thumbnail ) ? esc_url( $thumbnail ) : esc_attr( $demo_image ); ?>"
                    alt="<?php echo esc_attr( $product->get_name() ) ?>">
            </a>
            <div class="dnwoo_product_grid_badge">
                <?php 
                        global $product;
                        $out_of_stock = false;
                        if (!$product->is_in_stock() && !is_product()) {
                            $out_of_stock = true;
                        }
                    
                        if ($product->is_on_sale() && !$out_of_stock) {
                    
                            if ($product->get_type() == 'variable') {
                    
                                $available_variations = $product->get_variation_prices();
                                $max_percentage = 0;
                    
                                foreach ($available_variations['regular_price'] as $key => $regular_price) {
                                    $sale_price = $available_variations['sale_price'][$key];
                    
                                    if ($sale_price < $regular_price) {
                                        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                    
                                        if ($percentage > $max_percentage) {
                                            $max_percentage = $percentage;
                                        }
                                    }
                                }
                    
                            $percentage = $max_percentage;
                            } elseif ($product->get_type() == 'simple' || $product->get_type() == 'external') {
                                $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
                            }
                    
                            if ( 'percentage' == $show_badge ) { 
                                echo '<span class="dnwoo-onsale percent">'.esc_html($percentage .'% '). esc_html($percentage_text).'</span>';
                            } else if('sale' == $show_badge ) {
                                echo '<span class="dnwoo-onsale">'.esc_html($sale_text).'</span>';
                                    
                            } else if('none' == $show_badge ) {
                                echo '';
                                    
                            }
                        }

                        //Hot label
                        if($product->is_featured() && !$out_of_stock && ('on' === $show_featured_product)){
                            echo '<span class="dnwoo-featured">'.esc_html( $featured_text).'</span>';
                        }
                    
                        //Out of Stock
                        if($out_of_stock && ('off' === $hide_out_of_stock)){
                            echo '<span class="dnwoo-stockout">'.esc_html($outofstock_text).'</span>';
                        } 
                    ?>
            </div>
        </div>
        <div class="dnwoo_product_Wrap">
            <ul class="list-unstyled dnwoo_icon_wrapgrid">
                <?php if( "on" === $show_add_to_cart_icon && 'variable' === $product_type) : ?>
                <li><a href="<?php echo 'variable' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_choose_variable_option_icon icon_menu"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon="a"></a></li>
                <?php elseif( "on" === $show_add_to_cart_icon ) : ?>
                <li><a href="<?php echo 'simple' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> add_to_cart_button ajax_add_to_cart icon_cart"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon=""></a></li>
                <?php endif; ?>
                <?php if( "on" === $show_wish_list_icon && function_exists( 'dnwoo_add_to_wishlist_button') ) :?>
                <li><?php echo dnwoo_add_to_wishlist_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_add_compare_icon ) : ?>
                <li><?php echo dnwoo_product_compare_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_quickview_icon ) : ?>
                <li><a href="#" class="dnwoo_product_grid_quick_button dnwoo-quickview icon_quickview" data-icon=""
                        data-quickid="<?php echo esc_attr( $product->get_id() ); ?>"
                        data-orderclass="<?php echo esc_attr( $orderclass ) ?>"></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="dnwoo_product_details_wrap">
        <?php if( 'on' === $show_category ) : ?>
        <div class="dnwoo_product_categories">
            <ul class="list-unstyled">
                <?php echo $categorie_list; // phpcs:ignore ?>
            </ul>
        </div>
        <?php endif; ?>
        <div class="dnwoo_product_details">
            <?php echo wp_kses_post('<'.$header_level.' class="dnwoo_product_grid_title">'); ?>
            <a href="<?php echo esc_url( $permalink ) ?>">
                <?php echo esc_html( $product->get_name() ); ?>
            </a>
            <?php echo wp_kses_post('</'.$header_level.'>'); ?>
            <?php if( 0 < $product->get_rating_count() && 'on' === $show_rating ) : ?>
            <div class="dnwoo_product_ratting">
                <div class="star-rating"><span style="width:0%"><?php esc_html__('Rated', 'dnwooe') ?><strong
                            class="rating"><?php esc_html__('0', 'dnwooe') ?></strong><?php esc_html__('out of 5', 'dnwooe') ?></span><?php echo $product_rating; // phpcs:ignore ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php if( 'on' === $show_price_text ) : ?>
        <div class="dnwoo_product_grid_price">
            <?php echo $product->get_price_html(); // phpcs:ignore ?>
        </div>
        <?php endif; ?>
    </div>
    <!-- Hey! I am Layout 4. End Markup -->

    <!-- Hey! I am Layout 5. Start Markup-->
    <?php elseif( 'five' === $carousel_layouts ) : ?>
    <div class="dnwoo_product_imgwrap">
        <div class="dnwoo_img_wrap dnwoo_product_grid_overlay">
            <a href="<?php echo esc_url( $permalink ); ?>" class="dnwoo_product_img">
                <img class="img-fluid"
                    src="<?php echo esc_url( $thumbnail ) ? esc_url( $thumbnail ) : esc_attr( $demo_image ); ?>"
                    alt="<?php echo esc_attr( $product->get_name() ) ?>">
            </a>
            <div class="dnwoo_product_grid_badge">
                <?php 
                        global $product;
                        $out_of_stock = false;
                        if (!$product->is_in_stock() && !is_product()) {
                            $out_of_stock = true;
                        }
                    
                        if ($product->is_on_sale() && !$out_of_stock) {
                    
                            if ($product->get_type() == 'variable') {
                    
                                $available_variations = $product->get_variation_prices();
                                $max_percentage = 0;
                    
                                foreach ($available_variations['regular_price'] as $key => $regular_price) {
                                    $sale_price = $available_variations['sale_price'][$key];
                    
                                    if ($sale_price < $regular_price) {
                                        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                    
                                        if ($percentage > $max_percentage) {
                                            $max_percentage = $percentage;
                                        }
                                    }
                                }
                    
                            $percentage = $max_percentage;
                            } elseif ($product->get_type() == 'simple' || $product->get_type() == 'external') {
                                $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
                            }
                    
                            if ( 'percentage' == $show_badge ) { 
                                echo '<span class="dnwoo-onsale percent">'.esc_html($percentage .'% '). esc_html($percentage_text).'</span>';
                            } else if('sale' == $show_badge ) {
                                echo '<span class="dnwoo-onsale">'.esc_html($sale_text).'</span>';
                                    
                            } else if('none' == $show_badge ) {
                                echo '';
                                    
                            }
                        }

                        //Hot label
                        if($product->is_featured() && !$out_of_stock && ('on' === $show_featured_product)){
                            echo '<span class="dnwoo-featured">'.esc_html( $featured_text).'</span>';
                        }
                    
                        //Out of Stock
                        if($out_of_stock && ('off' === $hide_out_of_stock)){
                            echo '<span class="dnwoo-stockout">'.esc_html($outofstock_text).'</span>';
                        } 
                    ?>
            </div>
        </div>
        <div class="dnwoo_product_Wrap">
            <ul class="list-unstyled dnwoo_icon_wrapgrid">
                <?php if( "on" === $show_add_to_cart_icon && 'variable' === $product_type) : ?>
                <li><a href="<?php echo 'variable' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_choose_variable_option_icon icon_menu"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon="a"></a></li>
                <?php elseif( "on" === $show_add_to_cart_icon ) : ?>
                <li><a href="<?php echo 'simple' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> add_to_cart_button ajax_add_to_cart icon_cart"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon=""></a></li>
                <?php endif; ?>
                <?php if( "on" === $show_wish_list_icon && function_exists( 'dnwoo_add_to_wishlist_button') ) :?>
                <li><?php echo dnwoo_add_to_wishlist_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_add_compare_icon ) : ?>
                <li><?php echo dnwoo_product_compare_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_quickview_icon ) : ?>
                <li><a href="#" class="dnwoo_product_grid_quick_button dnwoo-quickview icon_quickview" data-icon=""
                        data-quickid="<?php echo esc_attr( $product->get_id() ); ?>"
                        data-orderclass="<?php echo esc_attr( $orderclass ) ?>"></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="dnwoo_product_details_wrap">
        <div class="dnwoo_product_details">
            <?php echo wp_kses_post('<'.$header_level.' class="dnwoo_product_grid_title">'); ?>
            <a href="<?php echo esc_url( $permalink ) ?>">
                <?php echo esc_html( $product->get_name() ); ?>
            </a>
            <?php echo wp_kses_post('</'.$header_level.'>'); ?>
            <?php if( 'on' === $show_category ) : ?>
            <div class="dnwoo_product_categories">
                <ul class="list-unstyled">
                    <?php echo $categorie_list; // phpcs:ignore ?>
                </ul>
            </div>
            <?php endif; ?>
            <?php if( 0 < $product->get_rating_count() && 'on' === $show_rating ) : ?>
            <div class="dnwoo_product_ratting">
                <div class="star-rating"><span style="width:0%"><?php esc_html__('Rated', 'dnwooe') ?><strong
                            class="rating"><?php esc_html__('0', 'dnwooe') ?></strong><?php esc_html__('out of 5', 'dnwooe') ?></span><?php echo $product_rating; // phpcs:ignore ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php if( 'on' === $show_price_text ) : ?>
        <div class="dnwoo_product_grid_price">
            <?php echo $product->get_price_html(); // phpcs:ignore ?>
        </div>
        <?php endif; ?>
    </div>
    <!-- Hey! I am Layout 5. End Markup -->

    <!-- Hey! I am Layout 6. Start Markup-->
    <?php elseif( 'six' === $carousel_layouts ) : ?>
    <div class="dnwoo_product_imgwrap">
        <div class="dnwoo_img_wrap dnwoo_product_grid_overlay">
            <a href="<?php echo esc_url( $permalink ); ?>" class="dnwoo_product_img">
                <img class="img-fluid"
                    src="<?php echo esc_url( $thumbnail ) ? esc_url( $thumbnail ) : esc_attr( $demo_image ); ?>"
                    alt="<?php echo esc_attr( $product->get_name() ) ?>">
            </a>
            <div class="dnwoo_product_grid_badge">
                <?php 
                        global $product;
                        $out_of_stock = false;
                        if (!$product->is_in_stock() && !is_product()) {
                            $out_of_stock = true;
                        }
                    
                        if ($product->is_on_sale() && !$out_of_stock) {
                    
                            if ($product->get_type() == 'variable') {
                    
                                $available_variations = $product->get_variation_prices();
                                $max_percentage = 0;
                    
                                foreach ($available_variations['regular_price'] as $key => $regular_price) {
                                    $sale_price = $available_variations['sale_price'][$key];
                    
                                    if ($sale_price < $regular_price) {
                                        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                    
                                        if ($percentage > $max_percentage) {
                                            $max_percentage = $percentage;
                                        }
                                    }
                                }
                    
                            $percentage = $max_percentage;
                            } elseif ($product->get_type() == 'simple' || $product->get_type() == 'external') {
                                $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
                            }
                    
                            if ( 'percentage' == $show_badge ) { 
                                echo '<span class="dnwoo-onsale percent">'.esc_html($percentage .'% '). esc_html($percentage_text).'</span>';
                            } else if('sale' == $show_badge ) {
                                echo '<span class="dnwoo-onsale">'.esc_html($sale_text).'</span>';
                                    
                            } else if('none' == $show_badge ) {
                                echo '';
                                    
                            }
                        }

                        //Hot label
                        if($product->is_featured() && !$out_of_stock && ('on' === $show_featured_product)){
                            echo '<span class="dnwoo-featured">'.esc_html( $featured_text).'</span>';
                        }
                    
                        //Out of Stock
                        if($out_of_stock && ('off' === $hide_out_of_stock)){
                            echo '<span class="dnwoo-stockout">'.esc_html($outofstock_text).'</span>';
                        } 
                    ?>
            </div>
        </div>
    </div>
    <div class="dnwoo_product_overlay_content">
        <div class="dnwoo_product_details_wrap">
            <div class="dnwoo_product_details">
                <div class="dnwoo_product_title_wrap">
                    <?php echo wp_kses_post('<'.$header_level.' class="dnwoo_product_grid_title">'); ?>
                    <a href="<?php echo esc_url( $permalink ) ?>">
                        <?php echo esc_html( $product->get_name() ); ?>
                    </a>
                    <?php echo wp_kses_post('</'.$header_level.'>'); ?>
                    <?php if( 0 < $product->get_rating_count() && 'on' === $show_rating ) : ?>
                    <div class="dnwoo_product_ratting">
                        <div class="star-rating"><span
                                style="width:0%"><?php esc_html__('Rated', 'dnwooe') ?><strong
                                    class="rating"><?php esc_html__('0', 'dnwooe') ?></strong><?php esc_html__('out of 5', 'dnwooe') ?></span><?php echo $product_rating; // phpcs:ignore ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if( 'on' === $show_category ) : ?>
                    <div class="dnwoo_product_categories">
                        <ul class="list-unstyled">
                            <?php echo $categorie_list; // phpcs:ignore ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if( 'on' === $show_price_text ) : ?>
                <div class="dnwoo_product_grid_price">
                    <?php echo $product->get_price_html(); // phpcs:ignore ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="dnwoo_product_Wrap">
                <ul class="list-unstyled dnwoo_icon_wrapgrid">
                    <?php if( "on" === $show_add_to_cart_icon && 'variable' === $product_type) : ?>
                    <li><a href="<?php echo 'variable' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                            data-quantity="1"
                            class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_choose_variable_option_icon icon_menu"
                            data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon="a"></a></li>
                    <?php elseif( "on" === $show_add_to_cart_icon ) : ?>
                    <li><a href="<?php echo 'simple' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                            data-quantity="1"
                            class="product_type_<?php echo esc_attr( $product_type ) ?> add_to_cart_button ajax_add_to_cart icon_cart"
                            data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon=""></a></li>
                    <?php endif; ?>
                    <?php if( "on" === $show_wish_list_icon && function_exists( 'dnwoo_add_to_wishlist_button') ) :?>
                    <li><?php echo dnwoo_add_to_wishlist_button(); // phpcs:ignore ?></li>
                    <?php endif; ?>
                    <?php if( "on" === $show_add_compare_icon ) : ?>
                    <li><?php echo dnwoo_product_compare_button(); // phpcs:ignore ?></li>
                    <?php endif; ?>
                    <?php if( "on" === $show_quickview_icon ) : ?>
                    <li><a href="#" class="dnwoo_product_grid_quick_button dnwoo-quickview icon_quickview" data-icon=""
                            data-quickid="<?php echo esc_attr( $product->get_id() ); ?>"
                            data-orderclass="<?php echo esc_attr( $orderclass ) ?>"></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- Hey! I am Layout 6. End Markup -->

    <!-- Hey! I am Layout 7. Start Markup-->
    <?php elseif( 'seven' === $carousel_layouts ) : ?>
    <div class="dnwoo_product_imgwrap dnwoo_product_grid_overlay">
        <div class="dnwoo_product_grid_badge">
            <?php 
                    global $product;
                    $out_of_stock = false;
                    if (!$product->is_in_stock() && !is_product()) {
                        $out_of_stock = true;
                    }
                
                    if ($product->is_on_sale() && !$out_of_stock) {
                
                        if ($product->get_type() == 'variable') {
                
                            $available_variations = $product->get_variation_prices();
                            $max_percentage = 0;
                
                            foreach ($available_variations['regular_price'] as $key => $regular_price) {
                                $sale_price = $available_variations['sale_price'][$key];
                
                                if ($sale_price < $regular_price) {
                                    $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                
                                    if ($percentage > $max_percentage) {
                                        $max_percentage = $percentage;
                                    }
                                }
                            }
                
                        $percentage = $max_percentage;
                        } elseif ($product->get_type() == 'simple' || $product->get_type() == 'external') {
                            $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
                        }
                
                        if ( 'percentage' == $show_badge ) { 
                            echo '<span class="dnwoo-onsale percent">'.esc_html($percentage .'% '). esc_html($percentage_text).'</span>';
                        } else if('sale' == $show_badge ) {
                            echo '<span class="dnwoo-onsale">'.esc_html($sale_text).'</span>';
                                
                        } else if('none' == $show_badge ) {
                            echo '';
                                
                        }
                    }

                    //Hot label
                    if($product->is_featured() && !$out_of_stock && ('on' === $show_featured_product)){
                        echo '<span class="dnwoo-featured">'.esc_html( $featured_text).'</span>';
                    }
                
                    //Out of Stock
                    if($out_of_stock && ('off' === $hide_out_of_stock)){
                        echo '<span class="dnwoo-stockout">'.esc_html($outofstock_text).'</span>';
                    } 
                ?>
        </div>
        <a href="<?php echo esc_url( $permalink ); ?>" class="dnwoo_product_img">
            <img class="img-fluid"
                src="<?php echo esc_url( $thumbnail ) ? esc_url( $thumbnail ) : esc_attr( $demo_image ); ?>"
                alt="<?php echo esc_attr( $product->get_name() ) ?>">
        </a>
        <div class="dnwoo_product_Wrap">
            <ul class="list-unstyled dnwoo_icon_wrapgrid">
                <?php if( "on" === $show_add_to_cart_icon && 'variable' === $product_type) : ?>
                <li><a href="<?php echo 'variable' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_choose_variable_option_icon icon_menu"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon="a"></a></li>
                <?php elseif( "on" === $show_add_to_cart_icon ) : ?>
                <li><a href="<?php echo 'simple' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> add_to_cart_button ajax_add_to_cart icon_cart"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon=""></a></li>
                <?php endif; ?>
                <?php if( "on" === $show_wish_list_icon && function_exists( 'dnwoo_add_to_wishlist_button') ) :?>
                <li><?php echo dnwoo_add_to_wishlist_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_add_compare_icon ) : ?>
                <li><?php echo dnwoo_product_compare_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_quickview_icon ) : ?>
                <li><a href="#" class="dnwoo_product_grid_quick_button dnwoo-quickview icon_quickview" data-icon=""
                        data-quickid="<?php echo esc_attr( $product->get_id() ); ?>"
                        data-orderclass="<?php echo esc_attr( $orderclass ) ?>"></a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="dnwoo_product_content">
            <?php if( 0 < $product->get_rating_count() && 'on' === $show_rating ) : ?>
            <div class="dnwoo_product_ratting">
                <div class="star-rating">
                    <span style="width:0%"><?php esc_html__('Rated', 'dnwooe') ?>
                        <strong
                            class="rating"><?php esc_html__('0', 'dnwooe') ?></strong><?php esc_html__('out of 5', 'dnwooe') ?>
                    </span><?php echo $product_rating; // phpcs:ignore ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="dnwoo_product_categories">
                <?php if( 'on' === $show_category ) : ?>
                <div class="dnwoo_product_categories">
                    <ul class="list-unstyled">
                        <?php echo $categorie_list; // phpcs:ignore ?>
                    </ul>
                </div>
                <?php endif; ?>
                <?php echo wp_kses_post('<'.$header_level.' class="dnwoo_product_grid_title">'); ?>
                <a href="<?php echo esc_url( $permalink ) ?>">
                    <?php echo esc_html( $product->get_name() ); ?>
                </a>
                <?php echo wp_kses_post('</'.$header_level.'>'); ?>
                <?php if( 'on' === $show_price_text ) : ?>
                <div class="dnwoo_product_grid_price">
                    <?php echo $product->get_price_html(); // phpcs:ignore ?>
                </div>
                <?php endif; ?>

                <?php if( 'on' === $show_add_to_cart ) : ?>
                <div class="dnwoo_product_grid_buttons">
                    <?php if('variable' === $product_type ) : ?>
                    <a href="<?php echo esc_url( $permalink ) ?>"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_choose_variable_option"> <span
                            class="icon_cart_btn" data-icon="a"></span><?php echo esc_html($select_option_text); ?></a>
                    <?php else : ?>
                    <a href="<?php echo 'simple' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='.esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_product_addtocart add_to_cart_button ajax_add_to_cart dnwoo_cart_text_button"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>"><span class="icon_cart_btn"
                            data-icon=""></span><?php echo esc_html($addtocart_text); ?></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- Hey! I am Layout 7. End Markup -->

    <!-- Hey! I am Layout 8. Start Markup-->
    <?php elseif( 'eight' === $carousel_layouts ) : ?>
    <div class="dnwoo_product_imgwrap dnwoo_product_grid_overlay">
        <div class="dnwoo_product_grid_badge">
            <?php 
                    global $product;
                    $out_of_stock = false;
                    if (!$product->is_in_stock() && !is_product()) {
                        $out_of_stock = true;
                    }
                
                    if ($product->is_on_sale() && !$out_of_stock) {
                
                        if ($product->get_type() == 'variable') {
                
                            $available_variations = $product->get_variation_prices();
                            $max_percentage = 0;
                
                            foreach ($available_variations['regular_price'] as $key => $regular_price) {
                                $sale_price = $available_variations['sale_price'][$key];
                
                                if ($sale_price < $regular_price) {
                                    $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                
                                    if ($percentage > $max_percentage) {
                                        $max_percentage = $percentage;
                                    }
                                }
                            }
                
                        $percentage = $max_percentage;
                        } elseif ($product->get_type() == 'simple' || $product->get_type() == 'external') {
                            $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
                        }
                
                        if ( 'percentage' == $show_badge ) { 
                            echo '<span class="dnwoo-onsale percent">'.esc_html($percentage .'% '). esc_html($percentage_text).'</span>';
                        } else if('sale' == $show_badge ) {
                            echo '<span class="dnwoo-onsale">'.esc_html($sale_text).'</span>';
                                
                        } else if('none' == $show_badge ) {
                            echo '';
                                
                        }
                    }

                    //Hot label
                    if($product->is_featured() && !$out_of_stock && ('on' === $show_featured_product)){
                        echo '<span class="dnwoo-featured">'.esc_html( $featured_text).'</span>';
                    }
                
                    //Out of Stock
                    if($out_of_stock && ('off' === $hide_out_of_stock)){
                        echo '<span class="dnwoo-stockout">'.esc_html($outofstock_text).'</span>';
                    } 
                ?>
        </div>
        <a href="<?php echo esc_url( $permalink ); ?>" class="dnwoo_product_img">
            <img class="img-fluid dnwoo_product_image"
                src="<?php echo esc_url( $thumbnail ) ? esc_url( $thumbnail ) : esc_attr( $demo_image ); ?>"
                alt="<?php echo esc_attr( $product->get_name() ) ?>">
        </a>
        <?php if( 'on' === $show_add_to_cart ) : ?>
        <div class="dnwoo_product_grid_buttons">
            <?php if( 'variable' === $product_type ) : ?>
            <a href="<?php echo esc_url( $permalink ) ?>"
                class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_choose_variable_option"> <span
                    class="icon_cart_btn" data-icon="a"></span><?php echo esc_html($select_option_text); ?></a>
            <?php else : ?>
            <a href="<?php echo 'simple' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='.esc_attr( $product_id ) ?>"
                data-quantity="1"
                class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_product_addtocart add_to_cart_button ajax_add_to_cart dnwoo_cart_text_button"
                data-product_id="<?php echo esc_attr( $product_id ) ?>"><span class="icon_cart_btn"
                    data-icon=""></span><?php echo esc_html($addtocart_text); ?></a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="dnwoo_product_Wrap">
            <ul class="list-unstyled dnwoo_icon_wrapgrid">
                <?php if( "on" === $show_add_to_cart_icon && 'variable' === $product_type) : ?>
                <li><a href="<?php echo 'variable' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_choose_variable_option_icon icon_menu"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon="a"></a></li>
                <?php elseif( "on" === $show_add_to_cart_icon ) : ?>
                <li><a href="<?php echo 'simple' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> add_to_cart_button ajax_add_to_cart icon_cart"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon=""></a></li>
                <?php endif; ?>
                <?php if( "on" === $show_wish_list_icon && function_exists( 'dnwoo_add_to_wishlist_button') ) :?>
                <li><?php echo dnwoo_add_to_wishlist_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_add_compare_icon ) : ?>
                <li><?php echo dnwoo_product_compare_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_quickview_icon ) : ?>
                <li><a href="#" class="dnwoo_product_grid_quick_button dnwoo-quickview icon_quickview" data-icon=""
                        data-quickid="<?php echo esc_attr( $product->get_id() ); ?>"
                        data-orderclass="<?php echo esc_attr( $orderclass ) ?>"></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="dnwoo_product_content">
        <div class="dnwoo_product_categories">
            <?php if( 0 < $product->get_rating_count() && 'on' === $show_rating ) : ?>
            <div class="dnwoo_product_ratting">
                <div class="star-rating">
                    <span style="width:0%"><?php esc_html__('Rated', 'dnwooe') ?>
                        <strong
                            class="rating"><?php esc_html__('0', 'dnwooe') ?></strong><?php esc_html__('out of 5', 'dnwooe') ?>
                    </span><?php echo $product_rating; // phpcs:ignore ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if( 'on' === $show_category ) : ?>
            <ul class="list-unstyled">
                <?php echo $categorie_list; // phpcs:ignore ?>
            </ul>
            <?php endif; ?>
            <?php echo wp_kses_post('<'.$header_level.' class="dnwoo_product_grid_title">'); ?>
            <a href="<?php echo esc_url( $permalink ) ?>">
                <?php echo esc_html( $product->get_name() ); ?>
            </a>
            <?php echo wp_kses_post('</'.$header_level.'>'); ?>
            <?php if( 'on' === $show_price_text ) : ?>
            <div class="dnwoo_product_grid_price">
                <?php echo $product->get_price_html(); // phpcs:ignore ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php else : ?>
    <div class="dnwoo_product_grid_img dnwoo_product_grid_overlay">
        <a class="dnwoo_product_img" href="<?php echo esc_url( $permalink ) ?>">
            <img class="img-fluid" src="<?php echo $thumbnail ? esc_url( $thumbnail ) : esc_attr( $demo_image ); ?>"
                alt="<?php echo esc_attr( $product->get_name() ); ?>">
        </a>
        <div class="dnwoo_product_grid_badge">
            <?php 
                        global $product;
                        $out_of_stock = false;
                        if (!$product->is_in_stock() && !is_product()) {
                            $out_of_stock = true;
                        }
                    
                        if ($product->is_on_sale() && !$out_of_stock) {
                    
                            if ($product->get_type() == 'variable') {
                    
                                $available_variations = $product->get_variation_prices();
                                $max_percentage = 0;
                    
                                foreach ($available_variations['regular_price'] as $key => $regular_price) {
                                    $sale_price = $available_variations['sale_price'][$key];
                    
                                    if ($sale_price < $regular_price) {
                                        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                    
                                        if ($percentage > $max_percentage) {
                                            $max_percentage = $percentage;
                                        }
                                    }
                                }
                    
                            $percentage = $max_percentage;
                            } elseif ($product->get_type() == 'simple' || $product->get_type() == 'external') {
                                $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
                            }
                    
                            if ( 'percentage' == $show_badge ) { 
                                echo '<span class="dnwoo-onsale percent">'.esc_html($percentage .'% '). esc_html($percentage_text).'</span>';
                            } else if('sale' == $show_badge ) {
                                echo '<span class="dnwoo-onsale">'.esc_html($sale_text).'</span>';
                                    
                            } else if('none' == $show_badge ) {
                                echo '';
                                    
                            }
                        }

                        //Hot label
                        if($product->is_featured() && !$out_of_stock && ('on' === $show_featured_product)){
                            echo '<span class="dnwoo-featured">'.esc_html( $featured_text).'</span>';
                        }
                    
                        //Out of Stock
                        if($out_of_stock && ('off' === $hide_out_of_stock)){
                            echo '<span class="dnwoo-stockout">'.esc_html($outofstock_text).'</span>';
                        } 
                ?>
        </div>
        <div class="dnwoo_product_Wrap">
            <ul class="list-unstyled dnwoo_icon_wrapgrid">
                <?php if( "on" === $show_add_to_cart_icon && 'variable' === $product_type) : ?>
                <li><a href="<?php echo 'variable' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_choose_variable_option_icon icon_menu"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon="a"></a></li>
                <?php elseif( "on" === $show_add_to_cart_icon ) : ?>
                <li><a href="<?php echo 'simple' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='. esc_attr( $product_id ) ?>"
                        data-quantity="1"
                        class="product_type_<?php echo esc_attr( $product_type ) ?> add_to_cart_button ajax_add_to_cart icon_cart"
                        data-product_id="<?php echo esc_attr( $product_id ) ?>" data-icon=""></a></li>
                <?php endif; ?>
                <?php if( "on" === $show_wish_list_icon && function_exists( 'dnwoo_add_to_wishlist_button') ) :?>
                <li><?php echo dnwoo_add_to_wishlist_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_add_compare_icon ) : ?>
                <li><?php echo dnwoo_product_compare_button(); // phpcs:ignore ?></li>
                <?php endif; ?>
                <?php if( "on" === $show_quickview_icon ) : ?>
                <li><a href="#" class="dnwoo_product_grid_quick_button dnwoo-quick-btn dnwoo-quickview icon_quickview"
                        data-icon="" data-quickid="<?php echo esc_attr( $product->get_id() ); ?>"
                        data-orderclass="<?php echo esc_attr( $orderclass ) ?>"></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="dnwoo-category-rating-container">
        <?php if( 'on' === $_POST['show_category'] ) : ?>
        <div class="dnwoo_product_categories">
            <ul class="list-unstyled">
                <?php echo $categorie_list; // phpcs:ignore ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if( 0 < $product->get_rating_count() && 'on' === $show_rating ) : ?>
        <div class="dnwoo_product_ratting">
            <div class="star-rating">
                <span style="width:0%"><?php esc_html__('Rated', 'dnwooe') ?>
                    <strong
                        class="rating"><?php esc_html__('0', 'dnwooe') ?></strong><?php esc_html__('out of 5', 'dnwooe') ?>
                </span><?php echo $product_rating; // phpcs:ignore ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php echo wp_kses_post('<'.$header_level.' class="dnwoo_product_grid_title">'); ?>
    <a href="<?php echo esc_url( $permalink ) ?>">
        <?php echo esc_html( $product->get_name() ) ?>
    </a>
    <?php echo wp_kses_post('</'.$header_level.'>'); ?>
    <?php if( 'on' === $_POST['show_price_text']) : ?>
    <div class="dnwoo_product_grid_price">
        <?php echo $product->get_price_html(); // phpcs:ignore ?>
    </div>
    <?php endif; ?>

    <div class="dnwoo_product_grid_buttons">
        <?php if( 'on' === $show_add_to_cart ): ?>
        <?php if('variable' === $product_type ) : ?>
        <a href="<?php echo esc_url( $permalink ) ?>"
            class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_choose_variable_option"> <span
                class="icon_cart_btn" data-icon="a"></span><?php echo esc_html($select_option_text); ?></a>
        <?php else : ?>
        <a href="<?php echo 'simple' == $product->get_type() ? esc_url( $permalink ) : '?add-to-cart='.esc_attr( $product_id ) ?>"
            data-quantity="1"
            class="product_type_<?php echo esc_attr( $product_type ) ?> dnwoo_product_addtocart add_to_cart_button ajax_add_to_cart dnwoo_cart_text_button"
            data-product_id="<?php echo esc_attr( $product_id ) ?>"><span class="icon_cart_btn"
                data-icon=""></span><?php echo esc_html($addtocart_text); ?></a>
        <?php endif; ?>
        <?php endif; ?>

        <?php if( 'on' === $show_quick_view_button ) : ?>
        <a href="#" class="dnwoo_product_grid_quick_button dnwoo-quick-btn dnwoo-quickview"
            data-quickid="<?php echo esc_attr( $product->get_id() ); ?>"
            data-orderclass="<?php echo esc_attr( $orderclass ); ?>">
            <span class="icon_quickview_btn" data-icon=""></span><?php echo esc_html($quickview_text); ?>
        </a>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</li>