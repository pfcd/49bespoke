<?php
namespace DiviPixel;

class DIPI_Instagram_Graph_API extends DIPI_Instagram_API
{
    private static $instance = null;

    public function __construct()
    {
        parent::__construct();
        $this->appId = DIPI_Settings::get_option('instagram_graph_app_id');
        $this->appSecret = DIPI_Settings::get_option('instagram_graph_app_secret');
    }

    protected function get_media_url($account_id){
        return "https://graph.facebook.com/v11.0/{$account_id}/media";
    }

    protected function get_medium_children_url($parent_medium_id){
        return "https://graph.facebook.com/v11.0/{$parent_medium_id}/children";
    }

    public function get_instagram_account($account_id){
        $facebook_accounts = DIPI_Settings::get_option('facebook_accounts');
        foreach ($facebook_accounts as $facebook_account_id => $facebook_account) {
            if (!isset($facebook_account['instagram_accounts'][$account_id]) || empty($facebook_account['instagram_accounts'][$account_id])) {
                continue;
            }
            
            if ($facebook_account['access_token_status'] !== 'valid') {
                dipi_log("We found an account but the access token is invalid");
                return false;
            }

            $instagram_account = $facebook_account['instagram_accounts'][$account_id];
            $instagram_account['access_token'] = $facebook_account['access_token'];
            $instagram_account['access_token_status'] = $facebook_account['access_token_status'];
            return $instagram_account; 
        }

        dipi_log('trying to load images from non-existent insta graph account');
        return false;
    }

    protected function set_instagram_account($instagram_account){
        $facebook_accounts = DIPI_Settings::get_option('facebook_accounts');
        foreach ($facebook_accounts as $facebook_account_id => &$facebook_account) {
            if (!isset($facebook_account['instagram_accounts'][$instagram_account['id']])) {
                continue;
            }
            $facebook_account['instagram_accounts'][$instagram_account['id']] = $instagram_account;
        }
        DIPI_Settings::update_option('facebook_accounts', $facebook_accounts);
    }
    
    public function reset_cache()
    {
        $facebook_accounts = DIPI_Settings::get_option('facebook_accounts');
        
        $deleted_rows = 0;
        foreach ($facebook_accounts as $facebook_account_id => &$facebook_account) {
            foreach ($facebook_account['instagram_accounts'] as $instagram_account_id => &$instagram_account) {
                dipi_log("DIPI_Instagram_Graph_API->reset_cache() for account {$instagram_account['id']} ({$instagram_account['username']})");
                $deleted_rows += self::instance()->clear_cache($instagram_account);    
            }
        }

        DIPI_Settings::update_option('facebook_accounts', $facebook_accounts);

        return $deleted_rows;
    }

    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Returns a long lived access token
     *
     * By providing the code after the initial connection to instagram has been
     * established, this function will first retrieve a short lived access token
     * which it will then exchange for a long lived one, which then will be
     * returned.
     */
    public static function get_access_token_by_code($code)
    {
        //Get the user access token
        $url = add_query_arg([
            'client_id' => self::instance()->appId,
            'client_secret' => self::instance()->appSecret,
            'redirect_uri' => DIPI_INSTAGRAM_REDIRECT_URL,
            'code' => $code,
        ], 'https://graph.facebook.com/v11.0/oauth/access_token');

        $access_token = wp_remote_get($url);

        if (is_wp_error($access_token)) {
            return false;
        }

        $access_token = json_decode($access_token['body'], true);

        if (!isset($access_token['access_token']) || empty($access_token['access_token'])) {
            return false;
        }

        return $access_token['access_token'];
    }

    /**
     * Returns a refreshed access token
     *
     * By providing a valid, long lived access token, this function will
     * try to refresh the access token and return it
     */
    public static function refresh_access_token($access_token)
    {
        $client_code_url = add_query_arg([
            'client_id' => self::instance()->appId,
            'client_secret' => self::instance()->appSecret,
            'redirect_uri' => DIPI_INSTAGRAM_REDIRECT_URL,
            'access_token' => $access_token,
        ], 'https://graph.facebook.com/v11.0/oauth/client_code');

        $client_code = wp_remote_get($client_code_url);

        if (is_wp_error($client_code)) {
            return false;
        }

        $client_code = json_decode($client_code['body'], true);

        if (!isset($client_code['code']) || empty($client_code['code'])) {
            return false;
        }

        return self::get_access_token_by_code($client_code['code']);
    }

