<?php
namespace DiviPixel;

// Get the globals where the structure might already be stored
global $dipi_primary_menu_social_icons;
global $dipi_secondary_menu_social_icons;
global $dipi_footer_menu_social_icons;
global $dipi_mobile_menu_social_icons;
global $dipi_social_icons_globals_set;


if($dipi_social_icons_globals_set){
    // FIXME: Diese Initialisierung gehört eigentlich in DIPI_Settings
    $primary_menu_social_icons = $dipi_primary_menu_social_icons;
    $secondary_menu_social_icons = $dipi_secondary_menu_social_icons;
    $footer_menu_social_icons = $dipi_footer_menu_social_icons;
    $mobile_menu_social_icons = $dipi_mobile_menu_social_icons;
    return;
} 

$primary_menu_social_icons = [];
$secondary_menu_social_icons = [];
$footer_menu_social_icons = [];
$mobile_menu_social_icons = [];

// If the globals are not set yet, calculate the structure
$social_icons_individual_location = DIPI_Settings::get_option('social_icons_individual_location');

$social_icons_menu = DIPI_Settings::get_option('social_icons_menu');
$social_icons_mobile_menu = DIPI_Settings::get_option('social_icons_mobile_menu');
$social_icons_footer = DIPI_Settings::get_option('social_icons_footer');

$facebook_url = DIPI_Settings::get_option('social_media_facebook');
$instagram_url = DIPI_Settings::get_option('social_media_instagram');
$twitter_url = DIPI_Settings::get_option('social_media_twitter');
$youtube_url = DIPI_Settings::get_option('social_media_youtube');
$pinterest_url = DIPI_Settings::get_option('social_media_pinterest');
$vimeo_url = DIPI_Settings::get_option('social_media_vimeo');
$tumblr_url = DIPI_Settings::get_option('social_media_tumblr');
$linkedin_url = DIPI_Settings::get_option('social_media_linkedin');
$flickr_url = DIPI_Settings::get_option('social_media_flickr');
$dribbble_url = DIPI_Settings::get_option('social_media_dribbble');
$skype_url = DIPI_Settings::get_option('social_media_skype');
$google_url = DIPI_Settings::get_option('social_media_google');
$xing_url = DIPI_Settings::get_option('social_media_xing');
$whatsapp_url = DIPI_Settings::get_option('social_media_whatsapp');
$snapchat_url = DIPI_Settings::get_option('social_media_snapchat');
$soundcloud_url = DIPI_Settings::get_option('social_media_soundcloud');
$tiktok_url = DIPI_Settings::get_option('social_media_tiktok');
$telegram_url = DIPI_Settings::get_option('social_media_telegram');
$line_url = DIPI_Settings::get_option('social_media_line');
$quora_url = DIPI_Settings::get_option('social_media_quora');
$tripadvisor_url = DIPI_Settings::get_option('social_media_tripadvisor');
$twitch_url = DIPI_Settings::get_option('social_media_twitch');
$yelp_url = DIPI_Settings::get_option('social_media_yelp');
$spotify_url = DIPI_Settings::get_option('social_media_spotify');

