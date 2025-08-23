<?php
namespace DiviPixel;

if (DIPI_Settings::get_option('error_page_header')): ?>
<style type="text/css">
#page-container {
  margin-top: 0 !important;
  padding-top: 0 !important;
}

#top-header,
#main-header,
.dipi-injected-before-nav,
.dipi-injected-after-nav {
  display: none !important;
}
</style>
<?php endif;

if (DIPI_Settings::get_option('error_page_footer')): ?>
<style type="text/css">
#main-footer,
.dipi-injected-footer,
.dipi-injected-before-footer,
.dipi-injected-after-footer {
  display: none !important;
}
</style>
<?php endif;?>

<style type="text/css">
#main-content > article.et_pb_post {margin-bottom: 0 !important; }
</style>