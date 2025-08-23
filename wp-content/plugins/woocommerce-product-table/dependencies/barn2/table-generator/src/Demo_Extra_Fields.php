<?php

/**
 * @package   Barn2\table-generator
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
namespace Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator;

use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Routes\Extra_Fields;
class Demo_Extra_Fields extends Extra_Fields
{
    public function get_extra_fields()
    {
        return [['type' => 'text', 'label' => __('%s per page','woocommerce-product-table' ), 'name' => 'rows_per_page'], ['type' => 'text', 'label' => __('%s limit','woocommerce-product-table' ), 'description' => __('The maximum number of %contentType% in one table.','woocommerce-product-table' ), 'name' => 'post_limit'], ['type' => 'select', 'label' => __('Search box','woocommerce-product-table' ), 'name' => 'search_box', 'options' => Util::parse_array_for_dropdown(['top' => __('Above table','woocommerce-product-table' ), 'bottom' => __('Below table','woocommerce-product-table' ), 'both' => __('Above and below table','woocommerce-product-table' ), 'false' => __('Hidden','woocommerce-product-table' )])], ['type' => 'checkbox', 'label' => __('Caching','woocommerce-product-table' ), 'description' => __('Cache table contents to improve load times.','woocommerce-product-table' ), 'name' => 'cache'], ['type' => 'text', 'label' => __('Button text','woocommerce-product-table' ), 'description' => \sprintf(__('If your table uses the "button" column. <a href="%s" target="_blank">Read more</a>','woocommerce-product-table' ), 'https://barn2.com/kb/posts-table-button-column'), 'name' => 'button_text']];
    }
}
