<?php
if ( ! class_exists('DIPI_GF_Filter_Components')) {
    class DIPI_GF_Filter_Components {
        
        private static $instance = null;

        const BUTTON_CLASSES = ' et_pb_button et_pb_custom_button_icon';

        /**
         * Initialize Instance
         *
         * @return DIPI_GF_Filter_Components|null
         */
        public static function get_instance() {
            if (self::$instance == null) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        /**
         * Initialize Class Constructor
         */
        public function __construct() {
            add_filter('gform_submit_button', [$this, 'filter_gf_submit_btn'], 20, 2);
            add_filter('gform_next_button', [$this, 'filter_gf_next_btn'], 20, 2);
            add_filter('gform_previous_button', [$this, 'filter_gf_previous_btn'], 20, 2);
            add_filter('gform_savecontinue_link', [$this, 'filter_gf_savecontinue_btn'], 20, 2);
            add_filter('gform_field_content', [$this, 'filter_gf_general_btn'], 20, 3);
        }

        /**
         * Filter Submit Button
         *
         * @param $button
         * @param $form
         *
         * @return array|mixed|string|string[]
         */
        public function filter_gf_submit_btn($button, $form) {
            $type = isset($form['button']['type']) ? $form['button']['type'] : 'text';
            if ('image' === $type) {
                return $button;
            }
            
            preg_match('/class=["\'](.*?)["\']/', $button, $matches);
            $button_class = isset($matches[1]) ? $matches[1] : '';
            if ('' !== $button) {
                $class = 'dipi_gf_submit_button gform_button '.self::BUTTON_CLASSES. ' '.$button_class;
                $dom = new DOMDocument();
                $dom->loadHTML('<?xml encoding="UTF-8">'.$button, LIBXML_NOERROR);
                $tags =  $dom->getElementsByTagName('*');
                if ($tags->length > 3) { // html & body & button 
                    return $button;
                }
                $input = $dom->getElementsByTagName('input')->item(0);
                $btn = $dom->getElementsByTagName('button')->item(0);
                if ($input) {
                    $submit_btn = $dom->createElement('button');
                    $submit_btn->appendChild($dom->createTextNode($input->getAttribute('value')));
                    $input->removeAttribute('value');
                    foreach ($input->attributes as $attribute) {
                        $submit_btn->setAttribute($attribute->name, $attribute->value);
                    }
                    $submit_btn->setAttribute('class', $class);
                    $input->parentNode->replaceChild($submit_btn, $input);

                    return $dom->saveHtml($submit_btn);
                } else if ($btn) {
                    $submit_btn = $dom->createElement('button');
                    $submit_btn->appendChild($dom->createTextNode($btn->textContent));
                    foreach ($btn->attributes as $attribute) {
                        $submit_btn->setAttribute($attribute->name, $attribute->value);
                    }
                    $submit_btn->setAttribute('class', $class);
                    $btn->parentNode->replaceChild($submit_btn, $btn);
                    return $dom->saveHtml($submit_btn);
                }
                return $button;
            }

            return $button;
        }

        /**
         * Filter Next Button
         *
         * @param $button
         * @param $form
         *
         * @return false|string|null
         */
        public function filter_gf_next_btn($button, $form) {
            if ('' !== $button) {
                $class = 'dipi_gf_next_button gform_button'.self::BUTTON_CLASSES;
                $dom = new DOMDocument();
                $dom->loadHTML('<?xml encoding="UTF-8">'.$button, LIBXML_NOERROR);
                $input = $dom->getElementsByTagName('input')->item(0);
                $btn = $dom->getElementsByTagName('button')->item(0);
                if ($input) {
                    $next_btn = $dom->createElement('button');
                    $next_btn->appendChild($dom->createTextNode($input->getAttribute('value')));
                    $input->removeAttribute('value');
                    foreach ($input->attributes as $attribute) {
                        $next_btn->setAttribute($attribute->name, $attribute->value);
                    }
                    $next_btn->setAttribute('class', $class);
                    $input->parentNode->replaceChild($next_btn, $input);

                    return $dom->saveHtml($next_btn);
                } else if($btn) {
                    $next_btn = $dom->createElement('button');
                    $next_btn->appendChild($dom->createTextNode($btn->textContent));
                    foreach ($btn->attributes as $attribute) {
                        $next_btn->setAttribute($attribute->name, $attribute->value);
                    }
                    $next_btn->setAttribute('class', $class);
                    $btn->parentNode->replaceChild($next_btn, $btn);

                    return $dom->saveHtml($next_btn);
                }
                return $button;
            }

            return $button;
        }

        /**
         * Filter Previous Button
         *
         * @param $button
         *
         * @param $form
         *
         * @return array|mixed|string|string[]
         */
        public function filter_gf_previous_btn($button, $form) {
            if ('' !== $button) {
                $class = 'dipi_gf_prev_button gform_button'.self::BUTTON_CLASSES;
                $dom = new DOMDocument();
                $dom->loadHTML('<?xml encoding="UTF-8">'.$button, LIBXML_NOERROR);
                $input = $dom->getElementsByTagName('input')->item(0);
                $btn = $dom->getElementsByTagName('button')->item(0);
                if ($input) {
                    $previous_btn = $dom->createElement('button');
                    $previous_btn->appendChild($dom->createTextNode($input->getAttribute('value')));
                    $input->removeAttribute('value');
                    foreach ($input->attributes as $attribute) {
                        $previous_btn->setAttribute($attribute->name, $attribute->value);
                    }
                    $previous_btn->setAttribute('class', $class);
                    $input->parentNode->replaceChild($previous_btn, $input);

                    return $dom->saveHtml($previous_btn);
                } else if ($btn) {
                    $previous_btn = $dom->createElement('button');
                    $previous_btn->appendChild($dom->createTextNode($btn->textContent));
                    foreach ($btn->attributes as $attribute) {
                        $previous_btn->setAttribute($attribute->name, $attribute->value);
                    }
                    $previous_btn->setAttribute('class', $class);
                    $btn->parentNode->replaceChild($previous_btn, $btn);

                    return $dom->saveHtml($previous_btn);
                }
                return $button;
            }

            return $button;
        }

        /**
         * Filter Save/Continue Button
         *
         * @param $button
         *
         * @param $form
         *
         * @return array|string|string[]|null
         */
        public function filter_gf_savecontinue_btn($button, $form) {
            if ('' !== $button) {
                $class = 'dipi_gf_save_link gform_save_link'.self::BUTTON_CLASSES;
                $dom = new DOMDocument();
                $dom->loadHTML('<?xml encoding="UTF-8">'.$button, LIBXML_NOERROR);
                $anchor_tag = $dom->getElementsByTagName('a');
                if (isset($anchor_tag->length) && 1 === $anchor_tag->length) {
                    $button = str_replace('<a', '<button ', $button);
                    $button = preg_replace('/\bgform_save_link\b/', $class, $button);
                } else {
                    $button = preg_replace('/\bgform_save_link button\b/', $class, $button);
                    $button = str_replace('<button', '<button ', $button);
                }
            }

            return $button;
        }

        /**
         * Filter File Upload Button
         *
         * @param $field_content
         * @param $field
         * @param $value
         *
         * @return array|mixed|string|string[]|null
         */
        public function filter_gf_general_btn($field_content, $field, $value) {
            if ($field->type == 'fileupload' && strpos($field_content, 'gform_button_select_files') !== false) {
                $class = 'dipi_gf_upload_button gform_button'.self::BUTTON_CLASSES;
                $field_content = preg_replace('/\bgform_button_select_files\b/', $class, $field_content);
            }

            return $field_content;
        }

    }

    DIPI_GF_Filter_Components::get_instance();
}
