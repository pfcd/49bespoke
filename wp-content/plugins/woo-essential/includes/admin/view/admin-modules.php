<?php

defined('ABSPATH') || die();

$modules = self::get_modules_map();
$inactive_modules = self::get_inactive('modules');
$total_modules_count = count($modules);
?>

<div class="dnwooe-admin-panel">
    <div class="dnwooe-modules-body">
        <form class="dnwooe-modules-admin" id="dnwooe-admin-modules-form">
            <div class="dnwooe-row dnwooe-pad-30">
                <div class="dnwooe-col">
                    <div class="dnwooe-admin-button-panel top-button">
                        <button disabled class="dnwooe-btn dnwooe-btn-save dnwooe-btn-lg dnwooe-ext-switch"
                            type="submit">
                            <?php esc_html_e('Save Settings', 'dnwooe');?>
                        </button>
                    </div>
                </div>
            </div>
            <div class="dnwooe-row dnwooe-pad-30">
                <div class="dnwooe-col">
                    <div class="dnwooe-modules-filter-search">
                        <input id="dnwooe-modules-filter-search-input" type="text"
                            placeholder="<?php echo esc_attr__('Search Modules', 'dnwooe') ?>">
                        <div class="dnwooe-modules-filter-search-icon">
                            <svg width="19" height="19" viewBox="0 0 19 19" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3.075 3.075a7.5 7.5 0 0110.95 10.241l3.9 3.902a.5.5 0 01-.707.707l-3.9-3.901A7.5 7.5 0 013.074 3.075zm.707.707a6.5 6.5 0 109.193 9.193 6.5 6.5 0 00-9.193-9.193z"
                                    fill="#46D39A" fill-rule="nonzero" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dnwooe-col">
                <div class="dnwooe-admin-modules">
                    <?php foreach ($modules as $module_key => $module_data):
    $titles = isset($module_data['title']) ? $module_data['title'] : '';
    $desc = isset($module_data['desc']) ? $module_data['desc'] : '';
    $icon = isset($module_data['icon']) ? $module_data['icon'] : '';
    $is_pro = isset($module_data['is_pro']) && $module_data['is_pro'] ? true : false;
    $demo_url = isset($module_data['demo']) && $module_data['demo'] ? $module_data['demo'] : '';

    $class_attr = 'dnwooe-admin-modules-item';

    $class_attr = 'dnwooe-admin-modules-item';

    if ($is_pro) {
        $class_attr .= ' dnwooe-module-is-pro';
    }

    $checked = '';

    if (!in_array($module_key, $inactive_modules)) {
        $checked = 'checked="checked"';
    }

    $is_placeholder = $is_pro;

    if ($is_placeholder) {
        $class_attr .= ' dnwooe-module-is-placeholder';
        $checked = 'disabled="disabled"';
    }
    ?>
                    <div class="<?php echo esc_attr($class_attr); ?>">
                        <?php if ($is_pro): ?>
                        <span class="dnwooe-admin-modules-item-badge badge-pro">pro</span>
                        <?php endif;?>
                        <span class="dnwooe-admin-modules-item-icon">
                            <img src="<?php echo esc_url($icon); ?>" alt="">
                        </span>
                        <h3 class="dnwooe-admin-modules-item-title">
                            <label
                                for="dnwooe-module-<?php echo esc_attr($module_key); ?>"><?php echo esc_html($titles); ?></label>
                            <?php if ($demo_url): ?>
                            <a href="<?php echo esc_url($demo_url); ?>" target="_blank" rel="noopener"
                                data-tooltip="<?php echo esc_attr_e('Click and view demo', 'dnwooe'); ?>"
                                class="dnwooe-admin-modules-item-preview">
                                <img class="dnwooe-img-fluid dnwooe-item-icon-size"
                                    src="<?php echo esc_url(DNWOO_ESSENTIAL_ASSETS . 'images/admin/desktop.svg'); ?>"
                                    alt="demo-link">
                            </a>
                            <?php endif;?>
                        </h3>
                        <p class="dnwooe-admin-modules-item-desc"><?php echo esc_html($desc); ?></p>
                        <div class="dnwooe-admin-modules-item-toggle dnwooe-toggle">
                            <input id="dnwooe-module-<?php echo esc_attr($module_key); ?>"
                                <?php echo esc_attr($checked); ?> type="checkbox" class="dnwooe-toggle-check"
                                name="modules[]" value="<?php echo esc_attr($module_key); ?>">
                            <b class="dnwooe-toggle-switch"></b>
                            <b class="dnwooe-toggle-track"></b>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="dnwooe-row dnwooe-admin-button-panel">
                <div class="dnwooe-col">
                    <button disabled class="dnwooe-btn dnwooe-btn-save dnwooe-btn-lg dnwooe-ext-switch" type="submit">
                        <?php esc_html_e('Save Settings', 'dnwooe');?>
                    </button>
                </div>
            </div>
            <div class="dnwooe-action-list">
                <label class="dnwooe-toggle-all-wrap">
                    <?php if (!$checked): ?>
                    <input type="checkbox" <?php echo esc_attr($checked); ?>>
                    <span class="dnwooe-toggle-all"><?php esc_html_e('Disable All', 'dnwooe');?></span>
                    <?php else: ?>
                    <input type="checkbox" <?php echo esc_attr($checked); ?>>
                    <span class="dnwooe-toggle-all"><?php esc_html_e('Enable All', 'dnwooe');?></span>
                    <?php endif;?>
                </label>
            </div>
        </form>
    </div>
</div>