if ($facebook_url) {
    $facebook_icon = [
        'url' => $facebook_url,
        'icon' => "dp-facebook.svg",
        'title' => esc_html__('facebook', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {
        $social_media_facebook_menu = DIPI_Settings::get_option('social_media_facebook_menu');
        $social_media_facebook_mobile_menu = DIPI_Settings::get_option('social_media_facebook_mobile_menu');
        $social_media_facebook_footer = DIPI_Settings::get_option('social_media_facebook_footer');

        if ($social_media_facebook_menu == 'primary') {
            $primary_menu_social_icons[] = $facebook_icon;
        } else if ($social_media_facebook_menu == 'secondary') {
            $secondary_menu_social_icons[] = $facebook_icon;
        }

        if ($social_media_facebook_footer) {
            $footer_menu_social_icons[] = $facebook_icon;
        }

        if ($social_media_facebook_mobile_menu) {
            $mobile_menu_social_icons[] = $facebook_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $facebook_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $facebook_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $facebook_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $facebook_icon;
        }
    }
}

if ($instagram_url) {

    $instagram_icon = [
        'url' => $instagram_url,
        'icon' => "dp-instagram.svg",
        'title' => esc_html__('instagram', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_instagram_menu = DIPI_Settings::get_option('social_media_instagram_menu');
        $social_media_instagram_mobile_menu = DIPI_Settings::get_option('social_media_instagram_mobile_menu');
        $social_media_instagram_footer = DIPI_Settings::get_option('social_media_instagram_footer');

        if ($social_media_instagram_menu == 'primary') {
            $primary_menu_social_icons[] = $instagram_icon;
        } else if ($social_media_instagram_menu == 'secondary') {
            $secondary_menu_social_icons[] = $instagram_icon;
        }

        if ($social_media_instagram_footer) {
            $footer_menu_social_icons[] = $instagram_icon;
        }

        if ($social_media_instagram_mobile_menu) {
            $mobile_menu_social_icons[] = $instagram_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $instagram_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $instagram_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $instagram_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $instagram_icon;
        }
    }
}

if ($twitter_url) {

    $twitter_icon = [
        'url' => $twitter_url,
        'icon' => "dp-twitter.svg",
        'title' => esc_html__('twitter', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_twitter_menu = DIPI_Settings::get_option('social_media_twitter_menu');
        $social_media_twitter_mobile_menu = DIPI_Settings::get_option('social_media_twitter_mobile_menu');
        $social_media_twitter_footer = DIPI_Settings::get_option('social_media_twitter_footer');

        if ($social_media_twitter_menu == 'primary') {
            $primary_menu_social_icons[] = $twitter_icon;
        } else if ($social_media_twitter_menu == 'secondary') {
            $secondary_menu_social_icons[] = $twitter_icon;
        }

        if ($social_media_twitter_footer) {
            $footer_menu_social_icons[] = $twitter_icon;
        }

        if ($social_media_twitter_mobile_menu) {
            $mobile_menu_social_icons[] = $twitter_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $twitter_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $twitter_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $twitter_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $twitter_icon;
        }
    }
}

if ($youtube_url) {

    $youtube_icon = [
        'url' => $youtube_url,
        'icon' => "dp-youtube.svg",
        'title' => esc_html__('youtube', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_youtube_menu = DIPI_Settings::get_option('social_media_youtube_menu');
        $social_media_youtube_mobile_menu = DIPI_Settings::get_option('social_media_youtube_mobile_menu');
        $social_media_youtube_footer = DIPI_Settings::get_option('social_media_youtube_footer');

        if ($social_media_youtube_menu == 'primary') {
            $primary_menu_social_icons[] = $youtube_icon;
        } else if ($social_media_youtube_menu == 'secondary') {
            $secondary_menu_social_icons[] = $youtube_icon;
        }

        if ($social_media_youtube_footer) {
            $footer_menu_social_icons[] = $youtube_icon;
        }

        if ($social_media_youtube_mobile_menu) {
            $mobile_menu_social_icons[] = $youtube_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $youtube_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $youtube_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $youtube_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $youtube_icon;
        }
    }
}

if ($pinterest_url) {

    $pinterest_icon = [
        'url' => $pinterest_url,
        'icon' => "dp-pinterest.svg",
        'title' => esc_html__('pinterest', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_pinterest_menu = DIPI_Settings::get_option('social_media_pinterest_menu');
        $social_media_pinterest_mobile_menu = DIPI_Settings::get_option('social_media_pinterest_mobile_menu');
        $social_media_pinterest_footer = DIPI_Settings::get_option('social_media_pinterest_footer');

        if ($social_media_pinterest_menu == 'primary') {
            $primary_menu_social_icons[] = $pinterest_icon;
        } else if ($social_media_pinterest_menu == 'secondary') {
            $secondary_menu_social_icons[] = $pinterest_icon;
        }

        if ($social_media_pinterest_footer) {
            $footer_menu_social_icons[] = $pinterest_icon;
        }

        if ($social_media_pinterest_mobile_menu) {
            $mobile_menu_social_icons[] = $pinterest_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $pinterest_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $pinterest_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $pinterest_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $pinterest_icon;
        }
    }
}

if ($vimeo_url) {

    $vimeo_icon = [
        'url' => $vimeo_url,
        'icon' => "dp-vimeo.svg",
        'title' => esc_html__('vimeo', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_vimeo_menu = DIPI_Settings::get_option('social_media_vimeo_menu');
        $social_media_vimeo_mobile_menu = DIPI_Settings::get_option('social_media_vimeo_mobile_menu');
        $social_media_vimeo_footer = DIPI_Settings::get_option('social_media_vimeo_footer');

        if ($social_media_vimeo_menu == 'primary') {
            $primary_menu_social_icons[] = $vimeo_icon;
        } else if ($social_media_vimeo_menu == 'secondary') {
            $secondary_menu_social_icons[] = $vimeo_icon;
        }

        if ($social_media_vimeo_footer) {
            $footer_menu_social_icons[] = $vimeo_icon;
        }

        if ($social_media_vimeo_mobile_menu) {
            $mobile_menu_social_icons[] = $vimeo_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $vimeo_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $vimeo_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $vimeo_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $vimeo_icon;
        }
    }
}

if ($tumblr_url) {

    $tumblr_icon = [
        'url' => $tumblr_url,
        'icon' => "dp-tumblr.svg",
        'title' => esc_html__('tumblr', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_tumblr_menu = DIPI_Settings::get_option('social_media_tumblr_menu');
        $social_media_tumblr_mobile_menu = DIPI_Settings::get_option('social_media_tumblr_mobile_menu');
        $social_media_tumblr_footer = DIPI_Settings::get_option('social_media_tumblr_footer');

        if ($social_media_tumblr_menu == 'primary') {
            $primary_menu_social_icons[] = $tumblr_icon;
        } else if ($social_media_tumblr_menu == 'secondary') {
            $secondary_menu_social_icons[] = $tumblr_icon;
        }

        if ($social_media_tumblr_footer) {
            $footer_menu_social_icons[] = $tumblr_icon;
        }

        if ($social_media_tumblr_mobile_menu) {
            $mobile_menu_social_icons[] = $tumblr_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $tumblr_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $tumblr_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $tumblr_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $tumblr_icon;
        }
    }
}

if ($linkedin_url) {

    $linkedin_icon = [
        'url' => $linkedin_url,
        'icon' => "dp-linkedin.svg",
        'title' => esc_html__('linkedin', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_linkedin_menu = DIPI_Settings::get_option('social_media_linkedin_menu');
        $social_media_linkedin_mobile_menu = DIPI_Settings::get_option('social_media_linkedin_mobile_menu');
        $social_media_linkedin_footer = DIPI_Settings::get_option('social_media_linkedin_footer');

        if ($social_media_linkedin_menu == 'primary') {
            $primary_menu_social_icons[] = $linkedin_icon;
        } else if ($social_media_linkedin_menu == 'secondary') {
            $secondary_menu_social_icons[] = $linkedin_icon;
        }

        if ($social_media_linkedin_footer) {
            $footer_menu_social_icons[] = $linkedin_icon;
        }

        if ($social_media_linkedin_mobile_menu) {
            $mobile_menu_social_icons[] = $linkedin_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $linkedin_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $linkedin_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $linkedin_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $linkedin_icon;
        }
    }
}

if ($flickr_url) {

    $flickr_icon = [
        'url' => $flickr_url,
        'icon' => "dp-flickr.svg",
        'title' => esc_html__('flickr', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_flickr_menu = DIPI_Settings::get_option('social_media_flickr_menu');
        $social_media_flickr_mobile_menu = DIPI_Settings::get_option('social_media_flickr_mobile_menu');
        $social_media_flickr_footer = DIPI_Settings::get_option('social_media_flickr_footer');

        if ($social_media_flickr_menu == 'primary') {
            $primary_menu_social_icons[] = $flickr_icon;
        } else if ($social_media_flickr_menu == 'secondary') {
            $secondary_menu_social_icons[] = $flickr_icon;
        }

        if ($social_media_flickr_footer) {
            $footer_menu_social_icons[] = $flickr_icon;
        }

        if ($social_media_flickr_mobile_menu) {
            $mobile_menu_social_icons[] = $flickr_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $flickr_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $flickr_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $flickr_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $flickr_icon;
        }
    }
}

if ($dribbble_url) {

    $dribbble_icon = [
        'url' => $dribbble_url,
        'icon' => "dp-dribbble.svg",
        'title' => esc_html__('dribbble', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_dribbble_menu = DIPI_Settings::get_option('social_media_dribbble_menu');
        $social_media_dribbble_mobile_menu = DIPI_Settings::get_option('social_media_dribbble_mobile_menu');
        $social_media_dribbble_footer = DIPI_Settings::get_option('social_media_dribbble_footer');

        if ($social_media_dribbble_menu == 'primary') {
            $primary_menu_social_icons[] = $dribbble_icon;
        } else if ($social_media_dribbble_menu == 'secondary') {
            $secondary_menu_social_icons[] = $dribbble_icon;
        }

        if ($social_media_dribbble_footer) {
            $footer_menu_social_icons[] = $dribbble_icon;
        }

        if ($social_media_dribbble_mobile_menu) {
            $mobile_menu_social_icons[] = $dribbble_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $dribbble_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $dribbble_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $dribbble_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $dribbble_icon;
        }
    }
}

if ($skype_url) {

    $skype_icon = [
        'url' => $skype_url,
        'icon' => "dp-skype.svg",
        'title' => esc_html__('skype', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_skype_menu = DIPI_Settings::get_option('social_media_skype_menu');
        $social_media_skype_mobile_menu = DIPI_Settings::get_option('social_media_skype_mobile_menu');
        $social_media_skype_footer = DIPI_Settings::get_option('social_media_skype_footer');

        if ($social_media_skype_menu == 'primary') {
            $primary_menu_social_icons[] = $skype_icon;
        } else if ($social_media_skype_menu == 'secondary') {
            $secondary_menu_social_icons[] = $skype_icon;
        }

        if ($social_media_skype_footer) {
            $footer_menu_social_icons[] = $skype_icon;
        }

        if ($social_media_skype_mobile_menu) {
            $mobile_menu_social_icons[] = $skype_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $skype_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $skype_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $skype_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $skype_icon;
        }
    }
}

if ($google_url) {

    $google_icon = [
        'url' => $google_url,
        'icon' => "dp-google.svg",
        'title' => esc_html__('google', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_google_menu = DIPI_Settings::get_option('social_media_google_menu');
        $social_media_google_mobile_menu = DIPI_Settings::get_option('social_media_google_mobile_menu');
        $social_media_google_footer = DIPI_Settings::get_option('social_media_google_footer');

        if ($social_media_google_menu == 'primary') {
            $primary_menu_social_icons[] = $google_icon;
        } else if ($social_media_google_menu == 'secondary') {
            $secondary_menu_social_icons[] = $google_icon;
        }

        if ($social_media_google_footer) {
            $footer_menu_social_icons[] = $google_icon;
        }

        if ($social_media_google_mobile_menu) {
            $mobile_menu_social_icons[] = $google_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $google_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $google_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $google_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $google_icon;
        }
    }
}

if ($xing_url) {

    $xing_icon = [
        'url' => $xing_url,
        'icon' => "dp-xing.svg",
        'title' => esc_html__('xing', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_xing_menu = DIPI_Settings::get_option('social_media_xing_menu');
        $social_media_xing_mobile_menu = DIPI_Settings::get_option('social_media_xing_mobile_menu');
        $social_media_xing_footer = DIPI_Settings::get_option('social_media_xing_footer');

        if ($social_media_xing_menu == 'primary') {
            $primary_menu_social_icons[] = $xing_icon;
        } else if ($social_media_xing_menu == 'secondary') {
            $secondary_menu_social_icons[] = $xing_icon;
        }

        if ($social_media_xing_footer) {
            $footer_menu_social_icons[] = $xing_icon;
        }

        if ($social_media_xing_mobile_menu) {
            $mobile_menu_social_icons[] = $xing_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $xing_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $xing_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $xing_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $xing_icon;
        }
    }
}


if ($whatsapp_url) {

    $whatsapp_icon = [
        'url' => $whatsapp_url,
        'icon' => "dp-whatsapp.svg",
        'title' => esc_html__('whatsapp', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_whatsapp_menu = DIPI_Settings::get_option('social_media_whatsapp_menu');
        $social_media_whatsapp_mobile_menu = DIPI_Settings::get_option('social_media_whatsapp_mobile_menu');
        $social_media_whatsapp_footer = DIPI_Settings::get_option('social_media_whatsapp_footer');

        if ($social_media_whatsapp_menu == 'primary') {
            $primary_menu_social_icons[] = $whatsapp_icon;
        } else if ($social_media_whatsapp_menu == 'secondary') {
            $secondary_menu_social_icons[] = $whatsapp_icon;
        }

        if ($social_media_whatsapp_footer) {
            $footer_menu_social_icons[] = $whatsapp_icon;
        }

        if ($social_media_whatsapp_mobile_menu) {
            $mobile_menu_social_icons[] = $whatsapp_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $whatsapp_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $whatsapp_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $whatsapp_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $whatsapp_icon;
        }
    }
}

if ($snapchat_url) {

    $snapchat_icon = [
        'url' => $snapchat_url,
        'icon' => "dp-snapchat.svg",
        'title' => esc_html__('snapchat', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_snapchat_menu = DIPI_Settings::get_option('social_media_snapchat_menu');
        $social_media_snapchat_mobile_menu = DIPI_Settings::get_option('social_media_snapchat_mobile_menu');
        $social_media_snapchat_footer = DIPI_Settings::get_option('social_media_snapchat_footer');

        if ($social_media_snapchat_menu == 'primary') {
            $primary_menu_social_icons[] = $snapchat_icon;
        } else if ($social_media_snapchat_menu == 'secondary') {
            $secondary_menu_social_icons[] = $snapchat_icon;
        }

        if ($social_media_snapchat_footer) {
            $footer_menu_social_icons[] = $snapchat_icon;
        }

        if ($social_media_snapchat_mobile_menu) {
            $mobile_menu_social_icons[] = $snapchat_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $snapchat_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $snapchat_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $snapchat_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $snapchat_icon;
        }
    }
}

if ($soundcloud_url) {

    $soundcloud_icon = [
        'url' => $soundcloud_url,
        'icon' => "dp-soundcloud.svg",
        'title' => esc_html__('soundcloud', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_soundcloud_menu = DIPI_Settings::get_option('social_media_soundcloud_menu');
        $social_media_soundcloud_mobile_menu = DIPI_Settings::get_option('social_media_soundcloud_mobile_menu');
        $social_media_soundcloud_footer = DIPI_Settings::get_option('social_media_soundcloud_footer');

        if ($social_media_soundcloud_menu == 'primary') {
            $primary_menu_social_icons[] = $soundcloud_icon;
        } else if ($social_media_soundcloud_menu == 'secondary') {
            $secondary_menu_social_icons[] = $soundcloud_icon;
        }

        if ($social_media_soundcloud_footer) {
            $footer_menu_social_icons[] = $soundcloud_icon;
        }

        if ($social_media_soundcloud_mobile_menu) {
            $mobile_menu_social_icons[] = $soundcloud_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $soundcloud_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $soundcloud_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $soundcloud_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $soundcloud_icon;
        }
    }
}

if ($tiktok_url) {

    $tiktok_icon = [
        'url' => $tiktok_url,
        'icon' => "dp-tiktok.svg",
        'title' => esc_html__('tiktok', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_tiktok_menu = DIPI_Settings::get_option('social_media_tiktok_menu');
        $social_media_tiktok_mobile_menu = DIPI_Settings::get_option('social_media_tiktok_mobile_menu');
        $social_media_tiktok_footer = DIPI_Settings::get_option('social_media_tiktok_footer');

        if ($social_media_tiktok_menu == 'primary') {
            $primary_menu_social_icons[] = $tiktok_icon;
        } else if ($social_media_tiktok_menu == 'secondary') {
            $secondary_menu_social_icons[] = $tiktok_icon;
        }

        if ($social_media_tiktok_footer) {
            $footer_menu_social_icons[] = $tiktok_icon;
        }

        if ($social_media_tiktok_mobile_menu) {
            $mobile_menu_social_icons[] = $tiktok_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $tiktok_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $tiktok_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $tiktok_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $tiktok_icon;
        }
    }
}

if ($telegram_url) {

    $telegram_icon = [
        'url' => $telegram_url,
        'icon' => "dp-telegram.svg",
        'title' => esc_html__('telegram', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_telegram_menu = DIPI_Settings::get_option('social_media_telegram_menu');
        $social_media_telegram_mobile_menu = DIPI_Settings::get_option('social_media_telegram_mobile_menu');
        $social_media_telegram_footer = DIPI_Settings::get_option('social_media_telegram_footer');

        if ($social_media_telegram_menu == 'primary') {
            $primary_menu_social_icons[] = $telegram_icon;
        } else if ($social_media_telegram_menu == 'secondary') {
            $secondary_menu_social_icons[] = $telegram_icon;
        }

        if ($social_media_telegram_footer) {
            $footer_menu_social_icons[] = $telegram_icon;
        }

        if ($social_media_telegram_mobile_menu) {
            $mobile_menu_social_icons[] = $telegram_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $telegram_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $telegram_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $telegram_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $telegram_icon;
        }
    }
}

if ($line_url) {

    $line_icon = [
        'url' => $line_url,
        'icon' => "dp-line.svg",
        'title' => esc_html__('line', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_line_menu = DIPI_Settings::get_option('social_media_line_menu');
        $social_media_line_mobile_menu = DIPI_Settings::get_option('social_media_line_mobile_menu');
        $social_media_line_footer = DIPI_Settings::get_option('social_media_line_footer');

        if ($social_media_line_menu == 'primary') {
            $primary_menu_social_icons[] = $line_icon;
        } else if ($social_media_line_menu == 'secondary') {
            $secondary_menu_social_icons[] = $line_icon;
        }

        if ($social_media_line_footer) {
            $footer_menu_social_icons[] = $line_icon;
        }

        if ($social_media_line_mobile_menu) {
            $mobile_menu_social_icons[] = $line_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $line_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $line_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $line_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $line_icon;
        }
    }
}

if ($quora_url) {

    $quora_icon = [
        'url' => $quora_url,
        'icon' => "dp-quora.svg",
        'title' => esc_html__('quora', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_quora_menu = DIPI_Settings::get_option('social_media_quora_menu');
        $social_media_quora_mobile_menu = DIPI_Settings::get_option('social_media_quora_mobile_menu');
        $social_media_quora_footer = DIPI_Settings::get_option('social_media_quora_footer');

        if ($social_media_quora_menu == 'primary') {
            $primary_menu_social_icons[] = $quora_icon;
        } else if ($social_media_quora_menu == 'secondary') {
            $secondary_menu_social_icons[] = $quora_icon;
        }

        if ($social_media_quora_footer) {
            $footer_menu_social_icons[] = $quora_icon;
        }

        if ($social_media_quora_mobile_menu) {
            $mobile_menu_social_icons[] = $quora_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $quora_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $quora_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $quora_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $quora_icon;
        }
    }
}

if ($tripadvisor_url) {

    $tripadvisor_icon = [
        'url' => $tripadvisor_url,
        'icon' => "dp-tripadvisor.svg",
        'title' => esc_html__('tripadvisor', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_tripadvisor_menu = DIPI_Settings::get_option('social_media_tripadvisor_menu');
        $social_media_tripadvisor_mobile_menu = DIPI_Settings::get_option('social_media_tripadvisor_mobile_menu');
        $social_media_tripadvisor_footer = DIPI_Settings::get_option('social_media_tripadvisor_footer');

        if ($social_media_tripadvisor_menu == 'primary') {
            $primary_menu_social_icons[] = $tripadvisor_icon;
        } else if ($social_media_tripadvisor_menu == 'secondary') {
            $secondary_menu_social_icons[] = $tripadvisor_icon;
        }

        if ($social_media_tripadvisor_footer) {
            $footer_menu_social_icons[] = $tripadvisor_icon;
        }

        if ($social_media_tripadvisor_mobile_menu) {
            $mobile_menu_social_icons[] = $tripadvisor_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $tripadvisor_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $tripadvisor_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $tripadvisor_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $tripadvisor_icon;
        }
    }
}


 
if ($twitch_url) {

    $twitch_icon = [
        'url' => $twitch_url,
        'icon' => "dp-twitch.svg",
        'title' => esc_html__('twitch', 'dipi-divi-pixel'),
    ];
   
    if ($social_icons_individual_location) {

        $social_media_twitch_menu = DIPI_Settings::get_option('social_media_twitch_menu');
        $social_media_twitch_mobile_menu = DIPI_Settings::get_option('social_media_twitch_mobile_menu');
        $social_media_twitch_footer = DIPI_Settings::get_option('social_media_twitch_footer');

         
        if ($social_media_twitch_menu == 'primary') {
            $primary_menu_social_icons[] = $twitch_icon;
        } else if ($social_media_twitch_menu == 'secondary') {
            $secondary_menu_social_icons[] = $twitch_icon;
        }

        if ($social_media_twitch_footer) {
            $footer_menu_social_icons[] = $twitch_icon;
        }

        if ($social_media_twitch_mobile_menu) {
            $mobile_menu_social_icons[] = $twitch_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $twitch_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $twitch_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $twitch_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $twitch_icon;
        }
    }
}

if ($yelp_url) {

    $yelp_icon = [
        'url' => $yelp_url,
        'icon' => "dp-yelp.svg",
        'title' => esc_html__('yelp', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_yelp_menu = DIPI_Settings::get_option('social_media_yelp_menu');
        $social_media_yelp_mobile_menu = DIPI_Settings::get_option('social_media_yelp_mobile_menu');
        $social_media_yelp_footer = DIPI_Settings::get_option('social_media_yelp_footer');

        if ($social_media_yelp_menu == 'primary') {
            $primary_menu_social_icons[] = $yelp_icon;
        } else if ($social_media_yelp_menu == 'secondary') {
            $secondary_menu_social_icons[] = $yelp_icon;
        }

        if ($social_media_yelp_footer) {
            $footer_menu_social_icons[] = $yelp_icon;
        }

        if ($social_media_yelp_mobile_menu) {
            $mobile_menu_social_icons[] = $yelp_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $yelp_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $yelp_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $yelp_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $yelp_icon;
        }
    }
}

if ($spotify_url) {

    $spotify_icon = [
        'url' => $spotify_url,
        'icon' => "dp-spotify.svg",
        'title' => esc_html__('spotify', 'dipi-divi-pixel'),
    ];

    if ($social_icons_individual_location) {

        $social_media_spotify_menu = DIPI_Settings::get_option('social_media_spotify_menu');
        $social_media_spotify_mobile_menu = DIPI_Settings::get_option('social_media_spotify_mobile_menu');
        $social_media_spotify_footer = DIPI_Settings::get_option('social_media_spotify_footer');

        if ($social_media_yelp_menu == 'primary') {
            $primary_menu_social_icons[] = $spotify_icon;
        } else if ($social_media_spotify_menu == 'secondary') {
            $secondary_menu_social_icons[] = $spotify_icon;
        }

        if ($social_media_spotify_footer) {
            $footer_menu_social_icons[] = $spotify_icon;
        }

        if ($social_media_spotify_mobile_menu) {
            $mobile_menu_social_icons[] = $spotify_icon;
        }

    } else {

        if ($social_icons_menu == 'primary') {
            $primary_menu_social_icons[] = $spotify_icon;
        } else if ($social_icons_menu == 'secondary') {
            $secondary_menu_social_icons[] = $spotify_icon;
        }

        if ($social_icons_footer) {
            $footer_menu_social_icons[] = $spotify_icon;
        }

        if ($social_icons_mobile_menu) {
            $mobile_menu_social_icons[] = $spotify_icon;
        }
    }
}
// Finally store the generated arrays in the global variable so next time this file is included, we don't need to load all the options again
$dipi_primary_menu_social_icons = $primary_menu_social_icons;
$dipi_secondary_menu_social_icons = $secondary_menu_social_icons;
$dipi_footer_menu_social_icons = $footer_menu_social_icons;
$dipi_mobile_menu_social_icons = $mobile_menu_social_icons;
$dipi_social_icons_globals_set = true;