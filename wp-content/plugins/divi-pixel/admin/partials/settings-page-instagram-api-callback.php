<?php
namespace DiviPixel;
// phpcs:ignoreFile

//TODO: Wenn ein Fehler oder unerwartetes Verhalten auftritt, dann sollten wir eine Fehlermeldung im Dashboard anzeigen

//Security checks and early returns if the current GET call isn't of interest
if (!defined('ABSPATH')) {
    die('-1');
}
//If the current auth_provder is not instagram, we can return early
if (!isset($_GET['auth_provider']) || $_GET['auth_provider'] !== 'Instagram') {
    return;
}

//TODO: success most likely has #_ at the end so we need to clean it first
//If there is no success parameter, we don't know whether we should show errors or actually put something in the DB
if (!isset($_GET['success']) || !$_GET['success']) {
    return;
}

//If we don't know wheter its a BASIC or GRAPH API, we can't continue
if (!isset($_GET['auth_type']) || ($_GET['auth_type'] !== DIPI_INSTAGRAM_AUTH_TYPE_BASIC && $_GET['auth_type'] !== DIPI_INSTAGRAM_AUTH_TYPE_GRAPH)) {
    //TODO: Here we could show a error message
    return;
}

switch ($_GET['auth_type']) {
    case DIPI_INSTAGRAM_AUTH_TYPE_BASIC:
        dipi_handle_instagram_basic_token();
        break;
    case DIPI_INSTAGRAM_AUTH_TYPE_GRAPH:
        dipi_handle_instagram_graph_token();
        break;
}

function dipi_handle_instagram_basic_token()
{
    $access_token = DIPI_Instagram_Basic_API::get_access_token_by_code($_GET['code']);
    if(!$access_token){
        //TODO: Error handling
        dipi_err("Couldn't retrieve access token");
        return;
    }
    
    if(!DIPI_Instagram_Basic_API::update_account($access_token)){
        //TODO: Error handling
        dipi_err("Couldn't connect account");
    }
}

function dipi_handle_instagram_graph_token()
{
    $access_token = DIPI_Instagram_Graph_API::get_access_token_by_code($_GET['code']);
    if(!$access_token){
        //TODO: Error handling
        dipi_err("Couldn't retrieve access token");
        return;
    }
    
    if(!DIPI_Instagram_Graph_API::update_account($access_token)){
        //TODO: Error handling
        dipi_err("Couldn't connect account");
    }
}
