<?php
/**
 * Plugin premium functions
 *
 * @package YITH\CatalogMode
 * @author  YITH <plugins@yithemes.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'ywctm_is_multivendor_active' ) ) {

	/**
	 * Check if YITH WooCommerce Multi Vendor is active
	 *
	 * @return  boolean
	 * @since   2.0.0
	 */
	function ywctm_is_multivendor_active() {
		return defined( 'YITH_WPV_PREMIUM' ) && YITH_WPV_PREMIUM;
	}
}

if ( ! function_exists( 'ywctm_is_multivendor_integration_active' ) ) {

	/**
	 * Check if YITH WooCommerce Multi Vendor integration is active
	 *
	 * @return  boolean
	 * @since   2.0.0
	 */
	function ywctm_is_multivendor_integration_active() {
		return get_option( 'yith_wpv_vendors_enable_catalog_mode' ) === 'yes';
	}
}

if ( ! function_exists( 'ywctm_get_vendor_id' ) ) {

	/**
	 * Get current vendor ID
	 *
	 * @param boolean $id_only ID-only checker.
	 *
	 * @return  string
	 * @since   2.0.0
	 */
	function ywctm_get_vendor_id( $id_only = false ) {
		if ( ywctm_is_multivendor_active() && ywctm_is_multivendor_integration_active() ) {

			$vendor    = yith_wcmv_get_vendor( 'current', 'user' );
			$vendor_id = $vendor->get_id();
			if ( 0 < $vendor_id && ! user_can( $vendor_id, 'manage_woocommerce' ) ) { // phpcs:ignore WordPress.WP.Capabilities.Unknown
				return ( $id_only ? $vendor_id : '_' . $vendor_id );
			}
		}

		return '';
	}
}

if ( ! function_exists( 'ywctm_get_vendor_id_frontend' ) ) {

	/**
	 * Get current vendor ID for frontend pages.
	 *
	 * @return  string
	 * @since   2.1.0
	 */
	function ywctm_get_vendor_id_frontend() {

		if ( ywctm_is_multivendor_active() && ywctm_is_multivendor_integration_active() ) {
			$vendor    = yith_wcmv_get_vendor( get_post(), 'product' );
			$vendor_id = $vendor->get_id();
			if ( 0 < $vendor_id ) {
				return $vendor_id;
			}
		}

		return '';
	}
}

if ( ! function_exists( 'ywctm_get_exclusion_fields' ) ) {

	/**
	 * Get the exclusion fiedls for Product, Category & Tag page
	 *
	 * @param array $item Product, Category or Tag excclusion data.
	 *
	 * @return  array
	 * @since   2.0.3
	 */
	function ywctm_get_exclusion_fields( $item ) {
		return array(
			array(
				'id'    => 'ywctm_enable_inquiry_form',
				'name'  => 'ywctm_enable_inquiry_form',
				'type'  => 'onoff',
				'title' => esc_html__( 'Inquiry Form', 'yith-woocommerce-catalog-mode' ),
				'value' => $item['enable_inquiry_form'],
				'desc'  => esc_html__( 'Choose whether to show or hide the inquiry form on these product pages.', 'yith-woocommerce-catalog-mode' ),
			),
			array(
				'id'    => 'ywctm_enable_atc_custom_options',
				'name'  => 'ywctm_enable_atc_custom_options',
				'type'  => 'onoff',
				'title' => esc_html__( 'Use custom options for "Add to Cart"', 'yith-woocommerce-catalog-mode' ),
				'value' => $item['enable_atc_custom_options'],
				'desc'  => esc_html__( 'Enable to override the default settings for the "Add to cart" button.', 'yith-woocommerce-catalog-mode' ),
			),
			array(
				'id'      => 'ywctm_atc_status',
				'name'    => 'ywctm_atc_status',
				'type'    => 'select',
				'class'   => 'wc-enhanced-select',
				'options' => array(
					'show' => esc_html__( 'Visible', 'yith-woocommerce-catalog-mode' ),
					'hide' => esc_html__( 'Hidden', 'yith-woocommerce-catalog-mode' ),
				),
				'title'   => esc_html__( 'Set "Add to Cart" as:', 'yith-woocommerce-catalog-mode' ),
				'value'   => $item['atc_status'],
			),
			array(
				'id'      => 'ywctm_custom_button',
				'name'    => 'ywctm_custom_button',
				'type'    => 'select',
				'class'   => 'wc-enhanced-select',
				'options' => ywctm_get_buttons_labels(),
				'default' => 'none',
				'title'   => esc_html__( 'Replace "Add to Cart" in the product page with:', 'yith-woocommerce-catalog-mode' ),
				'value'   => $item['custom_button'],
			),
			array(
				'id'      => 'ywctm_custom_button_url',
				'name'    => 'ywctm_custom_button_url',
				'type'    => 'text',
				'default' => '',
				'title'   => esc_html__( 'Override URL:', 'yith-woocommerce-catalog-mode' ),
				'value'   => isset( $item['custom_button_url'] ) ? $item['custom_button_url'] : '',
				'desc'    => esc_html__( 'Replace the button URL with a custom one. Leave empty to use the default URL.', 'yith-woocommerce-catalog-mode' ),
			),
			array(
				'id'      => 'ywctm_custom_button_loop',
				'name'    => 'ywctm_custom_button_loop',
				'type'    => 'select',
				'class'   => 'wc-enhanced-select',
				'options' => ywctm_get_buttons_labels(),
				'default' => 'none',
				'title'   => esc_html__( 'Replace "Add to Cart" in shop pages with:', 'yith-woocommerce-catalog-mode' ),
				'value'   => $item['custom_button_loop'],
			),
			array(
				'id'      => 'ywctm_custom_button_loop_url',
				'name'    => 'ywctm_custom_button_loop_url',
				'type'    => 'text',
				'default' => '',
				'title'   => esc_html__( 'Override URL:', 'yith-woocommerce-catalog-mode' ),
				'value'   => isset( $item['custom_button_loop_url'] ) ? $item['custom_button_loop_url'] : '',
				'desc'    => esc_html__( 'Replace the button URL with a custom one. Leave empty to use the default URL.', 'yith-woocommerce-catalog-mode' ),
			),
			array(
				'id'    => 'ywctm_enable_price_custom_options',
				'name'  => 'ywctm_enable_price_custom_options',
				'type'  => 'onoff',
				'title' => esc_html__( 'Use custom options for price', 'yith-woocommerce-catalog-mode' ),
				'value' => $item['enable_price_custom_options'],
				'desc'  => esc_html__( 'Enable to override the default settings for price.', 'yith-woocommerce-catalog-mode' ),
			),
			array(
				'id'      => 'ywctm_price_status',
				'name'    => 'ywctm_price_status',
				'type'    => 'select',
				'class'   => 'wc-enhanced-select',
				'options' => array(
					'show' => esc_html__( 'Visible', 'yith-woocommerce-catalog-mode' ),
					'hide' => esc_html__( 'Hidden', 'yith-woocommerce-catalog-mode' ),
				),
				'title'   => esc_html__( 'Set price as:', 'yith-woocommerce-catalog-mode' ),
				'value'   => $item['price_status'],
			),
			array(
				'id'      => 'ywctm_custom_price_text',
				'name'    => 'ywctm_custom_price_text',
				'type'    => 'select',
				'class'   => 'wc-enhanced-select',
				'options' => ywctm_get_buttons_labels(),
				'default' => 'none',
				'title'   => esc_html__( 'Replace price with:', 'yith-woocommerce-catalog-mode' ),
				'value'   => $item['custom_price_text'],
			),
			array(
				'id'      => 'ywctm_custom_price_text_url',
				'name'    => 'ywctm_custom_price_text_url',
				'type'    => 'text',
				'default' => '',
				'title'   => esc_html__( 'Override URL:', 'yith-woocommerce-catalog-mode' ),
				'value'   => isset( $item['custom_price_text_url'] ) ? $item['custom_price_text_url'] : '',
				'desc'    => esc_html__( 'Replace the button URL with a custom one. Leave empty to use the default URL.', 'yith-woocommerce-catalog-mode' ),
			),
		);
	}
}

