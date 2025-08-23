<?php
namespace DiviPixel;

class DIPI_Metabox {

	public $post_type;
	public $context;
	public $priority;
	public $hook_priority;
	public $fields;
	public $meta_box_id;
	public $label;

	function __construct( $args = null ){

		$args = wp_parse_args($args, [
			'meta_box_id' => 'dipi_meta_box',
			'label' => 'Divi Pixel Metabox',
			'post_type' => 'post',
			'context' => 'normal',
			'priority' => 'high',
			'hook_priority' => 10,
			'fields' => [],
		]);

		$this->meta_box_id 		= $args['meta_box_id'];
		$this->label 			= $args['label'];
		$this->post_type 		= $args['post_type'];
		$this->context 			= $args['context'];
		$this->priority 		= $args['priority'];
		$this->hook_priority 	= $args['hook_priority'];
		$this->fields 			= $args['fields'];
        
        add_action( 'admin_print_styles-post-new.php', [$this, 'testimonial_admin_style'], 11 );
        add_action( 'admin_print_styles-post.php', [$this, 'testimonial_admin_style'], 11 );

		add_action( 'add_meta_boxes' , [$this, 'add_meta_box'], $this->hook_priority );
		add_action( 'save_post', [$this, 'save_meta_fields'], 1, 2 );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts'] );
		add_action( 'admin_head', [$this, 'scripts'] );
	}

    public function testimonial_admin_style() {

        global $post_type;

        if('dipi_testimonial' == $post_type)
            wp_enqueue_style( 'testimonial_admin_style', plugin_dir_url(__FILE__) . 'css/metabox.css', [], "1.0.0", 'all');
    }

