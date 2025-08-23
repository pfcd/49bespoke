<?php
namespace DiviPixel;

$blog_related_box_column = DIPI_Customizer::get_option('blog_related_box_column'); //FIXME: Default was '3'
$blog_related_box_hover_effect = DIPI_Customizer::get_option('blog_related_box_hover_effect');
$blog_related_image_hover_effect = DIPI_Customizer::get_option('blog_related_image_hover_effect');
$blog_related_title_position = DIPI_Customizer::get_option('blog_related_title_position'); //FIXME: Default was 0
$dipi_related_articles_limit = DIPI_Settings::get_option('related_articles_limit');
$blog_related_icon_effect = DIPI_Customizer::get_option('blog_related_icon_effect');

// Box hover
$dipi_box_hover_effect_class = '';

if( 'zoomin' === $blog_related_box_hover_effect) :
  $dipi_box_hover_effect_class = 'dipi-zoom-in';
elseif( 'zoomout' === $blog_related_box_hover_effect) :
  $dipi_box_hover_effect_class = 'dipi-zoom-out';
elseif( 'moveup' === $blog_related_box_hover_effect) :
  $dipi_box_hover_effect_class = 'dipi-move-up';
endif;

// Image hover
$dipi_image_hover_effect_class = '';

if( 'zoomin' === $blog_related_image_hover_effect) :
  $dipi_image_hover_effect_class = 'dipi-zoom-in';
elseif( 'zoomout' === $blog_related_image_hover_effect) :
  $dipi_image_hover_effect_class = 'dipi-zoom-out';
elseif( 'zoomrotate' === $blog_related_image_hover_effect) :
  $dipi_image_hover_effect_class = 'dipi-zoom-rotate';
endif;

// Swtich title position
$dipi_switch_title_class = '';

if( !$blog_related_title_position ) : 
  $dipi_switch_title_class = 'dipi-content-over-image';
else :
  $dipi_switch_title_class = 'dipi-content-bottom-image';
endif;

//Effect
$dipi_icon_effect_class = '';

if( 'always' === $blog_related_icon_effect) :
  $dipi_icon_effect_class = 'dipi-icon-always';
elseif( 'onhover' === $blog_related_icon_effect) :
  $dipi_icon_effect_class = 'dipi-icon-onhover';
elseif( 'hideonhover' === $blog_related_icon_effect) :
  $dipi_icon_effect_class = 'dipi-icon-hideonhover';
endif;

// Limit
$dipi_related_articles_limit = (is_numeric($dipi_related_articles_limit)) ? $dipi_related_articles_limit : '6';

global $post;
$index = 0; 
$args = array();

$options = array(
  'post_id'     => !empty($post) ? $post->ID : '',
  'taxonomy'    => 'category',
  'post_type'   => 'post',
  'orderby'     => 'date',
  'limit'       => $dipi_related_articles_limit,
  'order'       => 'DESC'
);

$args = wp_parse_args($args, $options);

if (!taxonomy_exists( $args['taxonomy'] ) ) {
	return;
}

$taxonomies = wp_get_post_terms($args['post_id'], $args['taxonomy'], array('fields' => 'ids'));

if (!isset($taxonomies)) {
	return;
}

// query
$related_posts = new \WP_Query(array(
	'post__not_in' => (array) $args['post_id'],
	'post_type' => $args['post_type'],
	'tax_query' => array(
    array(
      'taxonomy' => $args['taxonomy'],
      'field' => 'term_id',
      'terms' => $taxonomies
    ),
	),
	'posts_per_page' => $args['limit'],
	'orderby' => $args['orderby'],
	'order' => $args['order']
));

$related_articles_heading = DIPI_Settings::get_option('related_articles_heading');
$related_articles_heading = (!empty($related_articles_heading)) ? $related_articles_heading : esc_html__('Related Articles', 'dipi-divi-pixel');

?>

<div id="dipi-related-article-box" class="dipi-related-articles">
<h3 class="dipi-related-section-articles-title">
  <?php echo esc_html( $related_articles_heading ); ?>
</h3>
<div class="dipi-related-articles-row">
  
  <?php 
  if( $related_posts->have_posts() ):
  while( $related_posts->have_posts() ): $related_posts->the_post(); 
    if( $index % $blog_related_box_column == 0 && $index != 0) :
      echo '</div><div class="dipi-related-articles-row">';
    endif;
  ?>
  <div class="dipi-related-article-column dipi-column-<?php echo esc_attr($blog_related_box_column); ?> <?php echo esc_attr($dipi_box_hover_effect_class); ?>">
    <div class="dipi-related-article-content">
      <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
      <?php if (has_post_thumbnail()) { ?>
      <div class="dipi-related-article-thumb-wrap">
        <div class="dipi-related-article-thumb <?php echo esc_attr($dipi_image_hover_effect_class); ?>">
          <?php echo get_the_post_thumbnail( null, 'full', array( 'alt' => the_title_attribute( array('echo' => false) ) ) ); ?>
          <div class="dipi-image-overlay"></div>
        </div>
      </div>
      <?php } else { ?>
      <div class="dipi-related-article-thumb-wrap">
        <div class="dipi-related-article-thumb <?php echo esc_attr($dipi_image_hover_effect_class); ?>">
          <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSI1NDAiIHZpZXdCb3g9IjAgMCAxMDgwIDU0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPHBhdGggZmlsbD0iI0VCRUJFQiIgZD0iTTAgMGgxMDgwdjU0MEgweiIvPgogICAgICAgIDxwYXRoIGQ9Ik00NDUuNjQ5IDU0MGgtOTguOTk1TDE0NC42NDkgMzM3Ljk5NSAwIDQ4Mi42NDR2LTk4Ljk5NWwxMTYuMzY1LTExNi4zNjVjMTUuNjItMTUuNjIgNDAuOTQ3LTE1LjYyIDU2LjU2OCAwTDQ0NS42NSA1NDB6IiBmaWxsLW9wYWNpdHk9Ii4xIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgICAgICA8Y2lyY2xlIGZpbGwtb3BhY2l0eT0iLjA1IiBmaWxsPSIjMDAwIiBjeD0iMzMxIiBjeT0iMTQ4IiByPSI3MCIvPgogICAgICAgIDxwYXRoIGQ9Ik0xMDgwIDM3OXYxMTMuMTM3TDcyOC4xNjIgMTQwLjMgMzI4LjQ2MiA1NDBIMjE1LjMyNEw2OTkuODc4IDU1LjQ0NmMxNS42Mi0xNS42MiA0MC45NDgtMTUuNjIgNTYuNTY4IDBMMTA4MCAzNzl6IiBmaWxsLW9wYWNpdHk9Ii4yIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgIDwvZz4KPC9zdmc+Cg==" alt="">
          <div class="dipi-image-overlay"></div>
        </div>
      </div>
      <?php } ?>

        <div class="dipi-related-article-bottom <?php echo esc_attr($dipi_switch_title_class); ?>">
          <h4 class="dipi-related-article-title">
            <?php the_title(); ?>
          </h4>
          <?php if( 
            'always' === $blog_related_icon_effect || 
            'onhover' === $blog_related_icon_effect || 
            'hideonhover' === $blog_related_icon_effect
            ) : ?>
          <div class="dipi-related-article-arrow <?php echo esc_attr($dipi_icon_effect_class); ?>">
            <span class="et_pb_font_icon dipi-readmore-arrow"></span>
          </div>
        <?php endif; ?>
        </div>
      </a>
    </div>
  </div>
  <?php $index++; 
  endwhile;
  endif;
  wp_reset_postdata();
  ?>
</div>
</div>
<?php

wp_reset_postdata();