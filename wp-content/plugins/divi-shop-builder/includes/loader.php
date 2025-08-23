<?php

if ( ! class_exists( 'ET_Builder_Element' ) ) {
	return;
}


//$module_files = glob( __DIR__ . '/modules/*/*.php' );
/*
// Load custom Divi Builder modules
foreach ( (array) $module_files as $module_file ) {
	if ( $module_file && preg_match( "/\/modules\/\b([^\/]+)\/\\1\.php$/", $module_file ) ) {
		require_once $module_file;
	}
}
*/

trait DSWCP_Module {
	public static function set_style_esc( $slug, $style ) {
		if ( isset( $style['selector'] ) ) {
			$style['selector'] = self::_esc_css( $style['selector'], true );
		}
		if ( isset( $style['declaration'] ) ) {
			$style['declaration'] = self::_esc_css( $style['declaration'] );
		}
		ET_Builder_Element::set_style( $slug, $style );
	}

	private static function _esc_css( $str, $isSelector=false ) {
		// Escape < to prevent closing style tag </style>
		$str = str_replace( '<', '\00003C', $str );

		// Escape various characters to prevent usage of @import and url(), etc.
		$str = preg_replace( $isSelector ? '/[\\{\\};]/' : '/[\\(\\)\\{\\}@]/', '\\\\$0', $str );

		// Restore escaped attr() etc.
		$str = preg_replace( '/(attr|translateX|translateY|rgba|rgb)\\\\\\(([^\\)]*)\\\\\\)/i', '$1($2)', $str );

		return $str;
	}

	/**
	 *  Used to generate responsive module CSS
	 *  Custom margin is based on update_styles() function.
	 *  Divi/includes/builder/module/field/MarginPadding.php
	 *
	 */
	public static function apply_responsive( $props, $value, $selector, $css, $render_slug, $type, $default = null, $important = false ) {

		$dstc_last_edited       = $props[ $value . '_last_edited' ];
		$dstc_responsive_active = et_pb_get_responsive_status( $dstc_last_edited );

		switch ( $type ) {
			case 'custom_margin':

				$responsive = ET_Builder_Module_Helper_ResponsiveOptions::instance();

				// Responsive.
				$is_responsive = $responsive->is_responsive_enabled( $props, $value );

				$margin_desktop = $responsive->get_any_value( $props, $value );
				$margin_tablet  = $is_responsive ? $responsive->get_any_value( $props, "{$value}_tablet" ) : '';
				$margin_phone   = $is_responsive ? $responsive->get_any_value( $props, "{$value}_phone" ) : '';

				$styles = array(
					'desktop' => '' !== $margin_desktop ? rtrim( et_builder_get_element_style_css( $margin_desktop, $css, $important ) ) : '',
					'tablet'  => '' !== $margin_tablet ? rtrim( et_builder_get_element_style_css( $margin_tablet, $css, $important ) ) : '',
					'phone'   => '' !== $margin_phone ? rtrim( et_builder_get_element_style_css( $margin_phone, $css, $important ) ) : '',
				);

				$responsive->declare_responsive_css( $styles, $selector, $render_slug, $important );

				break;

			default:
				$re          = array( '|', 'true', 'false' );
				$dstc        = trim( str_replace( $re, ' ', $props[ $value ] ) );
				$dstc_tablet = trim( str_replace( $re, ' ', $props[ $value . '_tablet' ] ) );
				$dstc_phone  = trim( str_replace( $re, ' ', $props[ $value . '_phone' ] ) );

				$dstc_array = array(
					'desktop' => esc_html( $dstc ),
					'tablet'  => $dstc_responsive_active ? esc_html( $dstc_tablet ) : '',
					'phone'   => $dstc_responsive_active ? esc_html( $dstc_phone ) : '',
				);
				et_pb_responsive_options()->generate_responsive_css( $dstc_array, $selector, $css, $render_slug, $important ? '!important' : '', $type );
		}

	}

}

// ** Disabled default module load code because load order matters for this plugin **
require_once __DIR__ . '/modules/WooShop/WooShop.php';
require_once __DIR__ . '/modules/WooShop-child/WooShop-child.php';
require_once __DIR__ . '/modules/WooNotices/WooNotices.php';

require_once __DIR__.'/'.AGS_divi_wc::PLUGIN_EDITION.'/loader.php';