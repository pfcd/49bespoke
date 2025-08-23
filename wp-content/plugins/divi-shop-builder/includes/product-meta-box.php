<?php

add_action( 'add_meta_boxes', [ 'AGS_Divi_WC_Meta_Box', 'add' ] );
add_action( 'save_post', [ 'AGS_Divi_WC_Meta_Box', 'save' ] );

class AGS_Divi_WC_Meta_Box {

	/**
	* Set up and add the meta box.
	*/
	public static function add() {
		$screens = [ 'product', 'wporg_cpt' ];
		foreach ( $screens as $screen ) {
			add_meta_box(
				'ags_divi_wc_field_section',          // Unique ID
				esc_html__( 'Custom Product Description for Divi Shop Builder', 'divi-shop-builder' ), // Box title
				[ self::class, 'html' ],   // Content callback, must be of type callable
				$screen                  // Post type
			);
		}
	}


	/**
	* Save the meta box
	*
	* @param int $post_id  The post ID.
	*/
    public static function save( $post_id ) {
        if ( isset($_POST['ags_divi_wc_description']) && current_user_can('edit_post', $post_id) ) {
			check_admin_referer('ags_divi_wc_metabox', 'ags_divi_wc_nonce');
			
            if (!empty($_POST['ags_divi_wc_description'])) {
                $data = sanitize_text_field($_POST['ags_divi_wc_description']);
                update_post_meta($post_id, 'ags_divi_wc_description', $data);
            }  else {
                delete_post_meta($post_id, 'ags_divi_wc_description');
            }
        }
    }

	/**
	* Display the meta box HTML to the user.
	*
	* @param WP_Post $post    Post object.
	*/
	public static function html( $post ) {
		wp_nonce_field('ags_divi_wc_metabox', 'ags_divi_wc_nonce', false);
		$text = get_post_meta($post->ID, 'ags_divi_wc_description' , true );
		wp_editor( htmlspecialchars($text), 'ags_divi_wc_field_id', $settings = array(
			'textarea_name'=>'ags_divi_wc_description',
			'media_buttons'=> 0 ,
			'tinymce' => 0,
			'quicktags'=> 0

		) );

	}
}
