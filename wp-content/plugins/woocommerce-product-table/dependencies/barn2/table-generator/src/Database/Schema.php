<?php

/**
 * @package   Barn2\table-generator
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
namespace Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Database;

use Barn2\Plugin\WC_Product_Table\Dependencies\BerlinDB\Database\Schema as BaseSchema;
/**
 * Schema used to format data when queried.
 */
class Schema extends BaseSchema
{
    /**
     * {@inheritdoc}
     *
     * @var array<int, array<string, bool|int|string|null>>
     */
    public $columns = [['name' => 'id', 'type' => 'bigint', 'length' => '20', 'unsigned' => \true, 'extra' => 'auto_increment', 'primary' => \true, 'sortable' => \true, 'validate' => 'intval'], ['name' => 'title', 'type' => 'varchar', 'length' => '255', 'sortable' => \true, 'validate' => 'sanitize_text_field'], ['name' => 'settings', 'type' => 'json', 'sortable' => \false, 'searchable' => \true], ['name' => 'is_completed', 'type' => 'tinyint', 'length' => '1', 'unsigned' => \false, 'default' => '0']];
}
