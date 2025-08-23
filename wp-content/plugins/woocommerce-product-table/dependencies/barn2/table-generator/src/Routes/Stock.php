<?php

/**
 * @package   Barn2\table-generator
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
namespace Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Routes;

use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Api_Handler;
/**
 * Stock api route.
 *
 * Returns the list of supported post stati.
 */
class Stock extends Api_Handler
{
    public $slug = 'stock';
    /**
     * {@inheritdoc}
     */
    public function register_routes()
    {
        \register_rest_route($this->get_api_namespace(), 'stock', [['methods' => 'GET', 'callback' => [$this, 'get_stock'], 'permission_callback' => [$this, 'check_permissions']]]);
    }
    /**
     * Get the list of registered stati for a given post type.
     *
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public function get_stock($request)
    {
        $stock = \function_exists('wc_get_product_stock_status_options') ? \wc_get_product_stock_status_options() : [];
        return $this->send_success_response(['stock' => $stock]);
    }
}
