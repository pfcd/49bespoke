<?php
/**
 * Plugin Name: Hide Woo Categories (UI Toggle)
 * Description: Adds a "Hide this category" checkbox to WooCommerce product categories and hides those categories & their products sitewide (shop/search/menus/widgets/Divi). Blocks direct URLs and add-to-cart.
 * Author: Your Company
 * Version: 1.1.0
 */

if ( ! defined('ABSPATH') ) exit;

/* ---------------------------------------------------------------------------
 * TERM META: UI toggle on Product Category (Add/Edit) to mark category hidden
 * -------------------------------------------------------------------------*/

add_action('init', function () {
    if ( function_exists('register_term_meta') ) {
        register_term_meta('product_cat', 'hc_hidden', [
            'type'         => 'boolean',
            'single'       => true,
            'default'      => false,
            'show_in_rest' => true,
            'auth_callback'=> '__return_true',
        ]);
    }
});

/** Add form (create new category) */
add_action('product_cat_add_form_fields', function () {
    ?>
    <div class="form-field">
        <label for="hc_hidden"><strong>Hide this category</strong></label>
        <input type="checkbox" name="hc_hidden" id="hc_hidden" value="1" />
        <p class="description">If checked, this category and its products are hidden sitewide; category & product pages 404; add-to-cart is blocked.</p>
    </div>
    <?php
});

/** Edit form (existing category) */
add_action('product_cat_edit_form_fields', function ( $term ) {
    $hidden = (bool) get_term_meta( $term->term_id, 'hc_hidden', true );
    ?>
    <tr class="form-field">
        <th scope="row"><label for="hc_hidden">Hide this category</label></th>
        <td>
            <label>
                <input type="checkbox" name="hc_hidden" id="hc_hidden" value="1" <?php checked( $hidden ); ?> />
                Hide this category and all of its products sitewide
            </label>
            <p class="description">Products are removed from shop/search/related; category & product pages return 404; add-to-cart is blocked.</p>
        </td>
    </tr>
    <?php
});

/** Save meta on create/edit */
add_action('created_product_cat', function ( $term_id ) {
    update_term_meta( $term_id, 'hc_hidden', isset($_POST['hc_hidden']) ? '1' : '0' );
});
add_action('edited_product_cat', function ( $term_id ) {
    update_term_meta( $term_id, 'hc_hidden', isset($_POST['hc_hidden']) ? '1' : '0' );
});

/** Admin list column to show hidden status */
add_filter('manage_edit-product_cat_columns', function ( $cols ) {
    $cols['hc_hidden'] = 'Hidden?';
    return $cols;
});
add_filter('manage_product_cat_custom_column', function ( $content, $column, $term_id ) {
    if ( $column === 'hc_hidden' ) {
        $content = (bool) get_term_meta( $term_id, 'hc_hidden', true ) ? 'Yes' : 'No';
    }
    return $content;
}, 10, 3);

/* ---------------------------------------------------------------------------
 * HELPERS
 * -------------------------------------------------------------------------*/

/**
 * Get hidden product_cat IDs (cached per request).
 * Uses get_terms(); any filters on get_terms are guarded against recursion.
 */
function hc_get_hidden_cat_ids() {
    static $ids = null;
    if ( $ids !== null ) return $ids;

    $terms = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'fields'     => 'ids',
        'meta_query' => [[
            'key'   => 'hc_hidden',
            'value' => '1',
        ]],
    ]);

    $ids = is_wp_error($terms) ? [] : array_map('intval', $terms);
    return $ids;
}

/** Hidden cats + ALL their descendants (for strict blocking / 404) */
function hc_get_hidden_cat_ids_cascade() {
    static $all = null;
    if ($all !== null) return $all;

    $hidden = hc_get_hidden_cat_ids();
    if (empty($hidden)) { $all = []; return $all; }

    $all = $hidden;
    foreach ($hidden as $term_id) {
        $kids = get_term_children($term_id, 'product_cat');
        if (!is_wp_error($kids) && !empty($kids)) {
            $all = array_merge($all, array_map('intval', $kids));
        }
    }
    $all = array_values(array_unique(array_map('intval', $all)));
    return $all;
}

