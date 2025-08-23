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
 * Stati api route.
 *
 * Returns the list of supported post stati.
 */
class Stati extends Api_Handler
{
    public $slug = 'stati';
    /**
     * {@inheritdoc}
     */
    public function register_routes()
    {
        \register_rest_route($this->get_api_namespace(), 'stati', [['methods' => 'GET', 'callback' => [$this, 'get_post_stati'], 'permission_callback' => [$this, 'check_permissions']]]);
    }
    /**
     * Get the list of registered stati for a given post type.
     *
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public function get_post_stati($request)
    {
        $post_type = \sanitize_text_field($request->get_param('post_type'));
        $statis = \get_post_stati([], 'objects');
        if ($post_type === 'shop_order' && \function_exists('wc_get_order_statuses')) {
            $allowed = \array_keys(\wc_get_order_statuses());
        } else {
            $allowed = ['publish', 'draft', 'pending', 'future'];
        }
        $plucked = [];
        foreach ($statis as $status => $config) {
            if (\in_array($status, $allowed, \true)) {
                $plucked[$status] = $config;
            }
        }
        return $this->send_success_response(['stati' => $plucked]);
    }
}
