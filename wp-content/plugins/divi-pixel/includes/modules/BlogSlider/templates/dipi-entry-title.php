<<?php echo esc_attr($header_element); ?> class="dipi-entry-title">
    <?php if($args['card_clickable'] !== 'on'):  ?>
    <a href="<?php esc_url(the_permalink());?>">
    <?php endif; ?>
        <?php the_title();?>
    <?php if($args['card_clickable'] !== 'on'): ?>
    </a>
    <?php endif; ?>
</<?php echo esc_attr($header_element); ?>>