/* ---------------------------------------------------------------------------
 * FRONT-END EXCLUSIONS (queries, lists, menus, widgets, Divi)
 * -------------------------------------------------------------------------*/

/**
 * Woo product queries: exclude hidden categories.
 */
add_action('woocommerce_product_query', function ( $q ) {
    $hidden = hc_get_hidden_cat_ids();
    if ( empty($hidden) ) return;

    $tax_query   = (array) $q->get('tax_query');
    $tax_query[] = [
        'taxonomy'         => 'product_cat',
        'field'            => 'term_id',
        'terms'            => $hidden,
        'operator'         => 'NOT IN',
        'include_children' => true,
    ];
    $q->set('tax_query', $tax_query);
}, 10, 1);

/**
 * Exclude hidden categories from ALL front-end product queries
 * (covers Woo shop/archives/search and FiboSearch frontend queries).
 */
add_action('pre_get_posts', function ( $q ) {
    if ( is_admin() ) return;

    $is_product_ctx = (
        $q->get('post_type') === 'product'
        || $q->is_post_type_archive('product')
        || $q->is_tax('product_cat')
        || $q->is_search()
    );
    if ( ! $is_product_ctx ) return;

    $hidden = hc_get_hidden_cat_ids();
    if ( empty($hidden) ) return;

    $tax_query   = (array) $q->get('tax_query');
    $tax_query[] = [
        'taxonomy'         => 'product_cat',
        'field'            => 'term_id',
        'terms'            => $hidden,
        'operator'         => 'NOT IN',
        'include_children' => true,
    ];
    $q->set('tax_query', $tax_query);
});

/**
 * Shop/category archive: hide hidden subcategories grid.
 */
add_filter('woocommerce_product_subcategories_args', function ($args) {
    if ( is_admin() ) return $args;

    $hidden = hc_get_hidden_cat_ids();
    if ( empty($hidden) ) return $args;

    $args['exclude'] = array_unique(array_merge(
        isset($args['exclude']) ? (array) $args['exclude'] : [],
        $hidden
    ));
    return $args;
});

/**
 * Product Categories widget: exclude hidden categories.
 */
add_filter('woocommerce_product_categories_widget_args', function ( $args ) {
    $hidden = hc_get_hidden_cat_ids();
    if ( empty($hidden) ) return $args;

    $args['exclude'] = array_merge( isset($args['exclude']) ? (array) $args['exclude'] : [], $hidden );
    return $args;
});

/**
 * Menus (Appearance → Menus → "Product Categories"): drop hidden categories.
 */
add_filter('wp_nav_menu_objects', function ($items) {
    if ( is_admin() ) return $items;

    $hidden = hc_get_hidden_cat_ids();
    if ( empty($hidden) ) return $items;

    $filtered = [];
    foreach ( $items as $item ) {
        if ( $item->object === 'product_cat' && in_array( (int) $item->object_id, $hidden, true ) ) {
            continue; // skip hidden category menu item
        }
        $filtered[] = $item;
    }
    return $filtered;
});

/**
 * GLOBAL term list filter (covers Divi modules / shortcodes that call get_terms).
 * Guarded to avoid recursion with hc_get_hidden_cat_ids().
 */
add_filter('get_terms', function ($terms, $taxonomies, $args) {
    static $in_filter = false;

    if ( $in_filter || is_admin() ) return $terms;

    $taxonomies = (array) $taxonomies;
    if ( ! in_array('product_cat', $taxonomies, true) ) return $terms;

    $in_filter = true;
    $hidden = hc_get_hidden_cat_ids();
    $in_filter = false;

    if ( empty($hidden) || empty($terms) ) return $terms;

    $hidden_map = array_flip($hidden);
    $filtered   = [];
    foreach ( $terms as $t ) {
        if ( isset($hidden_map[(int) $t->term_id]) ) continue;
        $filtered[] = $t;
    }
    return $filtered;
}, 20, 3);

