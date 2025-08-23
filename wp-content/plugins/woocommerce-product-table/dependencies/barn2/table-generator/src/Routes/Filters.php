<?php

/**
 * @package   Barn2\table-generator
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
namespace Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Routes;

use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Api_Handler;
class Filters extends Api_Handler
{
    public $slug = 'filter';
    /**
     * {@inheritdoc}
     */
    public function register_routes()
    {
        \register_rest_route($this->get_api_namespace(), 'filter', [['methods' => 'GET', 'callback' => [$this, 'get_filters'], 'permission_callback' => [$this, 'check_permissions']]]);
    }
    /**
     * Given a content type, we'll return the list of supported filters.
     *
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public function get_filters($request)
    {
        $content_type = $request->get_param('content_type');
        $supports = ['categories' => __('Categories','woocommerce-product-table' ), 'tags' => __('Tags','woocommerce-product-table' )];
        if ($content_type !== 'post') {
            unset($supports['categories']);
            unset($supports['tags']);
        }
        $taxonomies = \get_object_taxonomies(\sanitize_text_field($content_type), 'objects');
        $parsed_taxonomies = [];
        $skip = ['category', 'post_tag'];
        foreach ($taxonomies as $taxonomy) {
            $name = \sanitize_text_field($taxonomy->name);
            $label = \sanitize_text_field(\strpos($taxonomy->name, 'pa_') === 0 ? \ucfirst($taxonomy->labels->singular_name) : \ucfirst($taxonomy->labels->menu_name));
            $taxonomy_terms = \get_terms(['taxonomy' => $taxonomy->name, 'hide_empty' => \true]);
            if ($content_type === 'post' && \in_array($name, $skip, \true) || empty($taxonomy_terms)) {
                continue;
            }
            $parsed_taxonomies["tax:{$name}"] = $label;
        }
        if (isset($parsed_taxonomies['tax:product_cat'])) {
            $supports['tax:product_cat'] = $parsed_taxonomies['tax:product_cat'];
        }
        if (isset($parsed_taxonomies['tax:product_tag'])) {
            $supports['tax:product_tag'] = $parsed_taxonomies['tax:product_tag'];
        }
        $supports = \array_merge($supports, $parsed_taxonomies);
        if (isset($parsed_taxonomies['tax:product_type'])) {
            unset($supports['tax:product_type']);
            $supports['tax:product_type'] = $parsed_taxonomies['tax:product_type'];
        }
        if (isset($parsed_taxonomies['tax:product_visibility'])) {
            unset($supports['tax:product_visibility']);
            $supports['tax:product_visibility'] = $parsed_taxonomies['tax:product_visibility'];
        }
        if (isset($parsed_taxonomies['tax:product_shipping_class'])) {
            unset($supports['tax:product_shipping_class']);
            $supports['tax:product_shipping_class'] = $parsed_taxonomies['tax:product_shipping_class'];
        }
        return $this->send_success_response(['taxonomies' => $supports]);
    }
}
