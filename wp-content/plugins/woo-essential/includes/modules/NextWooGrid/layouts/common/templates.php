<?php

defined( 'ABSPATH' ) || die();

if ( !function_exists('sku_template') ) {
    function sku_template($sku) {
        $html = sprintf('<div class="dnwooe-sku">%1$s</div>',$sku);

        return $html;
    }
}