/* ---------------------------------------------------------------------------
 * HARD BLOCKS: 404 archives & single product, block add-to-cart
 * -------------------------------------------------------------------------*/

/** 404 the hidden category archives */
add_action('template_redirect', function () {
    if ( ! is_tax('product_cat') ) return;

    $hidden = hc_get_hidden_cat_ids();
    if ( empty($hidden) ) return;

    $term = get_queried_object();
    if ( $term && in_array( (int) $term->term_id, $hidden, true ) ) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        include get_query_template('404');
        exit;
    }
});

/**
 * Force 404 for products in hidden categories (handles variations; runs early).
 */
add_action('template_redirect', function () {
    if ( ! is_singular('product') ) return;

    $pid = get_the_ID();

    // If it's a variation, check parent
    if ( 'product_variation' === get_post_type($pid) ) {
        $parent = (int) wp_get_post_parent_id($pid);
        if ($parent) $pid = $parent;
    }

    $blocked_terms = hc_get_hidden_cat_ids_cascade();
    if ( empty($blocked_terms) ) return;

    if ( has_term( $blocked_terms, 'product_cat', $pid ) ) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        include get_query_template('404');
        exit;
    }
}, 1);

/**
 * Enforce 404 even if a template tries to render the product directly.
 */
add_filter('the_posts', function($posts){
    if ( empty($posts) || ! is_singular('product') ) return $posts;

    $pid = $posts[0]->ID;

    // If variation, check parent
    if ( 'product_variation' === get_post_type($pid) ) {
        $parent = (int) wp_get_post_parent_id($pid);
        if ($parent) $pid = $parent;
    }

    $blocked = hc_get_hidden_cat_ids_cascade();
    if ( empty($blocked) ) return $posts;

    if ( has_term($blocked, 'product_cat', $pid) ) {
        global $wp_query;
        $wp_query->posts = [];
        $wp_query->post_count = 0;
        $wp_query->is_404 = true;
        status_header(404);
        nocache_headers();
        return [];
    }
    return $posts;
}, 1);

/**
 * Block add-to-cart attempts for hidden products (covers direct URL & variations).
 */
add_filter('woocommerce_add_to_cart_validation', function ( $passed, $product_id, $quantity, $variation_id = 0 ) {
    $check_product_id = $variation_id ? (int) wp_get_post_parent_id( $variation_id ) : (int) $product_id;
    if ( ! $check_product_id ) return $passed;

    $blocked = hc_get_hidden_cat_ids_cascade();
    if ( empty($blocked) ) return $passed;

    if ( has_term( $blocked, 'product_cat', $check_product_id ) ) {
        wc_add_notice( __('This product is unavailable.'), 'error' );
        return false;
    }
    return $passed;
}, 10, 4);

/* ---------------------------------------------------------------------------
 * FIBOSEARCH (Ajax Search for WooCommerce) – free & pro
 * -------------------------------------------------------------------------*/

/**
 * Frontend search query (free & pro): exclude hidden-category products.
 */
add_filter('dgwt/wcas/search_query/args', function ($args) {
    $hidden = hc_get_hidden_cat_ids();
    if ( empty($hidden) ) return $args;

    $tax_query   = isset($args['tax_query']) ? (array) $args['tax_query'] : [];
    $tax_query[] = [
        'taxonomy'         => 'product_cat',
        'field'            => 'term_id',
        'terms'            => $hidden,
        'operator'         => 'NOT IN',
        'include_children' => true,
    ];
    $args['tax_query'] = $tax_query;
    return $args;
});

/**
 * Pro indexer: prevent indexing hidden-category products.
 */
add_filter('dgwt/wcas/indexer/tax_query', function ($tax_query) {
    $hidden = hc_get_hidden_cat_ids();
    if ( empty($hidden) ) return $tax_query;

    $tax_query[] = [
        'taxonomy'         => 'product_cat',
        'field'            => 'term_id',
        'terms'            => $hidden,
        'operator'         => 'NOT IN',
        'include_children' => true,
    ];
    return $tax_query;
});

