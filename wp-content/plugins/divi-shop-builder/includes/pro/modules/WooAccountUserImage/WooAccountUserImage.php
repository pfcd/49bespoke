<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo My Account User Image
 *
 */
class DSWCP_WooAccountUserImage extends DSWCP_WooAccountBase {

    use DSWCP_Module;

	public $slug       	= 'ags_woo_account_user_image';
	public $vb_support 	= 'on';
	protected $endpoint = '';
	protected $icon_path;


	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function get_fields(){
		return array(
			'warning' => array(
				'type'        => 'warning',
				'value'       => is_account_page(),
				'display_if'  => false,
				'message'     => sprintf( '<h4 style="font-size: 14px; margin-top:10px;">%s</h4>',
					esc_html__( 'This module will not function properly on the front end of your website because this is not the assigned My Account page.', 'divi-shop-builder' )
				),
			),
			'align'               => array(
				'label'            => esc_html__( 'Image Alignment', 'divi-shop-builder' ),
				'type'             => 'text_align',
				'option_category'  => 'layout',
				'options'          => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default_on_front' => 'left',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'alignment',
				'description'      => esc_html__( 'Here you can choose the image alignment.', 'divi-shop-builder' ),
				'options_icon'     => 'module_align'
			)
		);
	}

	public function init() {
		$this->name      = esc_html__('Account User Image', 'divi-shop-builder');
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';


		$this->settings_modal_toggles = array(
			'general'    => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Image', 'divi-shop-builder' ),
				),
			),
			'advanced'   => array(
				'toggles' => array(
					'alignment' => esc_html__( 'Alignment', 'divi-shop-builder' ),
					'width'     => array(
						'title'    => esc_html__( 'Sizing', 'divi-shop-builder' ),
						'priority' => 65,
					),
				),
			),
			'custom_css' => array(
				'toggles' => array(
					'animation'  => array(
						'title'    => esc_html__( 'Animation', 'divi-shop-builder' ),
						'priority' => 90,
					),
					'attributes' => array(
						'title'    => esc_html__( 'Attributes', 'divi-shop-builder' ),
						'priority' => 95,
					),
				),
			),
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
			'borders'        => array(
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .image_wrap img',
							'border_styles' => '%%order_class%% .image_wrap img',
						),
					),
					'defaults'  => array(
						'border_styles' => array(
							'width' => '0px',
							'color' => '',
							'style' => 'none',
						),
						'border_radii' => '|||||'
					),
				),
			),
			'box_shadow'     => array(
				'default' => array(
					'css' => array(
						'main'    => '%%order_class%% .image_wrap',
						'overlay' => 'inset',
					),
				),
			),
			'max_width'      => array(
				'options' => array(
					'width'     => array(
						'depends_show_if' => 'off',
					),
					'max_width' => array(
						'depends_show_if' => 'off',
					),
				),
			),
			'height'         => array(
				'css' => array(
					'main' => '%%order_class%% .image_wrap img',
				),
			),
			'fonts'          => false,
			'text'           => false,
			'button'         => false,
			'link_options'   => false,
		);

		/**
		 * Advanced tab custom css fields
		 *
		 */
		$this->custom_css_fields = array(
			'shipping_fields_heading' => array(
				'label'    => esc_html__( 'Heading', 'divi-shop-builder' ),
				'selector' => '%%order_class%% .woocommerce-shipping-fields h3',
			),
			'shipping_fields_labels'  => array(
				'label'    => esc_html__( 'Labels', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% .form-row label',
			),
			'shipping_fields' 		 => array(
				'label'    => esc_html__( 'Fields', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% .form-row input.input-text, .woocommerce %%order_class%% .form-row textarea',
			),
			'shipping_fields_dropdown'=> array(
				'label'    => esc_html__( 'Dropdowns', 'divi-shop-builder' ),
				'selector' => '.woocommerce %%order_class%% .form-row select, .woocommerce %%order_class%% .form-row .select2.select2-container .select2-selection--single',
			),
		);

		/**
		 * Sets to current my account endpoint
		 * So it will render on all the my account endpoints
		 *
		 */
		$this->endpoint = WC()->query->get_current_endpoint();

		add_filter( 'dswcp_builder_js_data', array( $this, 'builder_js_data' ) );
	}

	public function builder_js_data( $data ){
		$locals = array(
			'image' => get_avatar_url( get_current_user_id(), array( 'size' => 300 ) )
		);

		$data['account_user_image'] = $locals;

		return $data;
	}

	public function render( $attrs, $content, $render_slug ){

		if( !$this->_can_render() ){
			return '';
		}

		if( !empty( $this->props['align'] ) ){
			self::set_style_esc( $this->slug, array(
				'selector' 	  => "%%order_class%%",
				'declaration' => "text-align:  {$this->props['align']} !important;"
			));
		}

		ob_start();

		?>
		<div class="image_wrap">
        	<img src="<?php echo esc_url( get_avatar_url( get_current_user_id(), array( 'size' => 500 ) ) ) ?>" />
		</div>
		<?php

		return ob_get_clean();
	}
}

new DSWCP_WooAccountUserImage;