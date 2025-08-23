<?php
namespace DiviPixel;

abstract class DIPI_Instagram_API
{
    protected $appId;
    protected $appSecret;
    protected $cacheTable;

    /**
     * Get the URL to load the media from the API. Since both API use the same
     * structure to load children of a medium, the only difference is the base 
     * URL, hence we can have a generic function in the base class and the sub-
     * classes only need to provide the correct url.
     */

    abstract protected function get_media_url($account_id);
    /**
     * Get the URL to load the children of a medium from the API. Since both API 
     * use the same structure to load children of a medium, the only difference 
     * is the base URL, hence we can have a generic function in the base class 
     * and the subclasses only need to provide the correct url.
     */
    abstract protected function get_medium_children_url($parent_medium_id);

    /**
     * Check if the provided account id belongs to a connected account. Since
     * both API use a different structure to store the accounts via DIPI_Settings,
     * we let the subclasses decide how to return the account. 
     * 
     * Returns false if the account is not connected
     */
    abstract protected function get_instagram_account($account_id);
        
    /**
     * Lets DIPI_Settings update the instagram account. Since both API use a 
     * different structure for storing the accounts, we let the subclasses
     * handle this.
     */
    abstract protected function set_instagram_account($instagram_account);
    
    abstract public function reset_cache();

    public function __construct()
    {
        global $wpdb;
        $this->cacheTable = $wpdb->prefix . 'dipi_instagram_media';
    }

    protected function cache_medium($instagram_account, $medium, $parent_id = null)
    {
        //TODO: Instead of immediately downloading the image, which might take some time, we can place this a scheduled function or ignore it completely (then user is responsible for clearing the cache when he deletes images)
        // $this->save_image_to_uploads($account_id, $medium['id'], $medium['media_url']);

        $sql_data = [
            'account_id' => $instagram_account['id'],
            'media_id' => $medium['id'],
            'timestamp' => $medium['timestamp'],
            'caption' => isset($medium['caption']) ? $medium['caption'] : null,
            'media_type' => $medium['media_type'],
            'permalink' => $medium['permalink'],
            'media_url' => $medium['media_url'],
            'parent_id' => $parent_id,
        ];

        $sql_datatypes = [
            '%d', //account_id
            '%d', //media_id
            '%s', //timestamp
            '%s', //caption
            '%s', //media_type
            '%s', //permalink
            '%s', //media_url
            '%d', //parent_id
        ];

        //Check if the current medium is a carousel, in which case we also want to save its children
        if ($medium['media_type'] === 'CAROUSEL_ALBUM') {
            $this->get_medium_children($instagram_account, $medium);
            $sql_data['children_count'] = count($medium['children']['data']);
            $sql_datatypes[] = '%d';
        }
        global $wpdb;
        $wpdb->replace($this->cacheTable, $sql_data, $sql_datatypes);
    }

    protected function get_medium_children($instagram_account, $parent_medium)
    {
        dipi_log("get_medium_children(): lade children für " .$parent_medium['id'] );
        if (!isset($parent_medium['children']) || !isset($parent_medium['children']['data']) || empty($parent_medium['children']['data'])) {
            dipi_log("Can't load children of " . $parent_medium['id'] . " because there are no children available");
            return false;
        }

        $children_url = add_query_arg([
            'access_token' => $instagram_account['access_token'],
            'fields' => 'id,media_type,media_url,permalink,timestamp,children',
        ], $this->get_medium_children_url($parent_medium['id']));
        $children = wp_remote_get($children_url);
        if (is_wp_error($children)) {
            return false;
        }

        $children = json_decode($children['body'], true);
        if (!isset($children['data']) || empty($children['data'])) {
            dipi_log("missing data, probaly error", $children);
            return false;
        }

        foreach ($children['data'] as $index => $child_medium) {
            $this->cache_medium($instagram_account, $child_medium, $parent_medium['id']);
        }
    }