/**
 * Pro TNT engine runtime: exclude hidden-category products.
 */
add_filter('dgwt/wcas/tntsearch/query/args', function ($args) {
    $hidden = hc_get_hidden_cat_ids();
    if ( empty($hidden) ) return $args;

    $args['tax_query'][] = [
        'taxonomy'         => 'product_cat',
        'field'            => 'term_id',
        'terms'            => $hidden,
        'operator'         => 'NOT IN',
        'include_children' => true,
    ];
    return $args;
});

/**
 * Divi-safe hard block: force 404 on hidden-category products
 * even when a custom Divi single-product template is used.
 */
add_action('wp', function () {
    if ( ! is_singular('product') ) return;

    $pid = get_queried_object_id();
    if ( 'product_variation' === get_post_type($pid) ) {
        $parent = (int) wp_get_post_parent_id($pid);
        if ($parent) $pid = $parent;
    }

    $blocked = hc_get_hidden_cat_ids_cascade();
    if ( empty($blocked) ) return;

    if ( has_term($blocked, 'product_cat', $pid) ) {
        // Extra safety: make sure nothing is purchasable/rendered
        add_filter('woocommerce_is_purchasable', '__return_false', 99);
        add_filter('woocommerce_variation_is_purchasable', '__return_false', 99);

        // Force 404 immediately
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        include get_query_template('404');
        exit;
    }
}, 1);

/**
 * FINAL HARD BLOCK (Divi-proof): turn hidden-category products into 404
 * at the earliest reliable point, even with custom templates.
 */
add_filter('pre_handle_404', function ($preempt, $wp_query) {
    // Only act on single product requests
    if ( ! ( isset($wp_query->query_vars['post_type']) && $wp_query->is_singular && $wp_query->query_vars['post_type'] === 'product') ) {
        return $preempt;
    }

    // Determine the product ID being requested
    $pid = isset($wp_query->post) ? (int) $wp_query->post->ID : 0;
    if ( ! $pid && ! empty($wp_query->queried_object_id) ) $pid = (int) $wp_query->queried_object_id;
    if ( ! $pid ) return $preempt;

    // If it's a variation, check the parent product
    if ( get_post_type($pid) === 'product_variation' ) {
        $parent = (int) wp_get_post_parent_id($pid);
        if ($parent) $pid = $parent;
    }

    // Gather product's category IDs and compare to hidden (including descendants)
    if ( ! function_exists('wc_get_product_term_ids') ) return $preempt;
    $product_cat_ids = (array) wc_get_product_term_ids($pid, 'product_cat');

    if ( ! function_exists('hc_get_hidden_cat_ids_cascade') ) return $preempt;
    $blocked = (array) hc_get_hidden_cat_ids_cascade();

    if ( empty($product_cat_ids) || empty($blocked) ) return $preempt;

    // If any intersection -> force 404
    if ( array_intersect($product_cat_ids, $blocked) ) {
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        return true; // tell WP we handled it (serve 404)
    }

    return $preempt;
}, 1, 2);

/**
 * Ultimate block (theme-agnostic): always serve 404 template for hidden-category products.
 */
add_filter('template_include', function ($template) {
    if ( ! is_singular('product') ) return $template;

    $pid = get_queried_object_id();
    if ( get_post_type($pid) === 'product_variation' ) {
        $parent = (int) wp_get_post_parent_id($pid);
        if ($parent) $pid = $parent;
    }

    $blocked = function_exists('hc_get_hidden_cat_ids_cascade') ? hc_get_hidden_cat_ids_cascade() : [];
    if ( empty($blocked) ) return $template;

    $product_cat_ids = function_exists('wc_get_product_term_ids') ? (array) wc_get_product_term_ids($pid, 'product_cat') : [];
    if ( ! $product_cat_ids ) return $template;

    if ( array_intersect($product_cat_ids, $blocked) ) {
        status_header(404);
        nocache_headers();
        $four_oh_four = get_404_template();
        return $four_oh_four ? $four_oh_four : $template;
    }

    return $template;
}, 1);