/**
 * CUSTOM BUTTON RELATED FUNCTIONS
 */
if ( ! function_exists( 'ywctm_get_buttons_labels' ) ) {

	/**
	 * Get the list of all buttons and labels
	 *
	 * @return  array
	 * @since   2.0.0
	 */
	function ywctm_get_buttons_labels() {

		$data = get_posts(
			array(
				'post_type'        => 'ywctm-button-label',
				'suppress_filters' => false,
				'numberposts'      => -1,
			)
		);
		$list = array(
			'none' => esc_html__( 'Nothing', 'yith-woocommerce-catalog-mode' ),
		);
		if ( $data ) {
			foreach ( $data as $post ) {
				$list[ $post->ID ] = '' !== $post->post_title ? $post->post_title : esc_html__( '(no name)', 'yith-woocommerce-catalog-mode' );
			}
		}

		return $list;
	}
}

if ( ! function_exists( 'ywctm_get_active_buttons_id' ) ) {

	/**
	 * Get the IDs of all buttons and labels
	 *
	 * @return  array
	 * @since   2.0.0
	 */
	function ywctm_get_active_buttons_id() {
		$list = get_posts(
			array(
				'post_type'   => 'ywctm-button-label',
				'numberposts' => -1,
				'fields'      => 'ids',
			)
		);

		return $list;
	}
}

if ( ! function_exists( 'ywctm_get_buttons_label_name' ) ) {

	/**
	 * Get the list of all buttons and labels
	 *
	 * @param integer $id Button ID.
	 *
	 * @return  string
	 * @since   2.0.0
	 */
	function ywctm_get_buttons_label_name( $id ) {

		$post  = get_post( $id );
		$title = $post ? $post->post_title : esc_html__( 'Nothing', 'yith-woocommerce-catalog-mode' );
		$title = '' !== $title ? $title : esc_html__( '(no name)', 'yith-woocommerce-catalog-mode' );

		return '<strong>' . $title . '</strong>';
	}
}

if ( ! function_exists( 'ywctm_get_icon_class' ) ) {

	/**
	 * Get Icon Class
	 *
	 * @param string $icon Icon class.
	 *
	 * @return  string
	 * @since   2.0.0
	 */
	function ywctm_get_icon_class( $icon ) {

		$icon_data  = explode( ':', $icon );
		$icon_class = '';

		switch ( $icon_data[0] ) {
			case 'FontAwesome':
				$icon_class = 'fa fa-' . $icon_data[1];
				break;
			case 'Dashicons':
				$icon_class = 'dashicons dashicons-' . $icon_data[1];
				break;
			default:
		}

		return $icon_class;
	}
}

if ( ! function_exists( 'ywctm_get_button_label_settings' ) ) {

	/**
	 * Get settings of selected custom button
	 *
	 * @param integer $id Button ID.
	 *
	 * @return  array
	 * @since   2.0.0
	 */
	function ywctm_get_button_label_settings( $id ) {

		if ( ! $id ) {
			return array();
		}

		$settings = apply_filters(
			'ywctm_button_label_settings',
			array(
				'label_text'              => get_post_meta( $id, 'ywctm_label_text', true ),
				'icon_type'               => get_post_meta( $id, 'ywctm_icon_type', true ),
				'selected_icon'           => get_post_meta( $id, 'ywctm_selected_icon', true ),
				'selected_icon_size'      => get_post_meta( $id, 'ywctm_selected_icon_size', true ),
				'selected_icon_alignment' => get_post_meta( $id, 'ywctm_selected_icon_alignment', true ),
				'icon_color'              => get_post_meta( $id, 'ywctm_icon_color', true ),
				'custom_icon'             => get_post_meta( $id, 'ywctm_custom_icon', true ),
				'default_colors'          => get_post_meta( $id, 'ywctm_default_colors', true ),
				'hover_colors'            => get_post_meta( $id, 'ywctm_hover_colors', true ),
				'border_radius'           => get_post_meta( $id, 'ywctm_border_radius', true ),
				'border_thickness'        => get_post_meta( $id, 'ywctm_border_thickness', true ),
				'width_settings'          => get_post_meta( $id, 'ywctm_width_settings', true ),
				'margin_settings'         => get_post_meta( $id, 'ywctm_margin_settings', true ),
				'padding_settings'        => get_post_meta( $id, 'ywctm_padding_settings', true ),
				'button_url_type'         => get_post_meta( $id, 'ywctm_button_url_type', true ),
				'button_url'              => get_post_meta( $id, 'ywctm_button_url', true ),
				'hover_animation'         => get_post_meta( $id, 'ywctm_hover_animation', true ),
			),
			$id
		);

		if ( ! isset( $settings['margin_settings']['dimensions'] ) ) {
			$dimensions = $settings['margin_settings'];

			$settings['margin_settings'] = array(
				'dimensions' => $dimensions,
				'unit'       => 'px',
				'linked'     => 'no',
			);
		}

		if ( ! isset( $settings['padding_settings']['dimensions'] ) ) {
			$dimensions = $settings['padding_settings'];

			$settings['padding_settings'] = array(
				'dimensions' => $dimensions,
				'unit'       => 'px',
				'linked'     => 'no',
			);
		}

		if ( empty( $settings['border_radius'] ) ) {
			$old_radius = get_post_meta( $id, 'ywctm_border_style', true )['radius'];

			$settings['border_radius'] = array(
				'dimensions' => array(
					'top-left'     => $old_radius,
					'top-right'    => $old_radius,
					'bottom-right' => $old_radius,
					'bottom-left'  => $old_radius,
				),
				'unit'       => 'px',
				'linked'     => 'no',
			);
		}

		if ( empty( $settings['border_thickness'] ) ) {
			$old_thickness = get_post_meta( $id, 'ywctm_border_style', true )['thickness'];

			$settings['border_thickness'] = array(
				'dimensions' => array(
					'top'    => $old_thickness,
					'right'  => $old_thickness,
					'bottom' => $old_thickness,
					'left'   => $old_thickness,
				),
				'unit'       => 'px',
				'linked'     => 'no',
			);
		}

		if ( empty( $settings['default_colors'] ) ) {
			$old_default_text       = get_post_meta( $id, 'ywctm_text_color', true )['default'];
			$old_default_background = get_post_meta( $id, 'ywctm_background_color', true )['default'];
			$old_default_border     = get_post_meta( $id, 'ywctm_border_color', true )['default'];

			$settings['default_colors'] = array(
				'background' => $old_default_background,
				'text'       => $old_default_text,
				'borders'    => $old_default_border,
			);
		}

		if ( empty( $settings['hover_colors'] ) ) {
			$old_hover_text       = get_post_meta( $id, 'ywctm_text_color', true )['hover'];
			$old_hover_background = get_post_meta( $id, 'ywctm_background_color', true )['hover'];
			$old_hover_border     = get_post_meta( $id, 'ywctm_border_color', true )['hover'];

			$settings['hover_colors'] = array(
				'background' => $old_hover_background,
				'text'       => $old_hover_text,
				'borders'    => $old_hover_border,
			);
		}

		if ( empty( $settings['hover_animation'] ) ) {
			$settings['hover_animation'] = 'none';
		}

		return $settings;
	}
}

