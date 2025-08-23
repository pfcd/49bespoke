<?php
namespace DiviPixel;

class DIPI_Google_Review
{
    public function remote_request($url)
    {

        $url = esc_url_raw($url);

        if (empty($url)) {
            return false;
        }

        $request = wp_safe_remote_request($url);

        if (is_wp_error($request)) {
            dipi_err("Failed to load Google reviews:");
            dipi_err($request);
            return false;
        }

        $data = json_decode($request['body']);

        if(isset($data->error_message)){
            dipi_err("Failed to load Google reviews due to error " . $data->error_message);
            return false;
        }

        $code = $request['response']['code'];
        if ($code == 200) {
            return $data;
        } else {
            dipi_err("Failed to load Google reviews due to HTTP Status {$code}");
        }
        
        if (isset($data->error)) {
            dipi_err("Failed to load Google reviews because of error:");
            dipi_err($data->error);
        }

        return false;
    }

    public function run()
    {
        $place_id = DIPI_Settings::get_option('google_place_id');
        $api_key = DIPI_Settings::get_option('google_api_key');
        $api_lang = DIPI_Settings::get_option('google_api_lang');

        if(empty($place_id) || empty($api_key)){
            dipi_err("Google Place ID and/or API Key are missing");
            return;
        }

        $url = add_query_arg(
            [
                'placeid' => $place_id,
                'key'     => $api_key,
                'language' => $api_lang
            ],
            'https://maps.googleapis.com/maps/api/place/details/json'
        );

        $response = $this->remote_request($url);

        if (!$response) {
            return;
        }

        if (!isset($response->result) || empty($response->result) ||
            !isset($response->result->reviews) || empty($response->result->reviews)) {
            return;
        }

        $reviews = $response->result->reviews;

        foreach ($reviews as $review) {

            if (empty($review->text)) continue;

            $review_profile_photo_url = $review->profile_photo_url;
            $review_name = $review->author_name;
            $review_text = $review->text;
            $review_time = $review->time;
            $review_rating = $review->rating;

            global $wpdb;

            $post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id 
                    FROM {$wpdb->postmeta} pm 
                    JOIN {$wpdb->posts} p ON p.ID = pm.post_id 
                    WHERE meta_key = 'created_time_stamp' 
                    AND meta_value = %s
                    AND p.post_status = 'publish' 
                    AND p.post_type = 'dipi_testimonial'
                    LIMIT 1", 
                $review_time
            ));

            $postarr = [
                'post_title' => $review_name,
                'post_content' => wp_kses_post($review_text),
                'post_type' => 'dipi_testimonial',
                'post_status' => 'publish',
                // 'post_author' => $author_id,
                'meta_input' => [
                    'profile_image' => esc_attr($review_profile_photo_url),
                    'testimonial_name' => esc_attr($review_name),
                    'testimonial_star' => esc_attr($review_rating),
                    'testimonial_type' => 'google',
                    'created_time_stamp' => esc_attr($review_time)
                ]
            ];

            if($post_id && $post_id > 0) {
                $postarr["ID"] = $post_id;
                wp_update_post($postarr);
            } else {
                wp_insert_post($postarr);
            }
        }
    }

    public function getFirstPara($content) {
        $content = html_entity_decode(wp_strip_all_tags($content));
        $pos = strpos($content, '.');
        if ($pos === false) {
            return $content;
        } else {
            return substr($content, 0, $pos + 1);
        }
    }
}