    /**
     * This function will clear the DB cache for a given account and will also update
     * the information of the provided account. However, it will not save the updated account 
     * in the Divi Pixel options. This has to be done manually afterwards.
     */
    protected function clear_cache(&$instagram_account)
    {
        dipi_log("DIPI_Instagram_API->clear_cache({$instagram_account['id']})");
        //TODO: Make sure to remove cached images from disk but this could be done via a scheduler function as well
        global $wpdb;
        $table_name = $this->cacheTable;
        $deleted_rows = $wpdb->delete($table_name, ['account_id' => $instagram_account['id']], ['%d']);

        unset($instagram_account['cache_updated']);
        unset($instagram_account['next_page']);

        if (!$deleted_rows) {
            dipi_log("Failed to clear cache for {$instagram_account['id']}. Either there are no entries or something went wrong.");
        } else {
            dipi_log("Deleted {$deleted_rows} rows from cache for account {$instagram_account['id']}");
            error_log(print_r(debug_backtrace(), true));
        }

        return $deleted_rows;
    }

    /**
     * Counts the number of media entries in our cache and returns it.
     * The count is based on the id of the provided accont. 
     */
    protected function cache_entry_count($instagram_account)
    {
        global $wpdb;
        $table_name = $this->cacheTable;

        // phpcs:disable
        $count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$table_name}
            WHERE account_id=%d AND parent_id IS NULL",
            $instagram_account['id']
        ));
        // phpcs:enable

        dipi_log("$count Bilder im Cache gefunden für Account {$instagram_account['id']}");
        return $count;
    }

    /**
     * Load the media for the given account from our DB cache
     */
    protected function get_media_cached($account_id, $count, $page)
    {
        global $wpdb;
        $table_name = $this->cacheTable;
        $offset = $count * $page;
        
        // phpcs:disable
        $result =  $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$table_name}
            WHERE account_id=%d AND parent_id IS NULL
            ORDER BY `timestamp` DESC
            LIMIT {$offset},{$count}",
            $account_id
        ), ARRAY_A);
        // phpcs:enable
        
        return $result;
    }

    public function get_media($account_id, $count, $page = 0)
    {
        $first = $count * $page;
        $last = $count + $first;
        
        dipi_log("DIPI_Instagram_API::get_media() für account=$account_id, count=$count, page=$page. Lade Bilder $first-$last" );

        //Get the instagram account with its meta data. If the account in question isn't connected, we can return early. 
        $instagram_account = $this->get_instagram_account($account_id);
        if (!$instagram_account) {
            return false;
        }

        //If the access token is invalid, we can return early since we won't be able to load images later on
        if ($instagram_account['access_token_status'] !== 'valid') {
            dipi_log("We found an account but the access token is invalid");
            return false;
        }



        //Check if cache is still valid but only if the page is 0. If the page is greater than that, we won't
        //reset the cache even if its outdated, as we would have to load all possible images up to this point, 
        //which might use up all the api calls
        if ($page === 0 && !$this->is_cache_valid($instagram_account)) {
            dipi_log("Page ist 0 und Cache ist nicht mehr valide.");
            $this->clear_cache($instagram_account);
        }
        
        //Check whether or not we have enough cached images. If we have, then we can simply return them. 
        $cache_entry_count = $this->cache_entry_count($instagram_account);
        if ($cache_entry_count >= ($count + $count * $page)) {
            dipi_log("Mehr als genug Medien im Cache ($cache_entry_count). Wir müssen nichts laden");
            return $this->get_media_cached($account_id, $count, $page);
        }

        //If we don't have enough images, e. g. if we want a page we haven't cached before or if the cache just
        //got resetted, check if there are images to load for the account. If we already loaded all images into
        //our cache, then that means there is nothing else we could load. In that case we can return early and 
        //don't need to waste any more API calls. This would also be true for accounts with 0 images on it
        if($cache_entry_count >= $instagram_account['media_count']){
            dipi_log("Wir haben wohl schon alle Bilder des Accounts gelden: $cache_entry_count/{$instagram_account['media_count']}");
            return $this->get_media_cached($account_id, $count, $page);
        }




        //TODO: It could happen, that while user a is on the frontend and already views images 101-200 and wants to load 201-300,
        //in the meantime, the cache was reset so that when user wants to load images 201-300, the cache has 0 or maybe 1-101 in it.
        //In that case, there might be no next_page and the API would load 1-100, 101-200 and 201-300. This is somewhat ok but could
        //lead to issues if many more pages would need to be loaded. It's not urgend for the MVP but we should come up with a failsafe



        //Now that we know that we can load additional images via the API, we can do so and load 100 at once to
        //later save some API calls. Also different modules could call us with different page sizes. So to make
        //the "after" parameter work to its best, we always call the API with a page size of 100        
        $needs_more_images = true;
        while ($needs_more_images) {
            $query_args = [
                'access_token' => $instagram_account['access_token'],
                'fields' => 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,children',
                'limit' => '100',
            ];
    
            if (isset($instagram_account['next_page'])) {
                $query_args['after'] = $instagram_account['next_page'];
            }
    
            $media_url = add_query_arg($query_args, $this->get_media_url($instagram_account['id']));
            dipi_log("Lade Bilder von $media_url");

            $media = wp_remote_get($media_url);
            if (is_wp_error($media)) {
                return false;
            }

            $media = json_decode($media['body'], true);
            if (!isset($media['data'])) {
                dipi_log("DIPI_Instagram_API::get_media(): missing body data , probaly due to an error", $media);
                return false;
            }

            //Download all the media
            foreach ($media['data'] as $index => $medium) {
                $this->cache_medium($instagram_account, $medium);
            }

            //Calulate how many images we now have
            $cache_entry_count += count($media['data']);

            //Update account meta data
            //FIXME: on the very last page (at least in the graph API), there is no data and no paging object 
            //in the response json. therefore we should check if it exists before applying it. But should we really
            //unset the variable once we loaded everything?
            if(isset($media['paging'])){
                $instagram_account['next_page'] = $media['paging']['cursors']['after'];
            } else {
                unset($instagram_account['next_page']);
            }
            $instagram_account['cache_updated'] = time();

            //Update the account in DIPI_Settings
            $this->set_instagram_account($instagram_account);

            //If there are no more images to load, break the while even if we don't have enough images yet
            //We can $needs_more_images later to adjust the DB Query if needed
            if (empty($media['data'])) {
                break;
            }

            //If we loaded enough images, we can exit the while-loop gracefully
            if ($cache_entry_count >= $count * $page + $count) {
                $needs_more_images = false;
            }
        }

        //After loading images via the API we can finally return everything we got. 
        //If we don't have enough images at this point, we won't be able to load more anyways
        return $this->get_media_cached($account_id, $count, $page);
    }

    public static function save_image_to_uploads($account_id, $image_id, $image_url)
    {
        //TODO: Implement error handling strategies

        //Create directory for account if it doesn't exist yet
        $upload_dir = wp_upload_dir();
        $instagram_dir = $upload_dir['basedir'] . '/divi-pixel/instagram_basic';
        if (!file_exists($instagram_dir)) {
            wp_mkdir_p($instagram_dir);
        }

        include_once ABSPATH . 'wp-admin/includes/image.php';
        $contents = file_get_contents($image_url);

        $image_type = explode('/', getimagesize($image_url)['mime']);
        $image_type = end($image_type);
        $file_name = "{$account_id}_{$image_id}.{$image_type}";

        $savefile = fopen("{$instagram_dir}/{$file_name}", 'w');
        fwrite($savefile, $contents);
        fclose($savefile);
    }

    protected static function is_cache_valid($instagram_account)
    {
        return isset($instagram_account['cache_updated']) && $instagram_account['cache_updated'] > time() - 3600;
    }


}