if ( ! function_exists( 'ywctm_check_hover_effect' ) ) {

	/**
	 * Check if the button has a special hover effect and return alternative CSS value
	 *
	 * @param string $effect    The effect ID.
	 * @param string $value     The normal value.
	 * @param string $alt_value The alternative value.
	 *
	 * @return  string
	 * @since   2.1.0
	 */
	function ywctm_check_hover_effect( $effect, $value, $alt_value ) {

		$special_hover_effects = array(
			'slide-top',
			'slide-left',
		);

		return in_array( $effect, $special_hover_effects, true ) ? $alt_value : $value;
	}
}

if ( ! function_exists( 'ywctm_set_custom_button_css' ) ) {

	/**
	 * Create CSS rules for each custom button
	 *
	 * @param string $button_id       The ID of the button.
	 * @param array  $button_settings The button settings array.
	 *
	 * @return  string
	 * @since   2.1.0
	 */
	function ywctm_set_custom_button_css( $button_id, $button_settings ) {

		$hover_effect        = $button_settings['hover_animation'];
		$color               = $button_settings['default_colors']['text'];
		$base_bg_color       = $button_settings['default_colors']['background'];
		$base_hover_bg_color = $button_settings['hover_colors']['background'];
		$bg_color            = ywctm_check_hover_effect( $hover_effect, $base_bg_color, 'none' );
		$border_color        = isset( $button_settings['default_colors']['borders'] ) ? $button_settings['default_colors']['borders'] : '#247390';
		$border_radius       = ywctm_sanitize_dimension_field( $button_settings['border_radius']['dimensions'], array( 'top-left', 'top-right', 'bottom-right', 'bottom-left' ), 'px' );
		$border_width        = ywctm_sanitize_dimension_field( $button_settings['border_thickness']['dimensions'], array( 'top', 'right', 'bottom', 'left' ), 'px' );
		$margin              = ywctm_sanitize_dimension_field( $button_settings['margin_settings']['dimensions'], array( 'top', 'right', 'bottom', 'left' ), 'px' );
		$padding             = ywctm_sanitize_dimension_field( $button_settings['padding_settings']['dimensions'], array( 'top', 'right', 'bottom', 'left' ), 'px' );
		$width               = ywctm_sanitize_width_field( $button_settings['width_settings'] );
		$hover_color         = $button_settings['hover_colors']['text'];
		$hover_bg_color      = ywctm_check_hover_effect( $hover_effect, $base_hover_bg_color, 'none' );
		$hover_border_color  = isset( $button_settings['hover_colors']['borders'] ) ? $button_settings['hover_colors']['borders'] : '#247390';

		$css = "
		.ywctm-button-$button_id .ywctm-custom-button {
			color:$color;
			background-color:$bg_color;
			border-style:solid;
			border-color:$border_color;
			border-radius:$border_radius;
			border-width:$border_width;
			margin:$margin;
			padding:$padding;
			max-width:$width;
		}

		.ywctm-button-$button_id .ywctm-custom-button:hover {
			color:$hover_color;
			background-color:$hover_bg_color;
			border-color:$hover_border_color;
		}
		";

		if ( 'icon' === $button_settings['icon_type'] ) {
			$icon_size        = $button_settings['selected_icon_size'] . 'px';
			$icon_color       = $button_settings['icon_color']['default'];
			$hover_icon_color = $button_settings['icon_color']['hover'];
			$icon_align       = $button_settings['selected_icon_alignment'];

			$css .= "
				.ywctm-button-$button_id .ywctm-custom-button .ywctm-icon-form {
					font-size:$icon_size;
					color:$icon_color;
					align-self:$icon_align;
				}

				.ywctm-button-$button_id .ywctm-custom-button:hover .ywctm-icon-form {
					color:$hover_icon_color;
				}
			";
		} elseif ( 'custom' === $button_settings['icon_type'] ) {
			$icon_align = $button_settings['selected_icon_alignment'];

			$css .= "
				.ywctm-button-$button_id .ywctm-custom-button .ywctm-icon-form {
					align-self:$icon_align;
				}
			";
		}

		switch ( $hover_effect ) {
			case 'slide-top':
			case 'slide-left':
				$css .= "
				.ywctm-button-$button_id .ywctm-custom-button.ywctm-hover-effect.ywctm-effect-slide-top:after,
				.ywctm-button-$button_id .ywctm-custom-button.ywctm-hover-effect.ywctm-effect-slide-left:after {
					background-color:$base_hover_bg_color;
				}
				.ywctm-button-$button_id .ywctm-custom-button.ywctm-hover-effect.ywctm-effect-slide-top:before,
				.ywctm-button-$button_id .ywctm-custom-button.ywctm-hover-effect.ywctm-effect-slide-left:before {
					background-color:$base_bg_color;
				}
				";
				break;

			case 'move-hover-color':
				$css .= "
				.ywctm-button-$button_id .ywctm-custom-button.ywctm-hover-effect.ywctm-effect-move-hover-color:before {
					background-color:$base_hover_bg_color;
					border-radius:$border_radius;
				}
				";
				break;
		}

		return $css;
	}
}

if ( ! function_exists( 'ywctm_sanitize_dimension_field' ) ) {

	/**
	 * Sanitize dimension fields for possible missing values
	 *
	 * @param array  $option          The available option array.
	 * @param array  $required_values The needed values array.
	 * @param string $unit            The dimension unit.
	 *
	 * @return  string
	 * @since   2.1.0
	 */
	function ywctm_sanitize_dimension_field( $option, $required_values, $unit ) {
		$dimensions = array();
		foreach ( $required_values as $required_value ) {
			if ( ! isset( $option[ $required_value ] ) || '' === $option[ $required_value ] || '0' === $option[ $required_value ] ) {
				$dimensions[] = 0;
			} else {
				$dimensions[] = $option[ $required_value ] . $unit;
			}
		}

		return implode( ' ', $dimensions );
	}
}

