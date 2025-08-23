<?php

/**
 * @package   Barn2\table-generator
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
namespace Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator;

use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Database\Query;
/**
 * Handles registration and rendering of the new shortcode.
 */
class Shortcode
{
    /**
     * Slug of the shortcode to register.
     *
     * @var string
     */
    protected $slug;
    /**
     * Table Generator instance.
     *
     * @var Table_Generator
     */
    protected $generator;
    /**
     * Instance of the plugin using the generator.
     *
     * @var object
     */
    protected $args_resolver;
    /**
     * Initialize the shortcode's registration.
     *
     * @param string $slug
     * @param Table_Generator $generator
     */
    public function __construct(string $slug, Table_Generator $generator)
    {
        $this->slug = $slug;
        $this->generator = $generator;
        $this->args_resolver = $generator->get_args_resolver();
        $this->boot();
    }
    /**
     * Hook into WP.
     *
     * @return void
     */
    public function boot()
    {
        \add_shortcode($this->slug, [$this, 'render_shortcode']);
    }
    /**
     * Render the shortcode.
     *
     * @param array $atts
     * @return string
     */
    public function render_shortcode($atts)
    {
        $original_atts = $atts;
        $attributes = \shortcode_atts(['id' => null], $atts);
        $table_id = $attributes['id'];
        if (empty($table_id)) {
            if ($this->slug === 'product_table') {
                $query = new Query($this->generator->get_database_prefix());
                $table = $query->query(['search' => '"table_display":"manual"', 'search_columns' => ['settings'], 'order_by' => 'id', 'order' => 'ASC', 'number' => 1, 'is_completed' => \true]);
                if (isset($table[0]) && $table[0] instanceof Content_Table) {
                    $table = $table[0];
                } else {
                    // Quick fix for issue where servers adds a space on JSON formats.
                    $table = $query->query(['search' => '"table_display": "manual"', 'search_columns' => ['settings'], 'order_by' => 'id', 'order' => 'ASC', 'number' => 1, 'is_completed' => \true]);
                    if (isset($table[0]) && $table[0] instanceof Content_Table) {
                        $table = $table[0];
                    } else {
                        // This needs to be removed on a future version. as well removing the unused settings.
                        $atts = \Barn2\Plugin\WC_Product_Table\Util\Defaults::get_table_defaults();
                        return $this->generator->get_shortcode_resolver()::do_shortcode(\shortcode_atts($atts, $original_atts));
                    }
                }
            } else {
                return $this->generator->get_shortcode_resolver()::do_shortcode($atts);
            }
        } else {
            $table = (new Query($this->generator->get_database_prefix()))->get_item($table_id);
        }
        if (!$table instanceof Content_Table) {
            if ($this->slug === 'product_table') {
                /* translators: %d: The ID of the product table that could not be found */
                return \sprintf(__('The product table (ID:%d) could not be found.','woocommerce-product-table' ), $table_id);
            } else {
                /* translators: %d: The ID of the posts table that could not be found */
                return \sprintf(__('The posts table (ID:%d) could not be found.','woocommerce-product-table' ), $table_id);
            }
        }
        return $this->generator->get_shortcode_resolver()::do_shortcode(self::get_parameters($table, $atts, $this->args_resolver));
    }
    /**
     * Get the parameters for the table.
     *
     * @param Content_Table $table         The Content Table instance
     * @param array        $attributes     Additional attributes to merge with the table
     * @param string       $args_resolver  The class path of the arguments resolver
     * @return array
     */
    public static function get_parameters(Content_Table $table, $attributes, $args_resolver)
    {
        $args = $args_resolver::get_site_defaults();
        // Grab the content type from the table.
        $content_type = $table->get_content_type();
        // Set the content type for the shortcode.
        $args['post_type'] = $content_type;
        // Inject mime type if exists.
        if ($mime_type = $table->get_mime_type(\true)) {
            $args['post_type'] .= ':' . $mime_type;
        }
        // Inject "category" argument if it's a post table.
        if ($table->supports_categories() && !empty($table->get_categories())) {
            $args['category'] = $table->get_categories(\true);
        }
        // Inject "tag" argument if it's a post table.
        if ($table->supports_tags() && !empty($table->get_tags())) {
            $args['tag'] = $table->get_tags(\true);
        }
        // Inject the post status argument.
        if ($content_type === 'shop_order' && \class_exists('WooCommerce') && !isset($attributes['status'])) {
            $args['status'] = 'any';
        }
        if (!empty($table->get_post_status())) {
            $args['status'] = $table->get_post_status(\true);
        }
        // Inject the stock argument.
        if (!empty($table->get_stock())) {
            $args['stock'] = $table->get_stock(\true);
        }
        // Inject the "author" parameter.
        if (\post_type_supports($content_type, 'author') && !empty($table->get_author())) {
            $args['author'] = $table->get_author(\true);
        }
        // Inject the "include" (specific posts ids) parameter.
        if (!empty($table->get_specific_ids())) {
            $args['include'] = $table->get_specific_ids(\true);
        }
        // Inject the date parameters.
        if (!empty($table->get_year())) {
            $args['year'] = $table->get_year();
        }
        if (!empty($table->get_month())) {
            $args['month'] = $table->get_month();
        }
        if (!empty($table->get_day())) {
            $args['day'] = $table->get_day();
        }
        // Inject custom fields.
        if (!empty($table->get_custom_fields())) {
            $args['cf'] = $table->get_custom_fields(\true);
        }
        // Inject terms.
        if (!empty($table->get_terms())) {
            $args['term'] = $table->get_terms(\true);
            // Get the terms array to check for category and tag taxonomies
            $terms_array = $table->get_terms();
            // Unset category if conditions are met
            if ($table->supports_categories() && !empty($table->get_categories()) && isset($terms_array['category'])) {
                unset($args['category']);
            }
            // Unset tag if conditions are met
            if ($table->supports_tags() && !empty($table->get_tags()) && isset($terms_array['post_tag'])) {
                unset($args['tag']);
            }
        }
        // Now start the exclusion parameters.
        // Inject the "exclude category" argument if it's a post table.
        if ($table->supports_categories() && !empty($table->get_categories(\false, \true))) {
            $args['exclude_category'] = $table->get_categories(\true, \true);
        }
        // Inject the "exclude" (specific posts ids) parameter.
        if (!empty($table->get_specific_ids(\false, \true))) {
            $args['exclude'] = $table->get_specific_ids(\true, \true);
        }
        // Inject columns configuration.
        if (!empty($table->get_columns(\true))) {
            $args['columns'] = $table->get_columns(\true);
        }
        // Inject links.
        if (!empty($table->get_links(\true))) {
            $args['links'] = $table->get_links(\true);
        }
        // Inject lightbox.
        $args['lightbox'] = $table->get_lightbox();
        // Inject search on click.
        if (!empty($table->get_search_on_click(\true))) {
            $args['search_on_click'] = $table->get_search_on_click(\true);
        }
        // Inject column type
        if (!empty($table->get_column_type(\true))) {
            $args['column_type'] = $table->get_column_type();
        }
        // Inject widths.
        if (!empty($table->get_widths(\true))) {
            $args['widths'] = $table->get_widths(\true);
        }
        // Inject priorities.
        if (!empty($table->get_priorities(\true))) {
            $args['priorities'] = $table->get_priorities(\true);
        }
        // Inject column breakpoints.
        if (!empty($table->get_column_breakpoints(\true))) {
            $args['column_breakpoints'] = $table->get_column_breakpoints(\true);
        }
        // Cart button.
        $cart_button = $table->get_setting('cart_button');
        if ($cart_button) {
            $args['cart_button'] = $cart_button;
        }
        // Quantities.
        $quantities = $table->get_setting('quantities');
        if ($quantities) {
            $args['quantities'] = $quantities;
        }
        // Variations.
        $variations = $table->get_setting('variations');
        if ($variations) {
            $args['variations'] = $variations;
        }
        // Variation name format.
        $variation_name_format = $table->get_setting('variation_name_format');
        if ($variation_name_format) {
            $args['variation_name_format'] = $variation_name_format;
        }
        // Add support for the lazy load param.
        $lazy_load = $table->get_setting('lazyload', \false);
        if ($lazy_load) {
            $args['lazy_load'] = \true;
        } else {
            $args['lazy_load'] = \false;
        }
        // Add support for the cache param.
        $cache = $table->get_setting('cache', \false);
        if ($cache) {
            $args['cache'] = \true;
        }
        // Add support for the button_text param.
        $button_text = $table->get_setting('button_text', \false);
        if ($button_text) {
            $args['button_text'] = $button_text;
        }
        // Inject the sort by state.
        $sort_by = $table->get_setting('sortby', 'date');
        $args['sort_by'] = !empty($sort_by) ? $sort_by : 'date';
        // Inject sort order.
        $sort_order = $table->get_setting('sort_order', '');
        $args['sort_order'] = $sort_order;
        // Inject filters parameter.
        $args['filters'] = $table->get_filters(\true);
        // Extra fields.
        $rows_per_page = $table->get_setting('rows_per_page');
        if ($rows_per_page) {
            $args['rows_per_page'] = $rows_per_page;
        }
        $post_limit = $table->get_setting('post_limit');
        if ($post_limit) {
            $args['post_limit'] = $post_limit;
        }
        $search_box = $table->get_setting('search_box', null);
        if (isset($search_box) && \in_array($search_box, ['top', 'bottom', 'both', \true, \false], \true)) {
            $args['search_box'] = $search_box;
        }
        $cache = $table->get_setting('cache');
        if ($cache) {
            $args['cache'] = $cache;
        }
        $button_text = $table->get_setting('button_text');
        if ($button_text) {
            $args['button_text'] = $button_text;
        }
        $image_size = $table->get_setting('image_size');
        if ($image_size) {
            $args['image_size'] = $image_size;
        }
        $product_limit = $table->get_setting('product_limit');
        if ($product_limit) {
            $args['product_limit'] = $product_limit;
        }
        // Merge inline shortcode attributes.
        if (!empty($attributes)) {
            unset($attributes['id']);
            // ID is not needed.
            if (!empty($attributes)) {
                $args = \array_merge($args, $attributes);
            }
        }
        /**
         * Filter the shortcode arguments before they are returned.
         *
         * @param array $args The shortcode arguments.
         * @param Content_Table $table The table instance.
         * @param array $attributes Original shortcode attributes.
         * @return array
         */
        $args = \apply_filters('barn2_table_generator_shortcode_args', $args, $table, $attributes);
        return $args;
    }
}
