<?php
// if ('on' === $args['show_content']) {
//     global $more;

//     if (et_pb_is_pagebuilder_used(get_the_ID())) {
//         $more = 1;
//         $content = apply_filters('the_content', $post_content);
//         $content = mb_strimwidth($content, 0, $excerpt_length, '...');
//         echo et_core_intentionally_unescaped($content, 'html');
//     } else {
//         $more = null;
//         $content = et_delete_post_first_video(get_the_content(esc_html__('read more...', 'dipi-divi-pixel')));
//         $content = apply_filters('the_content', $content);
//         $content = mb_strimwidth($content, 0, $excerpt_length, '...');
//         echo et_core_intentionally_unescaped($content, 'html');
//     }
// } else

$content = '';
if ('on' === $args['show_excerpt']) {
?>
<div class="dipi-post-text">
<?php
    global $post;

    if ( has_excerpt() ) {

		$content = apply_filters( 'the_excerpt', $post->post_excerpt );

    } else {
		$content = $post->post_content;
		if ($expert_as_raw_html !== "on") {
			$content = preg_replace( '@\[caption[^\]]*?\].*?\[\/caption]@si', '', $content );
			$content = preg_replace( '@\[et_pb_post_nav[^\]]*?\].*?\[\/et_pb_post_nav]@si', '', $content );
			$content = preg_replace( '@\[audio[^\]]*?\].*?\[\/audio]@si', '', $content );
			$content = preg_replace( '@\[embed[^\]]*?\].*?\[\/embed]@si', '', $content );
			$content = wp_strip_all_tags( $content );
			$content = et_strip_shortcodes( $content );
			$content = et_builder_strip_dynamic_content( $content );
			$content = apply_filters( 'et_truncate_post', $content, get_the_ID() );
		}
		$handle_shortcode = $expert_as_raw_html === "on" ? $handle_shortcode_with_rawhtml : $handle_shortcode_without_rawhtml;
		switch ($handle_shortcode) {
			case 'et_stripe':
				$content = et_strip_shortcodes( $content );
				break;
			case 'stripe':
				$content = strip_shortcodes($content);
				break;
			case 'non_et_stripe':
				$content = et_strip_shortcodes( $content );
				$content = strip_shortcodes($content);
			case 'render':
				$content = do_shortcode($content);
				break;
			default:
		}
    }
    if( $excerpt_length > 0 ) {

		if ( strlen( $content ) <= $excerpt_length ) {
			$echo_out = '';
		} else {
			$echo_out = '...';
		}

		if (!empty($echo_out)) {
			if ($expert_as_raw_html === "on") {
				$content = dipi_limit_length_of_html( $content, $excerpt_length) ['text'];
			} else {
				$content = rtrim( et_wp_trim_words( $content, $excerpt_length, '' ) );
				$new_words_array = (array) explode( ' ', $content );
				array_pop( $new_words_array );
				$content = implode( ' ', $new_words_array );
				$content .= $echo_out;
			}
		}

    	echo et_core_intentionally_unescaped( $content, 'html' );

    } else {
 
    	echo et_core_intentionally_unescaped( $content, 'html' );

	}
?>
</div>
<?php
}
?>
