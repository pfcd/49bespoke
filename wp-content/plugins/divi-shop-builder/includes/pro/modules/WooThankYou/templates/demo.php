<div class="woocommerce">
    <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo esc_html($this->props['order_received_msg']); ?></p>
    <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
        <li class="woocommerce-order-overview__order order">
            <?php echo esc_html($this->props['order_number_text']); ?>
            <strong>123</strong>
        </li>

        <li class="woocommerce-order-overview__date date">
            <?php echo esc_html($this->props['order_date_text']); ?>
            <strong><?php echo esc_html(wc_format_datetime( new WC_DateTime() )); ?></strong>
        </li>

        <li class="woocommerce-order-overview__email email">
            <?php echo esc_html($this->props['order_email_text']); ?>
            <strong><?php echo esc_html(get_option( 'admin_email', '' )); ?></strong>
        </li>

        <li class="woocommerce-order-overview__total total">
        <?php echo esc_html($this->props['order_total_text']); ?>
            <strong><?php echo et_core_intentionally_unescaped(wc_price(0), 'html'); ?></strong>
        </li>

        <li class="woocommerce-order-overview__payment-method method">
            <?php echo esc_html($this->props['payment_method_text']); ?>
            <strong>Cash on delivery</strong>
        </li>
    </ul>
    <section class="woocommerce-order-downloads">
        <h2 class="woocommerce-order-downloads__title">Downloads</h2>

        <table class="woocommerce-table woocommerce-table--order-downloads shop_table shop_table_responsive order_details">
            <thead>
            <tr>
                <th class="download-product"><span class="nobr">Product</span></th>
                <th class="download-remaining"><span class="nobr">Downloads remaining</span></th>
                <th class="download-expires"><span class="nobr">Expires</span></th>
                <th class="download-file"><span class="nobr">Download</span></th>
            </tr>
            </thead>

            <tbody><tr>
                <td class="download-product" data-title="Product">
                    <a href="#"><?php esc_html_e( 'My Awesome Product', 'divi-shop-builder' ); ?></a>
                </td>
                <td class="download-remaining" data-title="Downloads remaining">
                    ∞
                </td>
                <td class="download-expires" data-title="Expires">
                    Never
                </td>
                <td class="download-file" data-title="Download">
                    <a href="#" class="woocommerce-MyAccount-downloads-file button alt">Download</a>
                </td>
            </tr>
            </tbody></table>
    </section>
    <section class="woocommerce-order-details">
        <h2 class="woocommerce-order-details__title"><?php echo esc_html($this->props['order_details_text']); ?></h2>
        <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
            <thead>
                <tr>
                    <th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'divi-shop-builder' ); ?></th>
                    <th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'divi-shop-builder' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr class="woocommerce-table__line-item order_item">
                    <td class="woocommerce-table__product-name product-name">
                        <a><?php esc_html_e( 'My Awesome Product', 'divi-shop-builder' ); ?></a>
                        <strong class="product-quantity"> x 1</strong>
                    </td>
                    <td class="woocommerce-table__product-total product-total">
                        <a><?php echo et_core_intentionally_unescaped(wc_price(0), 'html'); ?></a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="row"><?php echo esc_html__( 'Shipping', 'divi-shop-builder' ) . ' :'; ?></th>
                    <td><?php echo et_core_intentionally_unescaped(wc_price(0), 'html'); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo esc_html__( 'Payment Method', 'divi-shop-builder' ); ?></th>
                    <td><?php echo et_core_intentionally_unescaped(wc_price(0), 'html'); ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo esc_html__( 'Total', 'divi-shop-builder' ); ?></th>
                    <td><?php echo et_core_intentionally_unescaped(wc_price(0), 'html'); ?></td>
                </tr>
            </tfoot>
        </table>
    </section>
    <section class="woocommerce-customer-details">
        <section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
            <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">
                <h2 class="woocommerce-column__title"><?php echo esc_html($this->props['billing_address_text']); ?></h2>
                <address>
                    John Doe<br/>
                    123, New York Street<br/>
                    10010<br/>
                    USA
                    <p class="woocommerce-customer-details--phone">+1234567890</p>
                    <p class="woocommerce-customer-details--email">johndoe@gmail.com</p>
                </address>
            </div>
            <div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
                <h2 class="woocommerce-column__title"><?php echo esc_html($this->props['shipping_address_text']); ?></h2>
                <address>
                    John Doe<br/>
                    123, New York Street<br/>
                    10010<br/>
                    USA
                </address>
            </div>
        </section>
    </section>
</div>