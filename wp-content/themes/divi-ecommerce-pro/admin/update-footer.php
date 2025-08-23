<?php
/*
* Contains code copied from and/or based on Divi and WordPress
* See the license.txt file in the root directory for more information and licenses
*
*/

if ( ! get_option('wpz_footer_link') ) {
	add_action( 'init', 'wpz_update_footer_links' );
}

function wpz_update_footer_links() {

	$tbRequest = new ET_Theme_Builder_Request(
		ET_Theme_Builder_Request::TYPE_FRONT_PAGE,
		'',
		0
	);
	$tb = et_theme_builder_get_template_layouts(
		$tbRequest,
		false,
		false
	);

	if (isset($tb[ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE]['id'])) {
		$footerPost = get_post($tb[ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE]['id']);
		if ($footerPost) {
			$newFooterPostContent = str_replace(
				[
					'Designed by <a href="https://divi.space/" target="_blank" rel="noopener noreferrer">Divi Space</a> (An <a href="https://aspengrovestudios.com/" target="_blank" rel="noopener noreferrer">Aspen Grove Studios</a> Company ) | © 2015 - 2020 All Rights Reserved'
				],
				[
					'Designed by <a href="https://wpzone.co/" target="_blank" rel="noopener noreferrer">WP Zone</a> | © 2015 - 2023 All Rights Reserved'
				],
				$footerPost->post_content
			);

			if ($newFooterPostContent != $footerPost->post_content) {
				wp_update_post([
					'ID' => $footerPost->ID,
					'post_content' => $newFooterPostContent
				]);
			}
		}
	}


	add_option( 'wpz_footer_link', 1 );
}