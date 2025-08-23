<div id="dipi_popup_setting-navigation">
	<ul class="dipi_popup_setting-nav-tab-wrapper">
		<li>
      <a 
        class="dipi_popup_setting-nav-tab"
        href="#tabs-trigger-settings">
        Triggering Settings
      </a>
    </li>
		<li>
      <a
        class="dipi_popup_setting-nav-tab"
        href="#tabs-popup-locations"
      >
        Popup Locations
      </a>
    </li>
		<li>
      <a
        class="dipi_popup_setting-nav-tab"
        href="#tabs-customization"
      >
        Customization
      </a>
    </li>
    </ul>
    <?php $dipi_pm_meta_tabs_anim = "fadeInRightShort"; ?>
    <?php include_once( 'partials/trigger_settings/index.php' ); ?>
    <?php include_once( 'partials/popup_locations/index.php' ); ?>
    <?php include_once( 'partials/customization/index.php' ); ?>
</div>

<div id="custom-meta-box-nonce" class="hidden">
  <?php echo esc_html(wp_create_nonce( 'acme-custom-meta-box-nonce' )); ?>
</div>









