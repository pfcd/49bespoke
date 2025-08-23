<?php 
    namespace DiviPixel;
 
    global $post, $wp;
    
    $page_id = DIPI_Settings::get_option('coming_soon_page');
    $coming_soon_vip = DIPI_Settings::get_option('coming_soon_vip');
 
    $vip_url = isset( $coming_soon_vip ) ? sanitize_title_with_dashes( $coming_soon_vip ) : '';
    $vip_expire_days	=  7;
		
    $current_slug = add_query_arg( array(), $wp->request );
  
   
    // If we're on the VIP URL.
    if( $current_slug === $vip_url && !empty($vip_url)) {  
        
        // Set VIP cookie if not already set.
        if( ! isset( $_COOKIE['dipi-vip-allow'] ) ) :
            setcookie( 'dipi-vip-allow', 1, time() + $vip_expire_days * 86400 );
        endif;
        wp_redirect( get_site_url() );
        exit;
    };
 
    
    $vip_cookie_active = false;
    if(isset( $_COOKIE[ 'dipi-vip-allow' ] )){
        $vip_cookie_active = true;
    }
  
    if ( $page_id != '' && $page_id != NULL ) {
       
        $path_redirect_to = get_permalink( $page_id );
    
        // Check if user is logged in
        if ( is_user_logged_in() || $vip_cookie_active) {
            return false;
        }
        
        
        // Check for custom login page
        $admin_url = get_admin_url( null, '/' );
        $site_url  = site_url();
        $admin_url = str_replace( $site_url, '', $admin_url );
        $admin_url = str_replace( '/', '', $admin_url );
        

        // phpcs:disable
        if ( preg_match("/login|admin|$admin_url/i", $_SERVER['REQUEST_URI'] ) > 0 ) {
            return false;
        }
        // phpcs:enable
        
        // Sets the headers to prevent caching for the different browsers and other popular plugins
        nocache_headers();
        
        if ( !defined('DONOTCACHEPAGE') ) {
            define( 'DONOTCACHEPAGE', true );
        }
        
        if ( !defined( 'DONOTCDN' ) ) {
            define( 'DONOTCDN', true );
        }
        
        if ( !defined( 'DONOTCACHEOBJECT' ) ) {
            define( 'DONOTCACHEOBJECT', true );
        }
        
        if ( !defined( 'DONOTCACHEDB' ) ) {
            define( 'DONOTCACHEDB', true );
        }

        if(isset($wp->request)) {
             $current_url = trailingslashit( home_url( $wp->request ) );

             if ( $current_url != $path_redirect_to ) {
                wp_redirect( $path_redirect_to );
                exit;
            }
            else {
                
                return false;
            }

        } else {
            if ( !isset($wp->query_vars['page_id']) || $page_id != $wp->query_vars['page_id'] ) {
                wp_redirect( $path_redirect_to );
                exit;
            }
            else {
                
                return false;
            }
        }
        // Check current url to prevent redirect loop
       
        // if ( $current_url != $path_redirect_to ) {
       
    }
    return false;

 