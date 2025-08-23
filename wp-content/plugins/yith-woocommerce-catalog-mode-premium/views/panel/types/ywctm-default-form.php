<?php
/**
 * Default form field options
 *
 * @package YITH\CatalogMode\Views\ListTable\Panel\Types
 * @var $field array The field options.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$field_id = $field['id'];
$values   = get_option( $field_id );
if ( empty( $values ) ) {
	$values = call_user_func_array( $field['callback_default_form'], array() );
	update_option( $field_id, $values );
}

$columns = array(
	'name'        => array(
		'label'         => _x( 'Name', 'Default form column', 'yith-woocommerce-catalog-mode' ),
		'show_on_table' => true,
		'type'          => 'text',
	),
	'type'        => array(
		'label'         => _x( 'Type', 'Default form column', 'yith-woocommerce-catalog-mode' ),
		'show_on_table' => true,
		'default'       => 'text',
		'type'          => 'select',
		'class'         => 'wc-enhanced-select',
		'options'       => ywctm_get_field_types(),
	),
	'class'       => array(
		'label'         => _x( 'Class', 'Default form column', 'yith-woocommerce-catalog-mode' ),
		'description'   => _x( 'Separate classes with commas', 'Default form description', 'yith-woocommerce-catalog-mode' ),
		'show_on_table' => false,
		'type'          => 'text',
	),
	'label'       => array(
		'label'         => _x( 'Label', 'Default form column', 'yith-woocommerce-catalog-mode' ),
		'show_on_table' => true,
		'type'          => 'text',
	),
	'label_class' => array(
		'label'         => _x( 'Label Class', 'Default form column', 'yith-woocommerce-catalog-mode' ),
		'description'   => _x( 'Separate classes with commas', 'Default form description', 'yith-woocommerce-catalog-mode' ),
		'show_on_table' => false,
		'type'          => 'text',
	),
	'placeholder' => array(
		'label'         => _x( 'Placeholder', 'Default form column', 'yith-woocommerce-catalog-mode' ),
		'show_on_table' => false,
		'type'          => 'text',
		'deps'          => array(
			'id'     => 'type',
			'values' => 'text|email|textarea',
		),
	),
	'description' => array(
		'label'         => _x( 'Description', 'Default form column', 'yith-woocommerce-catalog-mode' ),
		'description'   => _x( 'You can use the shortcode [terms] and [privacy_policy]', 'Default form description', 'yith-woocommerce-catalog-mode' ),
		'show_on_table' => false,
		'type'          => 'textarea',
		'rows'          => 5,
		'columns'       => 10,
		'deps'          => array(
			'id'     => 'type',
			'values' => 'ywctm_acceptance',
		),
	),
	'position'    => array(
		'label'         => _x( 'Position', 'Default form column', 'yith-woocommerce-catalog-mode' ),
		'show_on_table' => false,
		'type'          => 'select',
		'class'         => 'wc-enhanced-select',
		'options'       => ywctm_get_array_positions_form_field(),
		'default'       => 'form-row-wide',
	),
	'required'    => array(
		'label'         => _x( 'Required', 'Default form column', 'yith-woocommerce-catalog-mode' ),
		'show_on_table' => true,
		'type'          => 'onoff',
		'default'       => 'no',
		'deps'          => array(
			'id'     => 'type',
			'values' => 'text|textarea',
		),
	),
	'enabled'     => array(
		'label'         => _x( 'Activate', 'Default form column', 'yith-woocommerce-catalog-mode' ),
		'show_on_table' => true,
		'show_on_popup' => false,
		'default'       => 'yes',
	),
	'actions'     => array(
		'label'         => '',
		'show_on_table' => true,
		'show_on_popup' => false,
	),
);
?>

<div class="ywctm-default-form" data-option-id="<?php echo esc_attr( $field_id ); ?>" data-callback="<?php echo esc_attr( $field['callback_default_form'] ); ?>">
	<div class="ywctm-default-form__form_table">
		<table class="ywctm-default-form-main-table">
			<thead>
			<tr>
				<?php
				foreach ( $columns as $key => $column ) :
					if ( isset( $column['show_on_table'] ) && $column['show_on_table'] ) :
						?>
						<th class="<?php echo esc_attr( $key ); ?>">
							<?php echo esc_html( $column['label'] ); ?>
						</th>
					<?php endif; ?>
				<?php endforeach; ?>
			</tr>
			</thead>
			<tbody class="ui-sortable">
			<?php if ( $values ) : ?>
				<?php
				foreach ( $values as $name => $value ) :
					?>
					<tr>
						<?php
						foreach ( $columns as $key => $column ) :

							$current_default = isset( $column['default'] ) ? $column['default'] : '';
							if ( 'name' === $key ) {
								$current_value = $name;
							} else {
								$current_value = isset( $value[ $key ] ) ? $value[ $key ] : $current_default;
							}

							if ( is_array( $current_value ) ) {
								if ( empty( $current_value ) ) {
									$current_value = '';
								} else {
									$current_value = is_array( $current_value ) && ! empty( $current_value ) ? implode( ',', $current_value ) : $current_value;
								}
							}

							?>
							<input type="hidden" name="field_<?php echo esc_attr( $key ); ?>[]" data-name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $current_value ); ?>" data-default="<?php echo esc_attr( $current_default ); ?>" />
							<?php
							if ( isset( $column['type'] ) && 'select' === $column['type'] ) {
								$current_value = is_array( $current_value ) ? implode( ',', $current_value ) : $current_value;
							}

							if ( isset( $column['show_on_table'] ) && $column['show_on_table'] ) :

								if ( 'enabled' === $key ) :
									?>
									<td class="<?php echo esc_attr( $key ); ?>">
										<?php
										yith_plugin_fw_get_field(
											array(
												'type'  => 'onoff',
												'name'  => $key,
												'value' => $current_value,
											),
											true
										);
										?>
									</td>
									<?php
								elseif ( 'actions' === $key ) :
									$actions = array(
										'edit' => array(
											'type'  => 'action-button',
											'title' => __( 'Edit', 'yith-woocommerce-catalog-mode' ),
											'icon'  => 'edit',
											'url'   => '',
											'class' => 'action__edit',
										),
										'sort' => array(
											'type'  => 'action-sort',
											'title' => __( 'Move', 'yith-woocommerce-catalog-mode' ),
											'icon'  => 'drag',
											'url'   => '',
											'class' => 'action__sort',
										),
									);

									?>
									<td class="<?php echo esc_attr( $key ); ?>">
										<div>
											<?php yith_plugin_fw_get_action_buttons( $actions, true ); ?>
										</div>
									</td>
								<?php elseif ( 'required' === $key ) : ?>
									<td class="<?php echo esc_attr( $key ); ?>">
										<?php
										if ( 'yes' === $current_value ) {
											echo '<div class="field_required"></div>';
										} else {
											echo '-';
										}
										?>
									</td>
								<?php else : ?>
									<?php
									if ( isset( $column['options'], $column['options'][ $current_value ] ) ) {
										$current_value = $column['options'][ $current_value ];
									}
									?>
									<td class="<?php echo esc_attr( $key ); ?>">
										<?php echo esc_html( $current_value ); ?>
									</td>
								<?php endif; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
			</tbody>
			<tfoot>

			</tfoot>
		</table>
	</div>
	<div class="ywctm-default-form__popup_wrapper">
		<div class="ywctm-default-form__form_row">
			<table id="yith_form_fields_table">
				<?php foreach ( $columns as $name => $column ) : ?>
					<?php
					$value             = ( isset( $column['default'] ) ? $column['default'] : '' );
					$show              = ( isset( $column['show_on_popup'] ) ? $column['show_on_popup'] : true );
					$custom_attributes = isset( $column['deps'], $column['deps']['id'], $column['deps']['values'] ) ? 'data-deps="' . $column['deps']['id'] . '" data-deps_value="' . $column['deps']['values'] . '"' : '';

					if ( ! $show ) {
						?>
						<input type="hidden" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>">
						<?php
						continue;
					}

					?>
					<tr class="row-<?php echo esc_attr( $name ); ?>">
						<th class="label"> <?php echo esc_html( $column['label'] ); ?> </th>
						<td>
							<?php

							$args = array(
								'type' => $column['type'],
								'id'   => $name,
								'name' => $name,
							);

							if ( isset( $column['deps'], $column['deps']['id'], $column['deps']['values'] ) ) {
								$args['custom_attributes'] = $custom_attributes;
							}

							switch ( $column['type'] ) {
								case 'select':
									$args['options'] = $column['options'];
									$args['class']   = $column['class'];

									break;
								case 'textarea':
									$args['cols'] = isset( $column['columns'] ) ? $column['columns'] : 10;
									$args['rows'] = isset( $column['rows'] ) ? $column['rows'] : 5;
									break;
							}

							yith_plugin_fw_get_field( $args, true );

							?>

							<?php if ( isset( $column['description'] ) ) : ?>
								<div class="description"><?php echo esc_html( $column['description'] ); ?></div>
							<?php endif; ?>
							<?php if ( 'name' === $name ) : ?>
								<div class="description field-exists">
									<?php esc_html_e( 'This field is already defined', 'yith-woocommerce-catalog-mode' ); ?>
								</div>
								<div class="description required">
									<?php esc_html_e( 'This field is required', 'yith-woocommerce-catalog-mode' ); ?>
								</div>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
