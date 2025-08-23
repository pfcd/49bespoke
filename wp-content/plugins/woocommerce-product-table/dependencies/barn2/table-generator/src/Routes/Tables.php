<?php

/**
 * @package   Barn2\table-generator
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
namespace Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Routes;

use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Api_Handler;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Content_Table;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Database\Query;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Steps\Refine;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Util;
/**
 * Handles retrieval and update of tables in the database.
 */
class Tables extends Api_Handler
{
    /**
     * {@inheritdoc}
     */
    public $slug = 'tables';
    /**
     * The prefix used to query the correct database table.
     * Refer to the documentation for more info.
     *
     * @var string
     */
    private $db_prefix;
    /**
     * Initialize the api route.
     *
     * @param boolean|object $plugin
     * @param string $prefix
     */
    public function __construct($plugin = \false, $prefix = 'barn2')
    {
        $this->db_prefix = $prefix;
        parent::__construct($plugin);
    }
    /**
     * Get the assigned database prefix.
     *
     * @return string
     */
    public function get_database_prefix()
    {
        return $this->db_prefix;
    }
    /**
     * {@inheritdoc}
     */
    public function register_routes()
    {
        \register_rest_route($this->get_api_namespace(), 'tables', [['methods' => 'GET', 'callback' => [$this, 'get_tables'], 'permission_callback' => [$this, 'check_permissions']], ['methods' => 'DELETE', 'callback' => [$this, 'delete_table'], 'permission_callback' => [$this, 'check_permissions']], ['methods' => 'PATCH', 'callback' => [$this, 'set_table_completed'], 'permission_callback' => [$this, 'check_permissions']], ['methods' => 'POST', 'callback' => [$this, 'update_table'], 'permission_callback' => [$this, 'check_permissions']]]);
    }
    /**
     * Get tables via the api.
     * Also delete all incompleted tables.
     *
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public function get_tables($request)
    {
        $page_size = $request->get_param('page_size') ?? 20;
        $offset = $request->get_param('offset') ?? 0;
        $table_id = $request->get_param('table_id');
        $tables = new Query($this->get_database_prefix());
        // Return the single table if an ID is given.
        if (!empty($table_id)) {
            return $this->send_success_response(['table_details' => $tables->get_item($table_id)]);
        }
        $this->delete_incomplete();
        $tables->query(['is_completed' => \true]);
        $total = $tables->query(['is_completed' => \true, 'count' => \true]);
        return $this->send_success_response(['total' => $total, 'tables' => $tables->query(['number' => $page_size, 'offset' => $offset, 'is_completed' => \true, 'orderby' => 'id', 'order' => 'DESC'])]);
    }
    /**
     * Delete a table via the rest api.
     *
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public function delete_table($request)
    {
        $table_id = $request->get_param('table_id');
        if (empty($table_id)) {
            return $this->send_error_response(['message' => __('The table_id parameter is required.','woocommerce-product-table' )]);
        }
        $query = new Query($this->get_database_prefix());
        $table = $query->get_item($table_id);
        $query->delete_item($table_id);
        return $this->send_success_response(['message' => __('Table successfully deleted','woocommerce-product-table' ), 'table_id' => $table_id]);
    }
    /**
     * Set table as completed.
     *
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public function set_table_completed($request)
    {
        $table_id = $request->get_param('table_id');
        if (empty($table_id) || !\is_numeric($table_id)) {
            return $this->send_error_response(['message' => __('The table_id parameter is required.','woocommerce-product-table' )]);
        }
        $query = new Query($this->get_database_prefix());
        $updated_table = $query->update_item($table_id, ['is_completed' => \true]);
        $table = $query->get_item($table_id);
        return $this->send_success_response(['table_id' => $request->get_param('table_id'), 'settings' => $table->get_settings()]);
    }
    /**
     * Delete incomplete tables from the database.
     *
     * @return void
     */
    private function delete_incomplete()
    {
        $tables = (new Query($this->get_database_prefix()))->query(['is_completed' => \false]);
        $query = new Query($this->get_database_prefix());
        if (\is_array($tables) && !empty($tables)) {
            foreach ($tables as $table) {
                $query->delete_item($table->get_id());
            }
        }
    }
    /**
     * Update a table that has been edited.
     *
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public function update_table($request)
    {
        $table_id = $request->get_param('table_id');
        $details = $request->get_param('table_details') ?? [];
        if (empty($table_id) || !\is_numeric($table_id)) {
            return $this->send_error_response(['message' => __('The table_id parameter is required.','woocommerce-product-table' )]);
        }
        // Duplicate table.
        $duplicate = $request->get_param('duplicate') ?? \false;
        if ($duplicate) {
            return $this->duplicate_table($table_id);
        }
        /** @var Content_Table $table */
        $table = (new Query($this->get_database_prefix()))->get_item($table_id);
        $table_settings = $table->get_settings();
        $submitted_title = Util::clean($details['title']);
        $submitted_settings = Util::clean($details['settings']);
        if (empty($submitted_title)) {
            return $this->send_error_response(['message' => esc_html__('Please enter a title for your table.','woocommerce-product-table' )]);
        }
        // Make sure columns exist.
        if (!isset($submitted_settings['columns'])) {
            return $this->send_error_response(['message' => __('You must add at least one column.','woocommerce-product-table' )]);
        }
        // Make sure one template is selected.
        $templates_options = \array_filter($submitted_settings, function ($v, $k) {
            return \strpos($k, '_override') !== \false && $v === \true && $k !== 'previous_wholesale_store_override';
        }, \ARRAY_FILTER_USE_BOTH);
        if ($submitted_settings['table_display'] === 'shop_page' && empty($templates_options)) {
            return $this->send_error_response(['message' => __('Please select one or more templates.','woocommerce-product-table' )]);
        }
        foreach ($submitted_settings as $key => $value) {
            if ($this->field_requires_validation($key)) {
                $value = $this->validate_field($key, $value);
                // Return response if one was provided - usually happens for validation errors only.
                if ($value instanceof \WP_REST_Response) {
                    return $value;
                }
                $submitted_settings[$key] = $value;
            }
        }
        $filters = isset($submitted_settings['filters']) ? $submitted_settings['filters'] : [];
        $filter_mode = isset($filters['mode']) ? $filters['mode'] : \false;
        $filter_items = isset($filters['items']) ? $filters['items'] : [];
        if (!empty($filter_items)) {
            $filter_items = Util::array_unset_recursive($filter_items, 'id');
            $filter_items = Util::array_unset_recursive($filter_items, 'priority');
        }
        // Adjust the refine_mode setting value.
        if (isset($submitted_settings['refine_mode'])) {
            $submitted_settings['refine_mode'] = isset($submitted_settings['refine']['mode']) ? $submitted_settings['refine']['mode'] : 'all';
        }
        // Make sure the table_display setting value exists.
        if (!isset($submitted_settings['table_display'])) {
            $submitted_settings['table_display'] = 'manual';
        }
        $submitted_settings['filter_mode'] = $filter_mode;
        $submitted_settings['filters'] = $filter_items;
        $submitted_settings = \apply_filters('barn2_table_generator_table_settings', $submitted_settings, $table_id);
        $updated_table = (new Query($this->get_database_prefix()))->update_item($table_id, ['title' => \stripslashes($submitted_title), 'settings' => \wp_json_encode($submitted_settings)]);
        return $this->send_success_response(['data' => $updated_table]);
    }
    /**
     * Duplicate a table.
     *
     * @param integer $table_id
     * @return \WP_REST_Response
     */
    public function duplicate_table($table_id)
    {
        global $wpdb;
        $db = new Query($this->get_database_prefix());
        $table_name = $db->get_table_name();
        $query = 'INSERT INTO ' . $table_name . '(`title`, `settings`, `is_completed`) SELECT `title`, `settings`, `is_completed` FROM ' . $table_name . ' WHERE id = %d;';
        $rows_affected = $wpdb->query($wpdb->prepare($query, $table_id));
        if ($rows_affected) {
            $duplicated_id = $wpdb->insert_id;
            $table = $db->get_item($duplicated_id);
            // Make duplicated title to be in the format - Copy 2, 3, ....
            $duplicated_title = $table->title;
            if (\strpos($duplicated_title, __(' - Copy','woocommerce-product-table' )) !== \false) {
                $duplicated_index = \substr($duplicated_title, \strrpos($duplicated_title, __(' - Copy','woocommerce-product-table' )) + \strlen(__(' - Copy','woocommerce-product-table' )) + 1);
                $duplicated_title = \substr($duplicated_title, 0, \strrpos($duplicated_title, __(' - Copy','woocommerce-product-table' )) + \strlen(__(' - Copy','woocommerce-product-table' )) + 1) . ' ' . ($duplicated_index == '' ? '2' : $duplicated_index + 1);
            } else {
                $duplicated_title .= __(' - Copy','woocommerce-product-table' );
            }
            // Force the duplicated table to not have an archive template selected.
            $settings = $table->get_settings();
            $settings['table_display'] = 'manual';
            foreach ($settings as $key => $setting) {
                if (\substr($key, -9) === '_override') {
                    $settings[$key] = \false;
                }
            }
            $db->update_item($duplicated_id, ['title' => \stripslashes($duplicated_title), 'settings' => \wp_json_encode($settings)]);
            return $this->send_success_response(['message' => __('Table successfully duplicated.','woocommerce-product-table' )]);
        } else {
            return $this->send_error_response(['message' => __('Error while duplicating table.','woocommerce-product-table' )]);
        }
    }
    /**
     * List of fields that require special validation.
     *
     * @return array
     */
    private function get_validatable_fields()
    {
        return ['columns', 'refine'];
    }
    /**
     * Determine if given field requires special validation.
     *
     * @param string $id
     * @return bool
     */
    private function field_requires_validation(string $id)
    {
        return \in_array($id, $this->get_validatable_fields(), \true);
    }
    /**
     * Validate fields via specific callbacks when needed.
     *
     * @param string $id
     * @param mixed $value
     * @return mixed
     */
    private function validate_field(string $id, $value)
    {
        switch ($id) {
            case 'columns':
                $value = $this->validate_columns($value);
                break;
            case 'refine':
                $value = $this->validate_refine($value);
                break;
        }
        return $value;
    }
    /**
     * Make sure there's at least one column and
     * clean up the array.
     *
     * @param array $columns
     * @return array|\WP_REST_Response
     */
    private function validate_columns($columns)
    {
        // Cannot save empty columns.
        if (empty($columns)) {
            return $this->send_error_response(['message' => __('You must add at least one column.','woocommerce-product-table' )]);
        }
        $columns = Util::array_unset_recursive($columns, 'priority');
        $columns = Util::array_unset_recursive($columns, 'id');
        return $columns;
    }
    /**
     * Adjust the refinements fields.
     *
     * @param array $refinements
     * @return array
     */
    private function validate_refine($refinements)
    {
        $refine_mode = isset($refinements['mode']) ? $refinements['mode'] : 'all';
        $formatted = Refine::prepare_parameters($refinements['refinements']);
        return ['mode' => $refine_mode, 'refinements' => $formatted];
    }
}
