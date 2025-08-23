<?php echo $ribbon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
<div class="dipi_settings_option_callback <?php echo isset($field["class"]) ? esc_attr($field["class"]) : ""; ?>">
<?php echo call_user_func($field["callback"], $field_id, $field); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>