if ( ! function_exists( 'ywctm_sanitize_width_field' ) ) {

	/**
	 * Sanitize width field for possible missing values
	 *
	 * @param array $option The option array.
	 *
	 * @return  string
	 * @since   2.1.0
	 */
	function ywctm_sanitize_width_field( $option ) {

		$width = 'max-content';

		if ( isset( $option['width'] ) && '' !== $option['width'] ) {
			$width = $option['width'] . ( '%' !== $option['unit'] ? 'px' : '%' );
		}

		return $width;
	}
}
if ( ! function_exists( 'ywctm_embedded_font_list' ) ) {

	/**
	 * Get list of embedded fonts
	 *
	 * @return array
	 * @since  2.9.0
	 */
	function ywctm_embedded_font_list() {
		return array(
			'dancing-script'  => array(
				'name'     => 'Dancing Script',
				'fallback' => 'handwriting',
			),
			'gochi-hand'      => array(
				'name'     => 'Gochi Hand',
				'fallback' => 'handwriting',
			),
			'lora'            => array(
				'name'     => 'Lora',
				'fallback' => 'serif',
			),
			'montserrat'      => array(
				'name'     => 'Montserrat',
				'fallback' => 'sans-serif',
			),
			'oswald'          => array(
				'name'     => 'Oswald',
				'fallback' => 'sans-serif',
			),
			'roboto'          => array(
				'name'     => 'Roboto',
				'fallback' => 'sans-serif',
			),
			'slabo-27px'      => array(
				'name'     => 'Slabo 27px',
				'fallback' => 'serif',
			),
			'source-sans-pro' => array(
				'name'     => 'Source Sans pro',
				'fallback' => 'sans-serif',
			),
		);
	}
}

if ( ! function_exists( 'ywctm_enabled_google_fonts' ) ) {

	/**
	 * Get enabled Google Fonts
	 *
	 * @return  array
	 * @since   2.0.0
	 */
	function ywctm_enabled_google_fonts() {

		$google_fonts = array();

		/**
		 * APPLY_FILTERS: ywctm_google_fonts
		 *
		 * Add or remove supported Google Fonts
		 * Sample pattern to use:
		 * array(
		 * 'Roboto' => '\'Roboto\',sans-serif',
		 * );.
		 *
		 * @param array $google_fonts Supported fonts.
		 *
		 * @return array
		 */
		return apply_filters( 'ywctm_google_fonts', $google_fonts );
	}
}

if ( ! function_exists( 'ywctm_parse_icons' ) ) {

	/**
	 * Replaces the placeholders with icons HTML
	 *
	 * @param string $text Icon placeholder.
	 *
	 * @return  string
	 * @since   2.0.0
	 */
	function ywctm_parse_icons( $text ) {
		$pattern     = '/{{(((\w+-?)*) ((\w+\d*-?)*))}}/m';
		$replacement = '<i class="$1"></i>';

		return preg_replace( $pattern, $replacement, $text );
	}
}

if ( ! function_exists( 'ywctm_get_custom_button_url_override' ) ) {

	/**
	 * Get the custom URL override
	 *
	 * @param WC_Product $product The Product object.
	 * @param string     $type    Button type.
	 * @param boolean    $is_loop Loop checker.
	 *
	 * @return  string
	 * @since   2.0.3
	 */
	function ywctm_get_custom_button_url_override( $product, $type, $is_loop = false ) {

		if ( ! $is_loop && 'atc' === $type ) {
			$option = 'custom_button_url';
		} elseif ( $is_loop && 'atc' === $type ) {
			$option = 'custom_button_loop_url';
		} else {
			$option = 'custom_price_text_url';
		}

		if ( ! $product instanceof WC_Product ) {
			return '';
		}

		$product_exclusion = apply_filters( 'ywctm_get_vendor_postmeta', $product->get_meta( '_ywctm_exclusion_settings' ), $product->get_id(), '_ywctm_exclusion_settings' );

		if ( $product_exclusion ) {
			if ( 'yes' === $product_exclusion[ 'enable_' . $type . '_custom_options' ] ) {
				return ! empty( $product_exclusion[ $option ] ) ? $product_exclusion[ $option ] : '';
			}
		}

		$product_cats = wp_get_object_terms( $product->get_id(), 'product_cat', array( 'fields' => 'ids' ) );
		foreach ( $product_cats as $cat_id ) {
			$product_exclusion = apply_filters( 'ywctm_get_vendor_termmeta', get_term_meta( $cat_id, '_ywctm_exclusion_settings', true ), $product->get_id(), $cat_id, '_ywctm_exclusion_settings' );
			if ( $product_exclusion ) {
				if ( 'yes' === $product_exclusion[ 'enable_' . $type . '_custom_options' ] ) {
					return ! empty( $product_exclusion[ $option ] ) ? $product_exclusion[ $option ] : '';
				}
			}
		}

		$product_tags = wp_get_object_terms( $product->get_id(), 'product_tag', array( 'fields' => 'ids' ) );
		foreach ( $product_tags as $tag_id ) {
			$product_exclusion = apply_filters( 'ywctm_get_vendor_termmeta', get_term_meta( $tag_id, '_ywctm_exclusion_settings', true ), $product->get_id(), $tag_id, '_ywctm_exclusion_settings' );
			if ( $product_exclusion ) {
				if ( 'yes' === $product_exclusion[ 'enable_' . $type . '_custom_options' ] ) {
					return ! empty( $product_exclusion[ $option ] ) ? $product_exclusion[ $option ] : '';
				}
			}
		}

		return '';
	}
}