/**
 * Determine if a product belongs to a hidden category (or any hidden ancestor).
 */
function hc_is_hidden_product( $pid ) {
    if ( get_post_type( $pid ) === 'product_variation' ) {
        $parent = (int) wp_get_post_parent_id( $pid );
        if ( $parent ) $pid = $parent;
    }

    $term_ids = wp_get_post_terms( $pid, 'product_cat', ['fields' => 'ids'] );
    if ( empty( $term_ids ) || is_wp_error( $term_ids ) ) {
        return false;
    }

    foreach ( $term_ids as $tid ) {
        if ( get_term_meta( (int) $tid, 'hc_hidden', true ) === '1' ) {
            return true;
        }
        $ancestors = get_ancestors( (int) $tid, 'product_cat' );
        foreach ( $ancestors as $aid ) {
            if ( get_term_meta( (int) $aid, 'hc_hidden', true ) === '1' ) {
                return true;
            }
        }
    }
    return false;
}

/**
 * Force 404 on direct product URLs when the product is in a hidden category.
 * Works with custom themes/templates (including Divi).
 */
add_action( 'template_redirect', function () {
    if ( ! is_singular( 'product' ) ) return;

    $pid = get_queried_object_id();
    if ( hc_is_hidden_product( $pid ) ) {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        nocache_headers();
        include get_query_template( '404' );
        exit;
    }
}, 0 );

/**
 * Remove hidden-category products from any query result sets.
 * Catches search, widgets, custom loops, and FiboSearch without reindexing.
 */
add_filter( 'posts_results', function ( $posts, $query ) {
    if ( empty( $posts ) || is_admin() ) return $posts;

    $changed  = false;
    $filtered = [];

    foreach ( $posts as $p ) {
        if ( $p->post_type === 'product' && hc_is_hidden_product( $p->ID ) ) {
            $changed = true;
            continue;
        }
        $filtered[] = $p;
    }

    if ( ! $changed ) return $posts;

    // Keep query object in sync so templates don’t think items exist
    $query->posts      = $filtered;
    $query->post_count = count( $filtered );
    return $filtered;
}, 10, 2 );

/**
 * FiboSearch incremental sync (non-blocking).
 * Queues index updates/deletes in small batches so admin saves are fast.
 */
add_action('edited_product_cat', 'hc_fs_queue_after_toggle', 20, 1);
add_action('created_product_cat', 'hc_fs_queue_after_toggle', 20, 1);

function hc_fs_queue_after_toggle( $term_id ) {
    // After save, read current toggle
    $is_hidden = get_term_meta($term_id, 'hc_hidden', true) === '1';

    // Category and all descendants
    $term_ids = [$term_id];
    $children = get_term_children($term_id, 'product_cat');
    if ( ! is_wp_error($children) && $children ) {
        $term_ids = array_merge($term_ids, array_map('intval', $children));
    }

    // Page through products to avoid memory spikes, and enqueue batches
    $paged = 1;
    $per_page = 250;     // adjust if needed
    $batch    = 50;      // indexer ops per async job

    while ( true ) {
        $q = new WP_Query([
            'post_type'           => 'product',
            'post_status'         => 'any',
            'fields'              => 'ids',
            'posts_per_page'      => $per_page,
            'paged'               => $paged,
            'no_found_rows'       => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'tax_query'           => [[
                'taxonomy'         => 'product_cat',
                'field'            => 'term_id',
                'terms'            => $term_ids,
                'include_children' => true,
            ]],
            'suppress_filters'    => true,
        ]);

        if ( empty($q->posts) ) break;

        // Chunk and queue
        $chunks = array_chunk($q->posts, $batch);
        foreach ($chunks as $ids) {
            hc_fs_enqueue_job($ids, $is_hidden ? 'delete' : 'update');
        }

        $paged++;
        wp_reset_postdata();
    }
}

/**
 * Queue a background job using Action Scheduler if available (WooCommerce),
 * otherwise fall back to WP-Cron single event.
 */
