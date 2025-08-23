<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo My Account Dashboard
 *
 */
class DSWCP_WooAccountDashboard extends DSWCP_WooAccountBase {

    use DSWCP_Module;

	public $slug       		= 'ags_woo_account_dashboard';
	public $vb_support 		= 'on';
	protected $endpoint		= '';
	protected $icon;

	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name = esc_html__( 'Account Dashboard', 'divi-shop-builder' );
		$this->icon  = '/';


		$this->settings_modal_toggles = array(
			'general'    => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Content', 'divi-shop-builder' ),
				),
			),
			'advanced'	=> array(
				'toggles' => array(
					'text'   => array(
						'title'             => __( 'Text', 'divi-shop-builder' ),
						'priority'          => 45,
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'     => array(
								'name' => 'P',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_text.svg'),
							),
							'a'     => array(
								'name' => 'A',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . '/includes/media/icons/typography_link.svg'),
							),
							'strong'    => array(
								'name' => 'STRONG',
								'icon' => 'text-bold',
							)
						),
					)
				)
			)
		);

		$this->main_css_element = '%%order_class%% .woocommerce-MyAccount-content';

		$this->advanced_fields = array(
			'fonts' => array(
				'text'     => array(
					'label'           => esc_html__( 'Text', 'divi-shop-builder' ),
					'css'             => array(
						'main'  	  => "{$this->main_css_element} p",
					),
					'line_height'     => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size'       => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug'     => 'text',
					'sub_toggle'      => 'p',
					'hide_text_align' => true,
				),
				'link'     => array(
					'label'       => __( 'Link','divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} a",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'text',
					'sub_toggle'  => 'a',
				),
				'strong'     => array(
					'label'       => __( 'Bold', 'divi-shop-builder' ),
					'css'         => array(
						'main'  => "{$this->main_css_element} strong",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'text',
					'sub_toggle'  => 'strong',
				)
			)
		);

		add_filter( 'dswcp_builder_js_data', array( $this, 'builder_js_data' ) );
	}

	public function get_fields(){
		return array();
	}

	public function render( $attrs, $content, $render_slug ){

		if( !$this->_can_render() ){
			return '';
		}

		ob_start();

		wc_get_template(
			'myaccount/dashboard.php',
			array(
				'current_user' => get_user_by( 'id', get_current_user_id() ),
			)
		);

		return sprintf( '<div class="%s">%s</div>', 'woocommerce-MyAccount-content', ob_get_clean() );
	}

	public function builder_js_data( $data ){
		$locals = array(
			'html_output' => $this->render( array(), null, $this->slug )
		);

		$data['account_dashboard'] = $locals;

		return $data;
	}
}

new DSWCP_WooAccountDashboard;