    /**
     * Returns the contents of the /me endpoint as associative array
     */
    public static function me($access_token)
    {
        $me = wp_remote_get("https://graph.facebook.com/v11.0/me?access_token={$access_token}&fields=id,name");
        if (is_wp_error($me)) {
            return false;
        }

        $me = json_decode($me['body'], true);

        if (!isset($me['id']) || empty($me['id'])) {
            return false;
        }

        return $me;
    }

    public static function update_account($access_token)
    {
        //Get basic information about the facebook account associated with the access token
        $me = self::me($access_token);
        if (!$me) {
            //TODO: Error handling
            return false;
        }

        //Get the connected accounts of the facebook account associated with the access token
        $accounts_url = add_query_arg([
            'access_token' => $access_token,
            'fields' => 'id,instagram_business_account',
            'limit' => '-1',
        ], 'https://graph.facebook.com/v11.0/me/accounts');

        $accounts = wp_remote_get($accounts_url);
        if (is_wp_error($accounts)) {
            //TODO: Error handling
            return false;
        }

        $accounts = json_decode($accounts['body'], true);
        if (!isset($accounts['data']) || empty($accounts['data'])) {
            //TODO Errorhandling
            return false;
        }

        //Array used to store the Facebook account information
        $facebook_account = [
            'id' => $me['id'],
            'name' => $me['name'],
            'instagram_accounts' => [],
            'access_token' => $access_token,
            'access_token_status' => 'valid',
            'updated' => time(),
            'auth_type' => DIPI_INSTAGRAM_AUTH_TYPE_GRAPH,
        ];

        //Accounts are the connected Facebook pages so we go over all of them...
        foreach ($accounts['data'] as $account) {
            //...and skip accounts which have no Instagram account connected to them
            if (!isset($account['instagram_business_account'])) {
                continue;
            }

            //Retrieve the actualy Instagram account
            $account_id = $account['instagram_business_account']['id'];
            $instagram_account_url = add_query_arg([
                'access_token' => $access_token,
                'fields' => 'followers_count,follows_count,biography,id,website,profile_picture_url,name,username,media_count',
            ], "https://graph.facebook.com/v11.0/{$account_id}");

            $instagram_account = wp_remote_get($instagram_account_url);
            if (is_wp_error($instagram_account)) {
                //TODO: Error handling
                continue;
            }

            $instagram_account = json_decode($instagram_account['body'], true);
            if (!isset($instagram_account['id']) || empty($instagram_account['id'])) {
                //TODO: Error handling
                continue;
            }

            $facebook_account['instagram_accounts'][$instagram_account['id']] = $instagram_account;
        }

        $facebook_accounts = DIPI_Settings::get_option('facebook_accounts');
        $facebook_accounts[$me['id']] = $facebook_account;

        return DIPI_Settings::update_option('facebook_accounts', $facebook_accounts);
    }

    public static function update_accounts()
    {
        $facebook_accounts = DIPI_Settings::get_option('facebook_accounts');

        $access_tokens = [];
        foreach ($facebook_accounts as $account_id => $account) {
            //Skip accounts with invalid access token
            if ($account['access_token_status'] !== 'valid') {
                continue;
            }

            //Skip accounts which have already been updated within the last 24h
            // if($account['updated'] + 24 * 60 * 60 > time()){
            if ($account['updated'] + 20 > time()) {
                continue;
            }

            //Refresh the access token. If it failes, count the failed attemts. If there are too many fails, then the token is probably invalid so we can update the account to reflect that in the dashboard
            $access_token = self::refresh_access_token($account['access_token']);
            if (!$access_token) {
                $account['refresh_access_token_retries'] = isset($account['refresh_access_token_retries']) ? $account['refresh_access_token_retries'] + 1 : 1;

                if ($account['refresh_access_token_retries'] >= 3) {
                    $account['access_token_status'] = 'invalid';
                }

                continue;
            }

            $account['access_token'] = $access_token;
            $account['updated'] = time();
            $access_tokens[] = $access_token;
            $facebook_accounts[$account_id] = $account;
        }

        //If there are no changes, then update_option will return false
        if (!DIPI_Settings::update_option('facebook_accounts', $facebook_accounts)) {
            return;
        }

        //Update all accounts which have gotten a refreshed access token
        foreach ($access_tokens as $access_token) {
            self::update_account($access_token);
        }
    }
}