function hc_fs_enqueue_job(array $ids, string $operation) {
    // Action name used by the worker below
    $hook = 'hc_fs_sync_worker';

    if ( function_exists('as_enqueue_async_action') ) {
        // WooCommerce Action Scheduler (preferred)
        as_enqueue_async_action($hook, ['ids' => $ids, 'op' => $operation], 'hc-fs');
    } elseif ( function_exists('as_schedule_single_action') ) {
        // Older Action Scheduler API
        as_schedule_single_action(time() + 5, $hook, ['ids' => $ids, 'op' => $operation], 'hc-fs');
    } else {
        // WP-Cron fallback
        wp_schedule_single_event(time() + 5, $hook, ['ids' => $ids, 'op' => $operation]);
    }
}

/**
 * Worker: apply incremental updates to the FiboSearch index.
 * Runs in the background; safe if FiboSearch (Pro) indexer is installed.
 */
add_action('hc_fs_sync_worker', function ($ids, $op) {
    if ( empty($ids) || ! is_array($ids) ) return;

    foreach ( $ids as $pid ) {
        $pid = (int) $pid;
        if ( $pid <= 0 ) continue;

        if ( $op === 'delete' ) {
            do_action('dgwt/wcas/indexer/delete', $pid);
        } else {
            do_action('dgwt/wcas/indexer/update', $pid);
        }
    }
}, 10, 2);

/**
 * FiboSearch: hard-exclude products that belong to hidden categories
 * from ALL product searches (autocomplete + results page), no reindex needed.
 */
add_filter('dgwt/wcas/search/product/args', function ($args) {
    if ( ! function_exists('hc_get_hidden_cat_ids_cascade') ) return $args;

    $blocked = hc_get_hidden_cat_ids_cascade();
    if ( empty($blocked) ) return $args;

    $tax_query   = isset($args['tax_query']) ? (array) $args['tax_query'] : [];
    $tax_query[] = [
        'taxonomy'         => 'product_cat',
        'field'            => 'term_id',
        'terms'            => $blocked,
        'operator'         => 'NOT IN',
        'include_children' => true,
    ];

    $args['tax_query'] = $tax_query;
    return $args;
});

/**
 * FiboSearch: exclude hidden categories (and their descendants) from
 * category suggestions in autocomplete.
 */
add_filter('dgwt/wcas/search/product_cat/args', function ($args) {
    if ( ! function_exists('hc_get_hidden_cat_ids_cascade') ) return $args;

    $blocked = hc_get_hidden_cat_ids_cascade();
    if ( empty($blocked) ) return $args;

    $existing = isset($args['exclude']) ? (array) $args['exclude'] : [];
    $args['exclude'] = array_unique(array_merge($existing, $blocked));
    return $args;
});

add_action('created_product_cat', function ($term_id) {
    update_term_meta($term_id, 'hc_hidden', isset($_POST['hc_hidden']) ? '1' : '0');

    // Tell FiboSearch a category changed (updates just this term in the index)
    $t = get_term($term_id, 'product_cat');
    if ($t && ! is_wp_error($t)) {
        do_action('edited_term', (int) $term_id, (int) $t->term_taxonomy_id, 'product_cat');
    }
});

add_action('edited_product_cat', function ($term_id) {
    update_term_meta($term_id, 'hc_hidden', isset($_POST['hc_hidden']) ? '1' : '0');

    // Tell FiboSearch a category changed (updates just this term in the index)
    $t = get_term($term_id, 'product_cat');
    if ($t && ! is_wp_error($t)) {
        do_action('edited_term', (int) $term_id, (int) $t->term_taxonomy_id, 'product_cat');
    }
});

add_filter('dgwt/wcas/search/product_cat/args', function ($args) {
    if (function_exists('hc_get_hidden_cat_ids_cascade')) {
        $exclude = (array) hc_get_hidden_cat_ids_cascade();
        if (!empty($exclude)) {
            $args['exclude'] = isset($args['exclude'])
                ? array_unique(array_merge((array) $args['exclude'], $exclude))
                : $exclude;
        }
    }
    return $args;
});

