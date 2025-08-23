<?php
namespace DiviPixel;

class DIPI_Instagram_Basic_API extends DIPI_Instagram_API
{
    private static $instance = null;

    public function __construct()
    {
        parent::__construct();
        $this->appId = DIPI_Settings::get_option('instagram_basic_app_id');
        $this->appSecret = DIPI_Settings::get_option('instagram_basic_app_secret');
    }

    protected function get_media_url($account_id){
        return 'https://graph.instagram.com/me/media';
    }

    protected function get_medium_children_url($parent_medium_id){
        return "https://graph.instagram.com/{$parent_medium_id}/children";
    }

    public function get_instagram_account($account_id){
        $instagram_accounts = DIPI_Settings::get_option('instagram_accounts');
        if (!isset($instagram_accounts[$account_id]) || empty($instagram_accounts[$account_id])) {
            dipi_log('trying to load images from non-existent insta basic account');
            return false;
        }
        
        return $instagram_accounts[$account_id];
    }

    protected function set_instagram_account($instagram_account){
        $instagram_accounts = DIPI_Settings::get_option('instagram_accounts');
        $instagram_accounts[$instagram_account['id']] = $instagram_account;
        DIPI_Settings::update_option('instagram_accounts', $instagram_accounts);
    }

    public function reset_cache()
    {
        $instagram_accounts = DIPI_Settings::get_option('instagram_accounts');

        $deleted_rows = 0;
        foreach ($instagram_accounts as $account_id => &$instagram_account) {
            dipi_log("DIPI_Instagram_Basic_API->reset_cache() for account {$instagram_account['id']} ({$instagram_account['username']})");
            $deleted_rows += self::instance()->clear_cache($instagram_account);
        }
        DIPI_Settings::update_option('instagram_accounts', $instagram_accounts);

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

        //Get a short lived access token
        $access_token_short = wp_remote_post('https://api.instagram.com/oauth/access_token', [
            'body' => [
                'client_id' => self::instance()->appId,
                'client_secret' => self::instance()->appSecret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => 'https://auth.divi-pixel.com/instagram',
                'code' => $code,
            ],
        ]);

        if (is_wp_error($access_token_short)) {
            return false;
        }

        $access_token_short = json_decode($access_token_short['body']);

        if (!isset($access_token_short->access_token)) {
            return false;
        }

        //Get a long lived access token
        $url = add_query_arg([
            'grant_type' => 'ig_exchange_token',
            'client_secret' => self::instance()->appSecret,
            'access_token' => $access_token_short->access_token,
        ], "https://graph.instagram.com/access_token");

        $access_token_long = wp_remote_get($url);

        if (is_wp_error($access_token_long)) {
            return false;
        }

        $access_token_long = json_decode($access_token_long['body'], true);

        if (!isset($access_token_long['access_token']) || empty($access_token_long['access_token'])) {
            return false;
        }

        return $access_token_long['access_token'];
    }

    /**
     * Returns a refreshed access token
     *
     * By providing a valid, long lived access token, this function will
     * try to refresh the access token and return it
     */
    public static function refresh_access_token($access_token)
    {
        $url = add_query_arg([
            'grant_type' => 'ig_refresh_token',
            'access_token' => $access_token,
        ], 'https://graph.instagram.com/refresh_access_token');

        $new_access_token = wp_remote_get($url);

        if (is_wp_error($new_access_token)) {
            return false;
        }

        $new_access_token = json_decode($new_access_token['body'], true);

        if (!isset($new_access_token['access_token']) || empty($new_access_token['access_token'])) {
            return false;
        }

        return $new_access_token['access_token'];
    }

    /**
     * Returns the contents of the /me endpoint as associative array
     */
    public static function me($access_token)
    {
        $me = wp_remote_get("https://graph.instagram.com/me?fields=account_type,id,username,media_count&access_token={$access_token}");
        if (is_wp_error($me)) {
            return false;
        }

        $me = json_decode($me['body'], true);

        if (!isset($me['id']) || empty($me['id'])) {
            return false;
        }

        return $me;
    }

    /**
     * Updates an account by providing a valid access token. Returns false
     * if either /me endpoint failed or update couldn't be stored in options
     */
    public static function update_account($access_token)
    {
        $me = self::me($access_token);
        if (!$me) {
            //TODO: Error handling
            return false;
        }

        //Save the new token and updated infromation in our options
        $instagram_accounts = DIPI_Settings::get_option('instagram_accounts');
        $instagram_accounts[$me['id']] = [
            'id' => $me['id'],
            'account_type' => $me['account_type'],
            'username' => $me['username'],
            'media_count' => $me['media_count'],
            'access_token' => $access_token,
            'updated' => time(),
            'access_token_status' => 'valid',
            'auth_type' => DIPI_INSTAGRAM_AUTH_TYPE_BASIC,
        ];

        dipi_log("Wir haben einen Token: " . $access_token);

        return DIPI_Settings::update_option('instagram_accounts', $instagram_accounts);
    }

    public static function update_accounts()
    {
        $instagram_accounts = DIPI_Settings::get_option('instagram_accounts');

        $access_tokens = [];
        foreach ($instagram_accounts as $account_id => $account) {
            //Skip accounts with invalid access token
            if ($account['access_token_status'] !== 'valid') {
                continue;
            }

            //Skip accounts which have already been updated within the last 24h
            if ($account['updated'] + 24 * 60 * 60 > time()) {
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
            $instagram_accounts[$account_id] = $account;
        }

        //If there are no changes, then update_option will return false
        if (!DIPI_Settings::update_option('instagram_accounts', $instagram_accounts)) {
            return;
        }

        //Update all accounts which have gotten a refreshed access token
        foreach ($access_tokens as $access_token) {
            self::update_account($access_token);
        }
    }

}
