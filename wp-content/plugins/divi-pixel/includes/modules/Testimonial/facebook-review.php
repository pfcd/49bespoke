<?php
namespace DiviPixel;

class DIPI_Facebook_Review
{
    protected function remote_request($url)
    {

        $url = esc_url_raw($url);

        if (empty($url)) {
            return false;
        }

        $request = wp_safe_remote_request($url);

        if (is_wp_error($request)) {
            dipi_err("Failed to load Facebook reviews:");
            dipi_err($request);
            return false;
        }

        $data = json_decode($request['body']);
        $code = $request['response']['code'];
        if ($code == 200) {
            return $data;
        } else {
            dipi_err("Failed to load Facebook reviews due to HTTP Status {$code}");
        }
        
        if (isset($data->error)) {
            dipi_err("Failed to load Facebook reviews because of error:");
            dipi_err($data->error);
        }

        return false;
    }

    public function run()
    {
        $page_id = DIPI_Settings::get_option('facebook_page_id');
        $token = DIPI_Settings::get_option('facebook_page_access_token');
        if(empty($page_id) || empty($token)){
            dipi_err("Facebook Page ID and/or API Token are missing");
            return;
        }

        $url = "https://graph.facebook.com/{$page_id}?access_token={$token}&fields=ratings.limit(9999)";
        $response = $this->remote_request($url);

        if (!$response) {
            return;
        }

        if (!isset($response->ratings) || !is_object($response->ratings) || 
            !isset($response->ratings->data) || empty($response->ratings->data)) {
            return;
        }

        global $wpdb;
        
        $reviews = $response->ratings->data;
        $stats = [];

        foreach ($reviews as $review) {

            $reviewer_name = $review->reviewer->name;
            $reviewer_id = $review->reviewer->id;
            $review_text = $review->review_text;
            $post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id 
                    FROM {$wpdb->postmeta} pm 
                    JOIN {$wpdb->posts} p ON p.ID = pm.post_id 
                    WHERE pm.meta_key = 'facebook_id' 
                    AND pm.meta_value = %s
                    AND p.post_status = 'publish' 
                    AND p.post_type = 'dipi_testimonial'
                    LIMIT 1", 
                $reviewer_id
            ));

            $postarr = [
                'post_title' => $reviewer_name,
                'post_content' => wp_kses_post($review_text),
                'post_type' => 'dipi_testimonial',
                'post_status' => 'publish',
                // 'post_author' => $author_id,
                'meta_input' => [
                    'profile_image' => '',
                    'testimonial_name' => esc_attr($reviewer_name),
                    'testimonial_star' => '5',
                    'testimonial_type' => 'facebook',
                    'facebook_id' => esc_attr($reviewer_id)
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