if ( ! function_exists( 'ywctm_buttons_id_with_custom_url' ) ) {

	/**
	 * Get the IDs of all buttons and labels with custom URL
	 *
	 * @return  array
	 * @since   2.0.3
	 */
	function ywctm_buttons_id_with_custom_url() {
		$list = get_posts(
			array(
				'post_type'   => 'ywctm-button-label',
				'numberposts' => -1,
				'fields'      => 'ids',
				'meta_key'    => 'ywctm_button_url_type', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'  => 'custom', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			)
		);

		return $list;
	}
}

if ( ! function_exists( 'ywctm_get_theme_font' ) ) {

	/**
	 * Get main theme font
	 *
	 * @return  array|boolean
	 * @since   2.1.0
	 */
	function ywctm_get_theme_font() {

		$theme_name = strtolower( ywctm_get_theme_name() );
		$theme_font = false;

		switch ( $theme_name ) {
			case 'yith proteo':
			case 'yith-proteo':
				$font       = json_decode( get_theme_mod( 'yith_proteo_body_font', '{"font":"Montserrat","regularweight":"regular","category":"sans-serif"}' ), true );
				$theme_font = array(
					$font['font'] => $font['font'] . ',' . $font['category'],
				);
				break;
		}

		return $theme_font;
	}
}

/**
 * EXCLUSION TABLE RELATED FUNCTIONS
 */
if ( ! function_exists( 'ywctm_add_to_cart_column' ) ) {

	/**
	 * Print the add to cart column in the exclusion table
	 *
	 * @param array $item Exclusion item.
	 *
	 * @return  string
	 * @since   2.0.0
	 */
	function ywctm_add_to_cart_column( $item ) {

		$exclusion = maybe_unserialize( $item['exclusion'] );
		$replace   = '';

		if ( 'no' === $exclusion['enable_atc_custom_options'] ) {
			$atc_global = get_option( 'ywctm_hide_add_to_cart_settings' . ywctm_get_vendor_id() );
			$status     = 'hide' === $atc_global['action'] ? __( 'Hidden', 'yith-woocommerce-catalog-mode' ) : __( 'Visible', 'yith-woocommerce-catalog-mode' );
			$status     = sprintf( '%s%s%s', '<b>', $status, '</b>' );
		} else {
			$status = 'hide' === $exclusion['atc_status'] ? __( 'Hidden', 'yith-woocommerce-catalog-mode' ) : __( 'Visible', 'yith-woocommerce-catalog-mode' );
			$status = sprintf( '%s%s%s', '<b>', $status, '</b>' );

			if ( 'hide' === $exclusion['atc_status'] && ( 'none' !== $exclusion['custom_button'] || 'none' !== $exclusion['custom_button_loop'] ) ) {
				$replace .= '&nbsp;' . _x( 'and replaced with:', 'Part of a sentence like: "Hidden and replaced with:"', 'yith-woocommerce-catalog-mode' );
			}

			if ( 'none' !== $exclusion['custom_button'] && 'hide' === $exclusion['atc_status'] ) {
				$edit_button_url = sprintf( '<a href="%1$s">%2$s</a>', get_edit_post_link( $exclusion['custom_button'] ), ywctm_get_buttons_label_name( $exclusion['custom_button'] ) );

				// translators: %s is the name of the button to replace the add to cart button.
				$replace .= ' <br />' . sprintf( esc_html__( '%s in product page', 'yith-woocommerce-catalog-mode' ), $edit_button_url );
			}

			if ( 'none' !== $exclusion['custom_button_loop'] && 'hide' === $exclusion['atc_status'] ) {
				$edit_button_url = sprintf( '<a href="%1$s">%2$s</a>', get_edit_post_link( $exclusion['custom_button_loop'] ), ywctm_get_buttons_label_name( $exclusion['custom_button_loop'] ) );

				// translators: %s is the name of the button to replace the add to cart button.
				$replace .= ' <br />' . sprintf( esc_html__( '%s in shop page', 'yith-woocommerce-catalog-mode' ), $edit_button_url );
			}
		}

		return sprintf( '%s%s', $status, $replace );
	}
}

if ( ! function_exists( 'ywctm_price_column' ) ) {

	/**
	 * Print the price column in the exclusion table
	 *
	 * @param array $item Exclusion item.
	 *
	 * @return  string
	 * @since   2.0.0
	 */
	function ywctm_price_column( $item ) {

		$exclusion = maybe_unserialize( $item['exclusion'] );
		$replace   = '';

		if ( 'no' === $exclusion['enable_price_custom_options'] ) {
			$price_global = get_option( 'ywctm_hide_price_settings' . ywctm_get_vendor_id() );
			$status       = 'hide' === $price_global['action'] ? __( 'Hidden', 'yith-woocommerce-catalog-mode' ) : __( 'Visible', 'yith-woocommerce-catalog-mode' );
			$status       = sprintf( '%s%s%s', '<b>', $status, '</b>' );
		} else {
			$status = 'hide' === $exclusion['price_status'] ? __( 'Hidden', 'yith-woocommerce-catalog-mode' ) : __( 'Visible', 'yith-woocommerce-catalog-mode' );
			$status = sprintf( '%s%s%s', '<b>', $status, '</b>' );

			if ( 'none' !== $exclusion['custom_price_text'] && 'hide' === $exclusion['price_status'] ) {
				$edit_button_url = sprintf( '<a href="%1$s">%2$s</a>', get_edit_post_link( $exclusion['custom_price_text'] ), ywctm_get_buttons_label_name( $exclusion['custom_price_text'] ) );

				// translators: %s is the name of the button to replace the price.
				$replace = ' <br />' . sprintf( esc_html__( 'Replaced with %s', 'yith-woocommerce-catalog-mode' ), $edit_button_url );
			}
		}

		return sprintf( '%s%s', $status, $replace );
	}
}

if ( ! function_exists( 'ywctm_item_type_column' ) ) {

	/**
	 * Print the item type column in the exclusion table
	 *
	 * @param string $item_type Item type name.
	 *
	 * @return  string
	 * @since   2.0.0
	 */
	function ywctm_item_type_column( $item_type ) {
		$item_types = array(
			'product'  => esc_html__( 'Product', 'yith-woocommerce-catalog-mode' ),
			'category' => esc_html__( 'Category', 'yith-woocommerce-catalog-mode' ),
			'tag'      => esc_html__( 'Tag', 'yith-woocommerce-catalog-mode' ),
		);

		return isset( $item_types[ $item_type ] ) ? $item_types[ $item_type ] : '';
	}
}

if ( ! function_exists( 'ywctm_item_name_column' ) ) {

	/**
	 * Print item name with action links in the exclusion table
	 *
	 * @param array $item  Exclusion item.
	 *
	 * @return  string
	 * @since   2.0.0
	 */
	function ywctm_item_name_column( $item ) {
		$getter     = $_GET; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$query_args = array(
			'page' => $getter['page'],
			'tab'  => $getter['tab'],
			'id'   => $item['ID'],
		);

		if ( isset( $getter['sub_tab'] ) ) {
			$query_args['sub_tab'] = $getter['sub_tab'];
		}

		if ( isset( $getter['paged'] ) ) {
			$query_args['return_page'] = $getter['paged'];
		}

		$section = isset( $getter['sub_tab'] ) ? str_replace( 'exclusions-', '', $getter['sub_tab'] ) : 'items';

		if ( 'items' === $section ) {
			$query_args['item_type'] = $item['item_type'];
		}

		$edit_url = esc_url( add_query_arg( array_merge( $query_args, array( 'action' => 'edit' ) ), admin_url( 'admin.php' ) ) );

		if ( 'items' === $section ) {
			$link = sprintf( '<strong class="edit-exclusion" data-item_id="' . esc_attr( $item['ID'] ) . '"><a class="row-title" href="%s">#%d %s</a></strong>', $edit_url, $item['ID'], $item['name'] );
		} else {
			$link = sprintf( '<span class="row-title">#%d %s</span>', $item['ID'], $item['name'] );
		}

		return $link;
	}
}

if ( ! function_exists( 'ywctm_inquiry_form_column' ) ) {

	/**
	 * Print the inquiry form column in the exclusion table
	 *
	 * @param array $item Exclusion item.
	 *
	 * @return  void
	 * @since   2.0.0
	 */
	function ywctm_inquiry_form_column( $item ) {

		$exclusion = maybe_unserialize( $item['exclusion'] );

		$args = array(
			'id'    => 'enable_inquiry_form_' . $item['item_type'] . '_' . $item['ID'],
			'name'  => 'enable_inquiry_form',
			'type'  => 'onoff',
			'value' => $exclusion['enable_inquiry_form'],
			'data'  =>
				array(
					'item-id' => $item['ID'],
					'section' => $item['item_type'],
				),
		);

		yith_plugin_fw_get_field( $args, true );
	}
}

if ( ! function_exists( 'ywctm_enable_inquiry_form' ) ) {

	/**
	 * Enable/disable inquiry from exclusion list overview
	 *
	 * @return  void
	 * @since   2.0.0
	 */
	function ywctm_enable_inquiry_form() {

		try {

			if ( ! isset( $_POST['_wpnonce'] ) || ! isset( $_POST['item_id'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'bulk-items' ) ) {
				return;
			}

			$posted      = $_POST;
			$option_name = ( '' !== $posted['vendor_id'] ? '_ywctm_exclusion_settings_' . $posted['vendor_id'] : '_ywctm_exclusion_settings' );

			switch ( $posted['section'] ) {

				case 'category':
				case 'tag':
					$exclusion_data                        = get_term_meta( $posted['item_id'], $option_name, true );
					$exclusion_data['enable_inquiry_form'] = $posted['enabled'];

					update_term_meta( $posted['item_id'], $option_name, $exclusion_data );

					break;
				default:
					$product                               = wc_get_product( $posted['item_id'] );
					$exclusion_data                        = $product->get_meta( $option_name );
					$exclusion_data['enable_inquiry_form'] = $posted['enabled'];
					$product->update_meta_data( $option_name, $exclusion_data );
					$product->save();
			}

			wp_send_json( array( 'success' => true ) );

		} catch ( Exception $e ) {

			wp_send_json(
				array(
					'success' => false,
					'error'   => $e->getMessage(),
				)
			);

		}
	}

	add_action( 'wp_ajax_ywctm_enable_inquiry_form', 'ywctm_enable_inquiry_form' );

}

if ( ! function_exists( 'ywctm_set_table_columns' ) ) {

	/**
	 * Prepare columns for exclusion table
	 *
	 * @return  array
	 * @since   2.0.0
	 */
	function ywctm_set_table_columns() {

		$columns = array(
			'cb'          => '<input type="checkbox" />',
			'item_name'   => esc_html__( 'Item Name', 'yith-woocommerce-catalog-mode' ),
			'add_to_cart' => esc_html__( 'Add to cart', 'yith-woocommerce-catalog-mode' ),
			'show_price'  => esc_html__( 'Price', 'yith-woocommerce-catalog-mode' ),
		);

		$enabled = get_option( 'ywctm_inquiry_form_enabled' . ywctm_get_vendor_id(), 'hidden' );

		if ( 'hidden' !== $enabled && ywctm_exists_inquiry_forms() ) {
			$columns['inquiry_form'] = esc_html__( 'Inquiry form', 'yith-woocommerce-catalog-mode' );
		}

		$columns['actions'] = '';

		return $columns;
	}
}

/**
 * INQUIRY FORM RELATED FUNCTIONS
 */
if ( ! function_exists( 'ywctm_exists_inquiry_forms' ) ) {

	/**
	 * Check if at least a form plugin is active
	 *
	 * @return  boolean
	 * @since   2.0.0
	 */
	function ywctm_exists_inquiry_forms() {

		$form_plugins = ywctm_get_active_form_plugins();

		return ( ! empty( $form_plugins ) );
	}
}

if ( ! function_exists( 'ywctm_get_active_form_plugins' ) ) {

	/**
	 * Get active form plugins
	 *
	 * @return  array
	 * @since   2.0.0
	 */
	function ywctm_get_active_form_plugins() {

		$active_plugins = array(
			'default' => esc_html__( 'Default', 'yith-woocommerce-catalog-mode' ),
		);

		if ( ywctm_contact_form_7_active() ) {
			$active_plugins['contact-form-7'] = 'Contact Form 7';
		}

		if ( ywctm_formidable_forms_form_active() ) {
			$active_plugins['formidable-forms'] = 'Formidable Forms';
		}

		if ( ywctm_gravity_forms_active() ) {
			$active_plugins['gravity-forms'] = 'Gravity Forms';
		}

		if ( ywctm_ninja_forms_active() ) {
			$active_plugins['ninja-forms'] = 'Ninja Forms';
		}

		if ( ywctm_wpforms_active() ) {
			$active_plugins['wpforms'] = 'WPForms';
		}

		return $active_plugins;
	}
}

if ( ! function_exists( 'ywctm_get_forms_list' ) ) {

	/**
	 * Get list of forms
	 *
	 * @param string $form_plugin Form plugin slug.
	 *
	 * @return  array
	 * @since   2.0.0
	 */
	function ywctm_get_forms_list( $form_plugin ) {

		$forms = '';

		switch ( $form_plugin ) {
			case 'contact-form-7':
				$forms = ywctm_contact_form_7_get_contact_forms();
				break;
			case 'ninja-forms':
				$forms = ywctm_ninja_forms_get_contact_forms();
				break;
			case 'formidable-forms':
				$forms = ywctm_formidable_forms_get_contact_forms();
				break;
			case 'gravity-forms':
				$forms = ywctm_gravity_forms_get_contact_forms();
				break;
			case 'wpforms':
				$forms = ywctm_wpforms_get_contact_forms();
				break;
		}

		if ( ! is_array( $forms ) ) {

			if ( 'inactive' === $forms ) {
				$form_list = array( 'none' => esc_html__( 'Plugin not activated or not installed', 'yith-woocommerce-catalog-mode' ) );
			} else {
				$form_list = array( 'none' => esc_html__( 'No contact form found', 'yith-woocommerce-catalog-mode' ) );
			}
		} else {
			$form_list = $forms;
		}

		return $form_list;
	}
}

if ( ! function_exists( 'ywctm_get_localized_form' ) ) {

	/**
	 * Get form id for current language
	 *
	 * @param string  $form_type  Form type.
	 * @param integer $product_id The Product ID.
	 *
	 * @return  integer
	 * @since   2.0.0
	 */
	function ywctm_get_localized_form( $form_type, $product_id ) {

		if ( ywctm_is_wpml_active() ) {
			$option_name  = 'ywctm_inquiry_' . str_replace( '-', '_', $form_type ) . '_id_wpml';
			$options      = apply_filters( 'ywctm_get_vendor_option', get_option( $option_name, '' ), $product_id, $option_name );
			$default_form = isset( $options[ wpml_get_default_language() ] ) ? $options[ wpml_get_default_language() ] : '';
			$form_id      = isset( $options[ wpml_get_current_language() ] ) ? $options[ wpml_get_current_language() ] : $default_form;

		} else {
			$option_name = 'ywctm_inquiry_' . str_replace( '-', '_', $form_type ) . '_id';
			$form_id     = apply_filters( 'ywctm_get_vendor_option', get_option( $option_name, '' ), $product_id, $option_name );
		}

		return $form_id;
	}
}

if ( ! function_exists( 'ywctm_get_formatted_product_name' ) ) {

	/**
	 * Get formatted product name
	 *
	 * @param integer $product_id The product ID.
	 * @param array   $params     The product params.
	 *
	 * @return  string
	 * @since   2.0.15
	 */
	function ywctm_get_formatted_product_name( $product_id, $params ) {

		$product         = wc_get_product( $product_id );
		$variations_data = '';

		if ( $product->get_sku() ) {
			$identifier = $product->get_sku();
		} else {
			$identifier = '#' . $product->get_id();
		}

		if ( ! empty( $params ) ) {
			$variations = array();
			foreach ( $params as $param ) {
				$attribute                   = explode( '=', $param );
				$variations[ $attribute[0] ] = $attribute[1];
			}

			$variations_data = ' - ' . wc_get_formatted_variation( $variations, true );
		}

		return sprintf( '%2$s%3$s (%1$s)', $identifier, $product->get_name(), $variations_data );
	}
}

if ( ! function_exists( 'ywctm_get_product_url' ) ) {

	/**
	 * Get formatted product URL
	 *
	 * @param integer $product_id The product ID.
	 * @param array   $params     The product params.
	 *
	 * @return  string
	 * @since   2.1.0
	 */
	function ywctm_get_product_url( $product_id, $params ) {

		$product_url = wc_get_product( $product_id )->get_permalink();
		$separator   = '';
		$querystring = '';

		if ( ! empty( $params ) ) {
			$querystring = implode( '&', $params );
			$separator   = false !== strpos( $product_url, '?' ) ? '&' : '?';
		}

		return $product_url . $separator . $querystring;
	}
}

if ( ! function_exists( 'ywctm_get_product_link' ) ) {

	/**
	 * Get product link
	 *
	 * @param integer $product_id The product ID.
	 * @param array   $params     The product params.
	 * @param boolean $html       Check if content should be HTML rendered.
	 *
	 * @return  string
	 * @since   2.1.0
	 */
	function ywctm_get_product_link( $product_id, $params, $html = true ) {

		$product_link = ywctm_get_product_url( $product_id, $params );
		$product_name = ywctm_get_formatted_product_name( $product_id, $params );

		if ( $html ) {
			return sprintf( '<a href="%s" target="_blank">%s</a>', $product_link, $product_name );
		} else {
			return sprintf( '%s - %s', $product_name, $product_link );
		}
	}
}

/**
 * GEOLOCATION RELATED FUNCTIONS
 */
if ( ! function_exists( 'ywctm_get_ip_address' ) ) {

	/**
	 * Get user IP address
	 *
	 * @return  string
	 * @since   1.3.4
	 */
	function ywctm_get_ip_address() {

		$ip_addr = false;

		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip_addr = sanitize_text_field( wp_unslash( $_SERVER['HTTP_CLIENT_IP'] ) );
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip_addr = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
		} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$ip_addr = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
		}

		if ( false === $ip_addr ) {
			$ip_addr = '0.0.0.0';

			return $ip_addr;
		}

		if ( strpos( $ip_addr, ',' ) !== false ) {
			$x       = explode( ',', $ip_addr );
			$ip_addr = trim( end( $x ) );
		}

		if ( ! filter_var( $ip_addr, FILTER_VALIDATE_IP ) ) {
			$ip_addr = '0.0.0.0';
		}

		return $ip_addr;
	}
}