	function enqueue_scripts() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery' );
    }

	function add_meta_box() {
		if( is_array( $this->post_type ) ){
			foreach ( $this->post_type as $post_type ) {
				add_meta_box( $this->meta_box_id, $this->label, array( $this, 'meta_fields_callback' ), $post_type, $this->context, $this->priority );
			}
		}
		else{
			add_meta_box( $this->meta_box_id, $this->label, array( $this, 'meta_fields_callback' ), $this->post_type, $this->context, $this->priority );
		}
	}

	public function meta_fields_callback() {
		
		global $post;
		
		echo '<div class="dipi-meta-box">';
		echo '<input type="hidden" name="dipi_cmb_nonce" id="dipi_cmb_nonce" value="'. esc_attr( wp_create_nonce( plugin_basename( __FILE__ ) ) )  . '" />';
		
		foreach ( $this->fields as $field ) {

			if ( $field['type'] == 'text' || $field['type'] == 'number' || $field['type'] == 'email' || $field['type'] == 'url' || $field['type'] == 'password' ) {
				$this->field_text( $field );
			}

			elseif( $field['type'] == 'textarea' ){
				$this->field_textarea( $field );
			}

			elseif( $field['type'] == 'file' ){
				$this->field_file( $field );
			}

			elseif( $field['type'] == 'select' ){
				$this->field_select( $field );
			}

			do_action( "dipi_meta_field-{$field['name']}", $field, $post->post_type );
		}

		echo '</div>';
	}
	
	function save_meta_fields( $post_id, $post ) {

		if (
			! isset( $_POST['dipi_cmb_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field($_POST['dipi_cmb_nonce']), plugin_basename( __FILE__ ) ) ||
			! current_user_can( 'edit_post', $post->ID ) ||
			$post->post_type == 'revision'
		) {
			return $post->ID;
		}
		
		foreach ( $this->fields as $field ){
			$key = $field['name'];
			switch ($field['type']) {
				case 'file': 
					$meta_values[$key] = (isset($_POST[$key]))? esc_url_raw($_POST[$key]) : '';
					break;					
				case 'textarea':
					$meta_values[$key] = (isset($_POST[$key]))? sanitize_textarea_field($_POST[$key]) : '';
					break;					
				default:
					$meta_values[$key] = (isset($_POST[$key]))? sanitize_text_field($_POST[$key]) : '';
				break;
			}
		}
		foreach ( $meta_values as $key => $value ) {
			$value = implode( ',', (array) $value );
			if( get_post_meta( $post->ID, $key, FALSE )) {
				update_post_meta( $post->ID, $key, $value );
			} else {
				add_post_meta( $post->ID, $key, $value );
			}
			if( ! $value ) delete_post_meta( $post->ID, $key );
		}
	}

	function field_text( $field ){

		global $post;
        $field_name = $field['name'];
		$field_default = isset($field['default']) ? $field['default'] : '';
		$value = get_post_meta( $post->ID, $field_name, true ) != '' ? esc_attr ( get_post_meta( $post->ID, $field_name, true ) ) : $field_default;
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'regular-text';
		$readonly  = isset( $field['readonly'] ) && ( $field['readonly'] == true ) ? " readonly" : "";
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";
		?>
			<div class="dipi-field dipi-text-wrapper" id="dipi-field-<?php echo esc_attr($field_name) ?>">
				<div class="dipi-label">
					<label for="dipi_cmb_%1$s"><?php echo esc_html( $field['label'] ) ?></label>
				</div>
				<div class="dipi-input">
					<input type="<?php echo esc_attr($field['type']) ?>" class="<?php echo esc_attr($class) ?>" id="dipi_cmb_<?php echo esc_attr($field_name) ?>" name="<?php echo esc_attr($field_name) ?>" value="<?php echo esc_attr($value) ?>" <?php echo esc_attr($readonly) ?> <?php echo esc_attr($disabled) ?>  />
				</div>
			</div>
		<?php
		$this->field_description( $field );
		// return $html;
	}

	function field_textarea( $field ){

		global $post;
        $field_name = $field['name'];
        $field_default = isset($field['default']) ? $field['default'] : '';
		$value = get_post_meta( $post->ID, $field_name, true ) != '' ? esc_attr (get_post_meta( $post->ID, $field_name, true ) ) : $field_default;
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'regular-text';
		$cols  = isset( $field['columns'] ) ? $field['columns'] : 30;
		$rows  = isset( $field['rows'] ) ? $field['rows'] : 4;
		$readonly  = isset( $field['readonly'] ) && ( $field['readonly'] == true ) ? " readonly" : "";
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";
		?>
		<div class="dipi-field dipi-textarea-wrapper" id="dipi-field-<?php echo esc_attr($field_name) ?>">
			<div class="dipi-label">
				<label for="dipi_cmb_<?php echo esc_attr($field_name) ?>"><?php echo esc_html($field['label']) ?></label>
			</div>
			<div class="dipi-input">
				$class, $field_name, $field_name, $readonly, $disabled, $value 
				<textarea rows="<?php echo esc_attr($rows) ?>" cols="<?php echo esc_attr($cols) ?>"  
					class="<?php echo esc_attr($class) ?>-text"
					id="dipi_cmb_<?php echo esc_attr($field_name) ?>" 
					name="<?php echo esc_attr($field_name) ?>"
					<?php echo esc_attr($readonly) ?> 
					<?php echo esc_attr($disabled) ?>
				>
					<?php echo esc_textarea($value ) ?>
				</textarea>
			</div>
		</div>
		<?php
		$this->field_description( $field );
	}

	function field_file( $field ){

		global $post;

        $field_name = $field['name'];
        $field_default = isset($field['default']) ? $field['default'] : '';
		$value = get_post_meta( $post->ID, $field_name, true ) != '' ? esc_attr (get_post_meta( $post->ID, $field_name, true ) ) : $field_default;
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'regular-text';
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";
        $id    = $field_name  . '[' . $field_name . ']';
        $button_text = isset( $field['button_text'] ) ? $field['button_text'] : __( 'Choose File' );
		?>
		
		<div class="dipi-field dipi-file-wrapper" id="dipi-field-<?php echo esc_attr($field_name) ?>">
			<div class="dipi-label">
				<label for="dipi_cmb_%1$s"><?php echo esc_html($field['label']) ?></label>
			</div>
			<div class="dipi-input">
				<input type="text" class="<?php echo esc_attr($class) ?>-text dipi-file" 
					id="dipi_cmb_<?php echo esc_attr($field_name) ?>" 
					name="<?php echo esc_attr($field_name) ?>" 
					value="<?php echo esc_url($value) ?>" 
					<?php echo esc_attr($disabled) ?> 
				/>
	 			<input type="button" class="button dipi-browse" value="<?php echo esc_attr($button_text) ?>" 
				 	<?php echo esc_attr($disabled) ?>   />
			</div>
		</div>
		<?php 
		$this->field_description( $field );
	}

	public function field_select( $field ){
		
		global $post;
		
        $field_default = isset($field['default']) ? $field['default'] : '';
        $field_name = $field['name'];
		$value = get_post_meta( $post->ID, $field_name, true ) != '' ? esc_attr ( get_post_meta( $post->ID, $field_name, true ) ) : $field_default;
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'dipi-meta-field';

		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";
		$multiple  = isset( $field['multiple'] ) && ( $field['multiple'] == true ) ? " multiple" : "";
		$name 	   = isset( $field['multiple'] ) && ( $field['multiple'] == true ) ? $field_name . '[]' : $field_name;
 		?>
		<div class="dipi-row" id="dipi_cmb_field_<?php echo esc_attr($field_name) ?>">
			<label class="dipi-label" for="dipi_cmb_<?php echo esc_attr($field_name) ?>"><?php echo esc_html($field['label']) ?></label>
			<select class="<?php echo esc_attr($class) ?>" name="<?php echo esc_attr($name) ?>" id="dipi_cmb_<?php echo esc_attr($name) ?>" 
				<?php echo esc_attr($disabled) ?>
				<?php echo esc_attr($multiple) ?>
			>
		<?php 
        if( $multiple == '' ) :
			foreach ( $field['options'] as $key => $label ) :
			?>
				<option value="<?php echo esc_attr($key) ?>" <?php echo esc_attr(selected( $value, $key, false )) ?>><?php echo esc_html($label) ?></option>
			<?php 
			endforeach;
        else:

        $values = explode( ',', $value );
        foreach ( $field['options'] as $key => $label ) {
        	$selected = in_array( $key, $values ) && $key != '' ? ' selected' : '';
			?>
				<option value="<?php echo esc_attr($key) ?>" <?php echo esc_attr($selected) ?>><?php echo esc_html($label) ?></option>
			<?php 
        }

        endif;
		?>
		</select>
			<?php $this->field_description( $field ); ?> 
		</div> 
		<?php
	}

	function field_description( $args ) {

        if ( ! empty( $args['desc'] ) ) {
        	if( isset( $args['desc_nop'] ) && $args['desc_nop'] ) {
			?>
				<small class="dipi-small"><?php esc_html($args['desc']) ?></small>
			<?php
        	} else{
				?>
					<p class="description"><?php esc_html($args['desc']) ?></p>
				<?php
        	}
        } else {
            echo '';
        }
    }

    function scripts() { ?>
        <script>
            jQuery(document).ready(function($) {
                $('.dipi-browse').on('click', function (event) {
                    event.preventDefault();

                    var self = $(this);

                    var file_frame = wp.media.frames.file_frame = wp.media({
                        title: self.data('title'),
                        button: {
                            text: self.data('select-text'),
                        },
                        multiple: false
                    });

                    file_frame.on('select', function () {
                        attachment = file_frame.state().get('selection').first().toJSON();

                        self.prev('.dipi-file').val(attachment.url);
                        $('.supports-drag-drop').hide()
                    });
                    file_frame.open();
                });
        });
        </script>

        <style type="text/css">
            .form-table th { padding: 20px 10px; }
            .dipi-row { border-bottom: 1px solid #ebebeb; padding: 8px 4px; }
            .dipi-row:last-child { border-bottom: 0px;}
            .dipi-row .dipi-label {display: inline-block; vertical-align: top; width: 200px; font-size: 15px; line-height: 24px;}
            .dipi-row .dipi-browse { width: 96px;}
            .dipi-row .dipi-file { width: calc( 100% - 110px ); margin-right: 4px; line-height: 20px;}
            #postbox-container-1 .dipi-meta-field, #postbox-container-1 .dipi-meta-field-text {width: 100%;}
            #postbox-container-2 .dipi-meta-field, #postbox-container-2 .dipi-meta-field-text {width: 74%;}
            #postbox-container-1 .dipi-meta-field-text.dipi-file { width: calc(100% - 101px) }
            #postbox-container-2 .dipi-meta-field-text.dipi-file { width: calc(100% - 306px) }
            #wpbody-content .metabox-holder { padding-top: 5px; }
        </style>
        <?php
    }
}

// FIXME: Remove this function and call constructor directly
if ( ! function_exists( 'dipi_meta_box' ) ) {
	function dipi_meta_box( $args ){
		return new DIPI_Metabox( $args );
	}
}
