<?php

/**
 * @package   Barn2\table-generator
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
namespace Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Steps;

use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Database\Query;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Step;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Content_Table;
/**
 * The performance step handles caching options for the table.
 */
class Performance extends Step
{
    /**
     * Initialize the step properties.
     *
     * @return void
     */
    public function init()
    {
        $this->set_id('performance');
        $this->set_name(__('Performance','woocommerce-product-table' ));
        $this->set_title(__('Performance','woocommerce-product-table' ));
        $this->set_description(__('Optimize your table load times.','woocommerce-product-table' ));
        $this->set_fields($this->get_fields_list());
    }
    /**
     * List of fields for this step.
     *
     * @return array
     */
    public function get_fields_list()
    {
        $fields = [['type' => 'heading', 'label' => __('Lazy load','woocommerce-product-table' ), 'tag' => 'h2'], ['type' => 'checkbox', 'label' => __('Load table one page at a time','woocommerce-product-table' ), 'name' => 'lazyload', 'description' => __('Enable this if the table will contain a large number of %contentType%.','woocommerce-product-table' )], ['type' => 'number', 'label' => __('%contentTypeUpper% limit', 'woocommerce-product-table'), 'description' => __('The maximum number of %contentType% in one table.', 'woocommerce-product-table'), 'name' => 'post_limit', 'min' => '-1', 'conditions' => ['lazyload' => ['op' => 'eq', 'value' => \false]], 'style' => ['width' => '100px']]];
        return $fields;
    }
    /**
     * {@inheritdoc}
     */
    public function get_data($request)
    {
        $table_id = $request->get_param('table_id');
        if (!empty($table_id)) {
            /** @var Content_Table $table */
            $table = (new Query($this->get_generator()->get_database_prefix()))->get_item($table_id);
            $default_options = $this->get_generator()->get_default_options();
            $lazy_load_default = isset($default_options['lazy_load']) ? $default_options['lazy_load'] : \false;
            return $this->send_success_response(['table_id' => $table_id, 'values' => ['lazyload' => $table->get_setting('lazyload', $lazy_load_default)]]);
        }
        return $this->send_success_response();
    }
    /**
     * {@inheritdoc}
     */
    public function save_data($request)
    {
        $values = $this->get_submitted_values($request);
        $table_id = $request->get_param('table_id');
        if (empty($table_id)) {
            return $this->send_error_response(['message' => __('The table_id parameter is missing.','woocommerce-product-table' )]);
        }
        $lazyload = isset($values['lazyload']) && $values['lazyload'] === '1';
        /** @var Content_Table $table */
        $table = (new Query($this->get_generator()->get_database_prefix()))->get_item($table_id);
        $table_settings = $table->get_settings();
        $table_settings['lazyload'] = $lazyload;
        $updated_table = (new Query($this->get_generator()->get_database_prefix()))->update_item($table_id, ['settings' => \wp_json_encode($table_settings)]);
        return $this->send_success_response(['table_id' => $table_id]);
    }
}
