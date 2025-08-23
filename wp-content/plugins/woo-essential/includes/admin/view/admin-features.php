<?php

defined('ABSPATH') || die();

$features = self::get_features_map();
$inactive_features = self::get_inactive('features');
$total_features_count = count($features);
?>

<div class="dnwooe-admin-panel">
    <div class="dnwooe-features-body">
        <form class="dnwooe-features-admin" id="dnwooe-admin-features-form">
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
                    <div class="dnwooe-features-filter-search">
                        <input id="dnwooe-features-filter-search-input" type="text"
                            placeholder="<?php echo esc_attr__('Search features', 'dnwooe') ?>">
                        <div class="dnwooe-features-filter-search-icon">
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
                <div class="dnwooe-admin-features">
                    <?php foreach ($features as $feature_key => $feature_data):
    $titles = isset($feature_data['title']) ? $feature_data['title'] : '';
    $icon = isset($feature_data['icon']) ? $feature_data['icon'] : '';
    $is_pro = isset($feature_data['is_pro']) && $feature_data['is_pro'] ? true : false;
    $demo_url = isset($feature_data['demo']) && $feature_data['demo'] ? $feature_data['demo'] : '';

    $class_attr = 'dnwooe-admin-features-item';

    $class_attr = 'dnwooe-admin-features-item';

    if ($is_pro) {
        $class_attr .= ' dnwooe-feature-is-pro';
    }

    $checked = '';

    if (!in_array($feature_key, $inactive_features)) {
        $checked = 'checked="checked"';
    }

    $is_placeholder = $is_pro;

    if ($is_placeholder) {
        $class_attr .= ' dnwooe-feature-is-placeholder';
        $checked = 'disabled="disabled"';
    }
    ?>
                    <div class="<?php echo esc_attr($class_attr); ?>">
                        <?php if ($is_pro): ?>
                        <span class="dnwooe-admin-features-item-badge badge-pro"><?php esc_html__('pro', 'dnwooe') ?></span>
                        <?php endif;?>
                        <span class="dnwooe-admin-features-item-icon">
                            <img src="<?php echo esc_url($icon); ?>" alt="">
                        </span>
                        <h3 class="dnwooe-admin-features-item-title">
                            <label
                                for="dnwooe-feature-<?php echo esc_attr($feature_key); ?>"><?php echo esc_html($titles); ?></label>
                            <?php if ($demo_url): ?>
                            <a href="<?php echo esc_url($demo_url); ?>" target="_blank" rel="noopener"
                                data-tooltip="<?php echo esc_attr_e('Click and view demo', 'dnwooe'); ?>"
                                class="dnwooe-admin-features-item-preview">
                                <img class="dnwooe-img-fluid dnwooe-item-icon-size"
                                    src="<?php echo esc_url(DNWOO_ESSENTIAL_ASSETS . 'images/admin/desktop.svg'); ?>"
                                    alt="demo-link">
                            </a>
                            <?php endif;?>
                        </h3>
                        <div class="dnwooe-admin-features-item-toggle dnwooe-toggle">
                            <input id="dnwooe-feature-<?php echo esc_attr($feature_key); ?>"
                                <?php echo esc_attr($checked); ?> type="checkbox" class="dnwooe-toggle-check"
                                name="features[]" value="<?php echo esc_attr($feature_key); ?>">
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