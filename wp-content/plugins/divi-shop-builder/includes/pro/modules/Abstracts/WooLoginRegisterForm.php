<?php

defined( 'ABSPATH' ) || exit;

abstract class DSWCP_WooLoginRegisterForm extends ET_Builder_Module {

	use DSWCP_Module;

	protected $formType;
	protected $formHtml;
	protected $formStrings;

	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	static function getComputedHtml($args=[]) {
		$module = new static();
		foreach ( $module->get_fields() as $fieldId => $field ) {
			if ( ! isset($args[ $fieldId ]) ) {
				$args[ $fieldId ] = isset($field['default']) ? $field['default'] : '';
			}
		}
		$module->props = $args;

		$html = $module->render([], '', $module->slug);
		return $html;
	}

	protected function addComputedField($fields) {
		$fields['__form'] = [
			'type'                => 'computed',
			'computed_callback'   => [static::CLASS, 'getComputedHtml'],
			'computed_depends_on' => []
		];
		foreach ($fields as $fieldId => $field) {
			if (!empty($field['computed_affects'])) {
				$fields['__form']['computed_depends_on'][] = $fieldId;
			}
		}
		return $fields;
	}

	public function contentStart() {
		ob_clean();
	}

	public function contentEnd() {
		$this->formHtml = str_replace('woocommerce-button button', 'woocommerce-button button et_pb_button', ob_get_contents());
	}

	public function filterTranslatedString($string, $sourceString, $textDomain) {
		return (isset($this->formStrings[$sourceString]) && $textDomain == 'woocommerce') ? $this->formStrings[$sourceString] : $string;
	}

	abstract protected function getStrings();

	public function render( $attrs, $content, $render_slug ) {

		if (is_user_logged_in() && !et_fb_is_computed_callback_ajax() && $this->props['enable_test_mode'] === 'off') {
			return '';
		}
		
		$this->css($render_slug);
		$this->formStrings = $this->getStrings();
		add_action('woocommerce_'.$this->formType.'_form_start', [$this, 'contentStart']);
		add_action('woocommerce_'.$this->formType.'_form_end', [$this, 'contentEnd']);
		add_filter('gettext', [$this, 'filterTranslatedString'], 10, 3);
		ob_start();
		wc_get_template('myaccount/form-login.php');
		ob_end_clean();
		remove_filter('gettext', [$this, 'filterTranslatedString'], 10);
		remove_action('woocommerce_'.$this->formType.'_form_start', [$this, 'contentStart']);
		remove_action('woocommerce_'.$this->formType.'_form_end', [$this, 'contentEnd']);
		
		$html = '';
		if ($this->props['show_title'] == 'on') {
			$titleTag = et_pb_process_header_level($this->props['title_level'], 'h2');
			$html .= '<'.$titleTag.' class="ags_login_register_title">'.esc_html($this->props['title']).'</'.$titleTag.'>';
		}
		
		if ($this->props['show_labels'] == 'off') {
			$this->formHtml = preg_replace('#\\<label[\\s\\>].*\\</label\\>#iU', '', $this->formHtml);
		}
		
		if ($this->props['show_placeholders'] == 'on') {
			$this->formHtml = preg_replace_callback('#\\sid\\="(.+)"#iU', function($match) {
				switch ($match[1]) { // id
					case 'username':
					case 'reg_username':
						$placeholder = 'username';
						break;
					case 'password':
					case 'reg_password':
						$placeholder = 'password';
						break;
					case 'reg_email':
						$placeholder = 'email';
						break;
					default:
						return $match[0];
				}
				
				return $match[0].' placeholder="'.esc_attr($this->props['placeholder_'.$placeholder]).'" required';
			}, $this->formHtml);
		}
		
		global $ags_divi_wc;
		
		$isLogin = $this->formType == 'login';
		$isComputedCallbackAjax = et_fb_is_computed_callback_ajax();

		if ($isLogin) {
			$messages = implode('', array_map(function($errorMessage) {
					return '<p class="ags_woo_login_form_error">'.wc_kses_notice($errorMessage).'</p>';
				}, $isComputedCallbackAjax ? [esc_html__('This is a sample error message.', 'divi-shop-builder')] : $ags_divi_wc->loginErrors));
		} else if ($ags_divi_wc->registrationErrors || $isComputedCallbackAjax) {
			$messages = implode('', array_map(function($errorMessage) {
					return '<p class="ags_woo_register_form_error">'.wc_kses_notice($errorMessage).'</p>';
				}, $isComputedCallbackAjax ? [esc_html__('This is a sample error message.', 'divi-shop-builder')] : $ags_divi_wc->registrationErrors));
		} else if ($ags_divi_wc->registrationSuccessMessage) {
			$messages = '<p class="ags_woo_register_form_success">'.wc_kses_notice($ags_divi_wc->registrationSuccessMessage).'</p>';
		} else {
			$messages = '';
		}

		$html .= '<form class="'.esc_attr('woocommerce-form woocommerce-form-'.$this->formType.' '.$this->formType).'" method="post">'
			.$messages
			.et_core_intentionally_unescaped($this->formHtml, 'html')
			.'<input type="hidden" name="divishopbuilder_loginregister" value="1">'
			.($isLogin || $this->props['redirect_after_login'] !== 'off' ? '' : '<input type="hidden" name="divishopbuilder_no_login" value="1">')
			.($this->props['redirect_after_login'] !== 'on' || empty($this->props['redirect_url']) ? '' : '<input type="hidden" name="redirect" value="'.esc_url($this->props['redirect_url']).'">')
			.'</form>';
		
		return $html;
	}
	
	protected function _set_fields_unprocessed($fields) {
		if (isset($fields['title_level'])) {
			$fields['title_level']['computed_affects'] = [ '__form' ];
		}
		return parent::_set_fields_unprocessed($fields);
	}

}