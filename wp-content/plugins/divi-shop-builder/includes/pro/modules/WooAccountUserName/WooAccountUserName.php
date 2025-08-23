<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo My Account User Name
 *
 */
class DSWCP_WooAccountUserName extends DSWCP_WooAccountBase {

    use DSWCP_Module;

	public $slug       	= 'ags_woo_account_user_name';
	public $vb_support 	= 'on';
	protected $endpoint = '';
	protected $icon_path;


	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name      = esc_html__('Account User Name', 'divi-shop-builder');
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';

		$this->settings_modal_toggles = array(
			'general'    => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Content', 'divi-shop-builder' ),
				),
			),
			'advanced'   => array(
				'toggles' => array(
					'username' => esc_html__( 'User Name Text', 'divi-shop-builder' ),
					'before'   => esc_html__( 'Before Text', 'divi-shop-builder' ),
					'after'	   => esc_html__( 'After Text', 'divi-shop-builder' ),
				),
			)
		);

		/**
		 * Desing tab extra fields
		 *
		 */
		$this->advanced_fields = array(
			'margin_padding' => array(
				'css' => array(
					'important' => array( 'custom_margin' ),
				),
			),
			'fonts'          => array(
				'username' => array(
					'label'           => esc_html__( 'User Name Text', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .username-wrapper',
						'important' => 'all',
					),
					'toggle_slug'     => 'username',
					'font'            => array(
						'default' => '||||||||',
					),
				),
				'before'   => array(
					'label'           => esc_html__( 'Before Text', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .username-wrapper > span.before',
						'important' => 'all',
					),
					'toggle_slug'     => 'before',
					'font'            => array(
						'default' => '||||||||',
					),
				),
				'after'	   => array(
					'label'           => esc_html__( 'After Text', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .username-wrapper > span.after',
						'important' => 'all',
					),
					'toggle_slug'     => 'after',
					'font'            => array(
						'default' => '||||||||',
					),
				)
			),
			'text' => array(
				'css' => array(
					'text_orientation' => '%%order_class%% .username-wrapper',
				)
			)
		);

		/**
		 * Sets to current my account endpoint
		 * So it will render on all the my account endpoints
		 *
		 */
		$this->endpoint = WC()->query->get_current_endpoint();

		add_filter( 'dswcp_builder_js_data', array( $this, 'builder_js_data' ) );
	}

	public function get_fields(){
		return array(
			'warning' => array(
				'type'        => 'warning',
				'value'       => is_account_page(),
				'display_if'  => false,
				'message'     => sprintf( '<h4 style="font-size: 14px; margin-top:10px;">%s</h4>',
					esc_html__( 'This module will not function properly on the front end of your website because this is not the assigned My Account page.', 'divi-shop-builder' )
				),
				'toggle_slug'	   => 'main_content'
			),
			'format' => array(
				'label'            => esc_html__( 'Username Format', 'divi-shop-builder' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'username'         => esc_html__( 'Default Username', 'divi-shop-builder' ),
					'first_name'       => esc_html__( 'First Name', 'divi-shop-builder' ),
					'last_name'        => esc_html__( 'Last Name', 'divi-shop-builder' ),
					'full_name'        => esc_html__( 'Full Name', 'divi-shop-builder' ),
					'display_name'	   => esc_html__( 'Display Name', 'divi-shop-builder' )
				),
				'description'      => esc_html__( 'Choose which type of product view you would like to display.', 'divi-shop-builder' ),
				'default'		   => 'username',
				'toggle_slug'	   => 'main_content'
			),
			'before' => array(
				'label'            => esc_html__( 'Before Text', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'configuration',
				'description'      => esc_html__( 'Define the text to be added before the username.', 'divi-shop-builder' ),
				'toggle_slug'	   => 'main_content'
			),
			'after' => array(
				'label'            => esc_html__( 'After Text', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'configuration',
				'description'      => esc_html__( 'Define the text to be added after the username.', 'divi-shop-builder' ),
				'toggle_slug'	   => 'main_content'
			)
		);
	}

	public function builder_js_data( $data ){

		$user = new WC_Customer( get_current_user_id() );
		$user_data = !$user ? false : array(
			'username' 	   => $user->get_username(),
			'first_name'   => $user->get_first_name(),
			'last_name'	   => $user->get_last_name(),
			'full_name'	   => "{$user->get_first_name()} {$user->get_last_name()}",
			'display_name' => $user->get_display_name()
		);

		$locals = array(
			'image' 	=> get_avatar_url( get_current_user_id(), array( 'size' => 300 ) ),
			'user_data' => $user_data
		);

		$data['account_user_name'] = $locals;

		return $data;
	}

	public function render( $attrs, $content, $render_slug ){

		if( !$this->_can_render() ){
			return '';
		}

		$user = new WC_Customer( get_current_user_id() );

		ob_start();

		?>
		<div class="username-wrapper">
        	<?php
			$name 	   = $this->props['format'] === 'full_name' ? join( " ", array( $user->get_first_name(), $user->get_last_name() ) ) : $user->{'get_'.$this->props['format']}();
			$name_text = array();

			if( !empty( $this->props['before'] ) ){
				$name_text[] = sprintf( '<span class="before">%s</span>', esc_html($this->props['before']) );
			}

			if( !empty( $name ) ){
				$name_text[] = sprintf( '<span class="username">%s</span>', esc_html($name) );
			}

			if( !empty( $this->props['after'] ) ){
				$name_text[] = sprintf( '<span class="after">%s</span>', esc_html($this->props['after']) );
			}

			echo et_core_esc_previously(join( " ", $name_text ));
			?>
		</div>
		<?php

		return ob_get_clean();
	}
}

new DSWCP_WooAccountUserName;