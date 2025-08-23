<?php
namespace Barn2\Plugin\WC_Product_Table\Admin\Table_Generator;

use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Routes\Extra_Fields;
use Barn2\Plugin\WC_Product_Table\Util\Defaults;

/**
 * Setup the list of extra fields for the table generator's edit page.
 */
class Table_Generator_Extras extends Extra_Fields {


	/**
	 * {@inheritdoc}
	 */
	public function get_extra_fields() {
		$default_options = Defaults::get_table_defaults();

		return [
			[
				'type'  => 'th',
				'label' => __( 'Advanced', 'woocommerce-product-table' ),
				'tag'   => 'h2',
				'name'  => 'th',
			],
			[
				'type'     => 'text',
				'label'    => __( 'Image size', 'woocommerce-product-table' ),
				'desc_tip' => __( "Enter a width x height in pixels, e.g. 70x50, or a standard image size such as 'thumbnail'.", 'woocommerce-product-table' ),
				'name'     => 'image_size',
				'value'    => $default_options['image_size'],
				'style'    => [
					'width'    => '200px',
					'maxWidth' => '100%',
				],
			],
			[
				'type'        => 'text',
				'label'       => __( 'Button text', 'woocommerce-product-table' ),
				'description' => sprintf( __( 'If your table uses the "button" column. <a href="%s" target="_blank">Read more</a>', 'woocommerce-product-table' ), 'https://barn2.com/kb/adding-button-column-product-table/' ),
				'name'        => 'button_text',
				'value'       => ! empty( $default_options['button_text'] ) ? $default_options['button_text'] : esc_html__( 'Show details', 'woocommerce-product-table' ),
			],
		];
	}
}
