<?php

/**
 * @package   Barn2\table-generator
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
namespace Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Routes;

use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Api_Handler;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Util;
/**
 * Handles registration of the "supports" route.
 *
 * This route determines what kind of content is supported
 * given a content type.
 */
class Supports extends Api_Handler
{
    /**
     * {@inheritdoc}
     */
    public $slug = 'supports';
    /**
     * {@inheritdoc}
     */
    public function register_routes()
    {
        \register_rest_route($this->get_api_namespace(), 'supports', [['methods' => 'GET', 'callback' => [$this, 'verify_supported_content'], 'permission_callback' => [$this, 'check_permissions']]]);
    }
    /**
     * Given a content type, we'll return the list of supported content
     * for the parameters generator React component.
     *
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public function verify_supported_content($request)
    {
        $content_type = $request->get_param('content_type');
        $taxonomies = \get_object_taxonomies(\sanitize_text_field($content_type), 'objects');
        if (!empty($taxonomies)) {
            foreach ($taxonomies as $taxonomy => $config) {
                if (!Util::taxonomy_has_terms($taxonomy)) {
                    unset($taxonomies[$taxonomy]);
                }
            }
        }
        $parsed_taxonomies = $this->parse_taxonomies($taxonomies);
        if (isset($parsed_taxonomies['product_cat'])) {
            $supports['product_cat'] = $parsed_taxonomies['product_cat'];
        }
        if (isset($parsed_taxonomies['product_tag'])) {
            $supports['product_tag'] = $parsed_taxonomies['product_tag'];
        }
        $supports['include'] = __('Individual %contentType%','woocommerce-product-table' );
        //phpcs:ignore
        $supports['cf'] = __('Custom fields','woocommerce-product-table' );
        $supports = \array_merge($supports, $parsed_taxonomies, ['author' => __('Author','woocommerce-product-table' ), 'mime' => __('MIME type','woocommerce-product-table' )]);
        if ($content_type !== 'attachment') {
            unset($supports['mime']);
        }
        if (!\post_type_supports($content_type, 'author')) {
            unset($supports['author']);
        }
        if (isset($parsed_taxonomies['product_type'])) {
            unset($supports['product_type']);
            $supports['product_type'] = $parsed_taxonomies['product_type'];
        }
        $supports['status'] = __('Status','woocommerce-product-table' );
        if ($content_type === 'product') {
            unset($supports['product_visibility']);
            $supports['stock'] = __('Stock','woocommerce-product-table' );
        }
        if (isset($parsed_taxonomies['product_shipping_class'])) {
            unset($supports['product_shipping_class']);
            $supports['product_shipping_class'] = $parsed_taxonomies['product_shipping_class'];
        }
        return $this->send_success_response(['supports' => $supports, 'taxonomies' => $parsed_taxonomies]);
    }
    /**
     * Parses the list of registered taxonomies and returns
     * an array formatted for being used on the frontend.
     *
     * @param array $taxonomies
     * @return array
     */
    private function parse_taxonomies(array $taxonomies)
    {
        $parsed = [];
        foreach ($taxonomies as $taxonomy) {
            $parsed[$taxonomy->name] = \strpos($taxonomy->name, 'pa_') === 0 ? \ucfirst($taxonomy->labels->singular_name) : \ucfirst($taxonomy->labels->menu_name);
        }
        return $parsed;
    }
}
