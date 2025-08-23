<?php
/**
 * Get Gravity Forms List
 *
 * @return array|null
 */
if ( ! function_exists('dipi_get_gravity_forms')) {
    function dipi_get_gravity_forms() {
        $forms_list = [];
        if (class_exists('RGFormsModel')) {
            $gravity_forms = RGFormsModel::get_forms(true);
            if ( ! empty($gravity_forms)) {
                $forms_list = [0 => esc_html__('Please Select A Form', 'dipi-divi-pixel')];
                $forms_list = array_replace(wp_list_pluck($gravity_forms, 'title', 'id'), $forms_list);
            } else {
                $forms_list = array_replace([0 => esc_html__('No form found. Please create new form.', 'dipi-divi-pixel')], $forms_list);
            }
        }
        return $forms_list;
    }
}