/**
 * PHP < 7.3 COMPATIBILITY FIX
 */
if ( ! function_exists( 'array_key_first' ) ) {

	/**
	 * Gets the first key of an array
	 *
	 * Get the first key of the given array without affecting the internal array pointer.
	 *
	 * @link  https://secure.php.net/array_key_first
	 *
	 * @param array $arr An array.
	 *
	 * @return string|int|null Returns the first key of array if the array is not empty; NULL otherwise.
	 * @since 7.3
	 */
	function array_key_first( $arr ) {
		foreach ( $arr as $key => $unused ) {
			return $key;
		}

		return null;
	}
}

/**
 * PLUGIN INSTALLATION
 */
if ( ! function_exists( 'ywctm_create_sample_buttons' ) ) {

	/**
	 * Run plugin upgrade to version 2.0.0
	 *
	 * @return  void
	 * @since   2.0.0
	 */
	function ywctm_create_sample_buttons() {
		if ( '' !== (string) get_option( 'ywctm_update_version' ) ) {
			return;
		}
		$sample_buttons = array(
			array(
				'name'    => esc_html__( 'Sample Button 1', 'yith-woocommerce-catalog-mode' ),
				'options' => array(
					'label_text'              => '<div style="text-align: center;"><strong><span style="font-family: inherit; font-size: 14px;">' . esc_html__( 'ASK INFO', 'yith-woocommerce-catalog-mode' ) . '</span></strong></div>',
					'default_colors'          => array(
						'text'       => '#ffffff',
						'background' => '#e09004',
						'border'     => '#e09004',
					),
					'hover_colors'            => array(
						'text'       => '#ffffff',
						'background' => '#b97600',
						'border'     => '#b97600',
					),
					'border_thickness'        => array(
						'dimensions' => array(
							'top'    => 1,
							'right'  => 1,
							'bottom' => 1,
							'left'   => 1,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
					'border_radius'           => array(
						'dimensions' => array(
							'top'    => 50,
							'right'  => 50,
							'bottom' => 50,
							'left'   => 50,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
					'icon_type'               => 'none',
					'selected_icon'           => '',
					'selected_icon_size'      => '',
					'selected_icon_alignment' => 'flex-start',
					'custom_icon'             => '',
					'width_settings'          => array(
						'width' => 200,
						'unit'  => 'px',
					),
					'margin_settings'         => array(
						'dimensions' => array(
							'top'    => 0,
							'right'  => 0,
							'bottom' => 0,
							'left'   => 0,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
					'padding_settings'        => array(
						'dimensions' => array(
							'top'    => 5,
							'right'  => 10,
							'bottom' => 5,
							'left'   => 10,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
				),
			),
			array(
				'name'    => esc_html__( 'Sample Button 2', 'yith-woocommerce-catalog-mode' ),
				'options' => array(
					'label_text'              => '<div style="text-align: center;"><strong><span style="font-family: inherit; font-size: 14px;">' . esc_html__( 'SEND INQUIRY', 'yith-woocommerce-catalog-mode' ) . '</span></strong></div>',
					'default_colors'          => array(
						'text'       => '#ffffff',
						'background' => '#36809a',
						'border'     => '#215d72',
					),
					'hover_colors'            => array(
						'text'       => '#ffffff',
						'background' => '#36809a',
						'border'     => '#215d72',
					),
					'button_url'              => '',
					'border_thickness'        => array(
						'dimensions' => array(
							'top'    => 1,
							'right'  => 1,
							'bottom' => 1,
							'left'   => 1,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
					'border_radius'           => array(
						'dimensions' => array(
							'top'    => 50,
							'right'  => 50,
							'bottom' => 50,
							'left'   => 50,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
					'icon_type'               => 'none',
					'selected_icon'           => '',
					'selected_icon_size'      => '',
					'selected_icon_alignment' => 'flex-start',
					'custom_icon'             => '',
					'width_settings'          => array(
						'width' => 200,
						'unit'  => 'px',
					),
					'margin_settings'         => array(
						'dimensions' => array(
							'top'    => 0,
							'right'  => 0,
							'bottom' => 0,
							'left'   => 0,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
					'padding_settings'        => array(
						'dimensions' => array(
							'top'    => 5,
							'right'  => 10,
							'bottom' => 5,
							'left'   => 10,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
				),
			),
			array(
				'name'    => esc_html__( 'Sample Button 3', 'yith-woocommerce-catalog-mode' ),
				'options' => array(
					'label_text'              => '<div style="text-align: center;"><strong><span style="font-family: inherit; font-size: 12px;">' . esc_html__( 'LOGIN TO SEE PRICE', 'yith-woocommerce-catalog-mode' ) . '</span></strong></div>',
					'default_colors'          => array(
						'text'       => '#247390',
						'background' => '#ffffff',
						'border'     => '#247390',
					),
					'hover_colors'            => array(
						'text'       => '#ffffff',
						'background' => '#247390',
						'border'     => '#247390',
					),
					'button_url'              => '',
					'border_thickness'        => array(
						'dimensions' => array(
							'top'    => 1,
							'right'  => 1,
							'bottom' => 1,
							'left'   => 1,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
					'border_radius'           => array(
						'dimensions' => array(
							'top'    => 50,
							'right'  => 50,
							'bottom' => 50,
							'left'   => 50,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
					'icon_type'               => 'none',
					'selected_icon'           => '',
					'selected_icon_size'      => '',
					'selected_icon_alignment' => 'flex-start',
					'custom_icon'             => '',
					'width_settings'          => array(
						'width' => 150,
						'unit'  => 'px',
					),
					'margin_settings'         => array(
						'dimensions' => array(
							'top'    => 0,
							'right'  => 0,
							'bottom' => 0,
							'left'   => 0,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
					'padding_settings'        => array(
						'dimensions' => array(
							'top'    => 5,
							'right'  => 10,
							'bottom' => 5,
							'left'   => 10,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
				),
			),
			array(
				'name'    => esc_html__( 'Sample Label', 'yith-woocommerce-catalog-mode' ),
				'options' => array(
					/* translators: %s sample phone number */
					'label_text'              => '<div><span style="color: #9f4300; font-size: 16px;"><strong><span style="font-family: inherit;">' . esc_html__( 'Contact us to inquire about this product', 'yith-woocommerce-catalog-mode' ) . '</span></strong></span><br /><br /><span style="font-size: 14px;">' . sprintf( esc_html__( 'If you love this product and wish for a customized quote contact us at number %s and we will be happy to provide you with more info!', 'yith-woocommerce-catalog-mode' ), '<strong>+01234567890</strong>' ) . '</span></div>',
					'default_colors'          => array(
						'text'       => '#4b4b4b',
						'background' => '#f9f5f2',
						'border'     => '#e3bdaf',
					),
					'hover_colors'            => array(
						'text'       => '#4b4b4b',
						'background' => '#f9f5f2',
						'border'     => '#e3bdaf',
					),
					'button_url'              => '',
					'border_thickness'        => array(
						'dimensions' => array(
							'top'    => 1,
							'right'  => 1,
							'bottom' => 1,
							'left'   => 1,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
					'border_radius'           => array(
						'dimensions' => array(
							'top'    => 5,
							'right'  => 5,
							'bottom' => 5,
							'left'   => 5,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
					'icon_type'               => 'none',
					'selected_icon'           => '',
					'selected_icon_size'      => '',
					'selected_icon_alignment' => 'flex-start',
					'custom_icon'             => '',
					'width_settings'          => array(
						'width' => '',
						'unit'  => '',
					),
					'margin_settings'         => array(
						'dimensions' => array(
							'top'    => 0,
							'right'  => 0,
							'bottom' => 0,
							'left'   => 0,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
					'padding_settings'        => array(
						'dimensions' => array(
							'top'    => 5,
							'right'  => 10,
							'bottom' => 5,
							'left'   => 10,
						),
						'unit'       => 'px',
						'linked'     => 'no',
					),
				),
			),
		);

		foreach ( $sample_buttons as $sample_button ) {

			$button_data = array(
				'post_title'   => $sample_button['name'],
				'post_content' => '',
				'post_excerpt' => '',
				'post_status'  => 'publish',
				'post_author'  => 0,
				'post_type'    => 'ywctm-button-label',
			);
			$button_id   = wp_insert_post( $button_data );
			foreach ( $sample_button['options'] as $key => $value ) {
				update_post_meta( $button_id, 'ywctm_' . $key, $value );
			}
		}

		update_option( 'ywctm_update_version', YWCTM_VERSION );
	}

	add_action( 'admin_init', 'ywctm_create_sample_buttons' );
}

if ( ! function_exists( 'ywctm_get_exclusion_list_urls' ) ) {
	/**
	 * Get URLs to edit and delete the items in the exclusion list
	 *
	 * @param array  $item Exclusion list item.
	 * @param string $type Exclusion type.
	 *
	 * @return  array
	 */
	function ywctm_get_exclusion_list_urls( $item, $type = 'exclusion' ) {
		$getter     = $_GET; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$query_args = array(
			'page' => $getter['page'],
			'tab'  => $getter['tab'],
			'id'   => $item['ID'],
		);

		if ( isset( $getter['sub_tab'] ) ) {
			$query_args['sub_tab'] = $getter['sub_tab'];
		}

		if ( isset( $getter['paged'] ) ) {
			$query_args['return_page'] = $getter['paged'];
		}

		$section = isset( $getter['sub_tab'] ) ? str_replace( 'exclusions-', '', $getter['sub_tab'] ) : 'items';

		if ( 'items' === $section ) {
			$query_args['item_type'] = $item['item_type'];
		}

		$urls = array(
			'delete' => add_query_arg( array_merge( $query_args, array( 'action' => 'delete' ) ), admin_url( 'admin.php' ) ),
		);

		if ( 'vendor' !== $type ) {
			$urls['edit'] = add_query_arg( array_merge( $query_args, array( 'action' => 'edit' ) ), admin_url( 'admin.php' ) );
		}

		return $urls;
	}
}

if ( ! function_exists( 'ywctm_get_exclusion_list_item_actions' ) ) {
	/**
	 * Get actions for each item in the exclusion list
	 *
	 * @param array  $item Exclusion list item.
	 * @param string $type Exclusion type.
	 *
	 * @return array
	 */
	function ywctm_get_exclusion_list_item_actions( $item, $type = 'exclusion' ) {
		$urls = ywctm_get_exclusion_list_urls( $item, $type );

		$actions = array(
			array(
				'type'         => 'action-button',
				'action'       => 'delete',
				'title'        => esc_html__( 'Delete', 'yith-woocommerce-catalog-mode' ),
				'icon'         => 'trash',
				'url'          => $urls['delete'],
				'confirm_data' => array(
					'title'               => __( 'Confirm delete', 'yith-woocommerce-catalog-mode' ),
					'message'             => __( 'Are you sure you want to delete this item?', 'yith-woocommerce-catalog-mode' ) . '<br /><br />' . __( 'This action cannot be undone and you will not be able to recover this data.', 'yith-woocommerce-catalog-mode' ),
					'confirm-button'      => __( 'Yes, delete', 'yith-woocommerce-catalog-mode' ),
					'cancel-button'       => __( 'No', 'yith-woocommerce-catalog-mode' ),
					'confirm-button-type' => 'delete',
				),
			),
		);

		if ( 'vendor' !== $type ) {
			array_unshift(
				$actions,
				array(
					'type'   => 'action-button',
					'action' => 'edit',
					'title'  => esc_html__( 'Edit', 'yith-woocommerce-catalog-mode' ),
					'icon'   => 'edit',
					'class'  => 'edit-exclusion',
					'url'    => $urls['edit'],
					'data'   => array(
						'item_id' => $item['ID'],
					),
				)
			);
		}

		return $actions;
	}
}
