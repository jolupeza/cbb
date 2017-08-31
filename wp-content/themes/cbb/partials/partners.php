<?php
  $args = [
    'post_type' => 'partners',
    'posts_per_page' => -1
  ];

  $the_query = new WP_Query($args);

  if ($the_query->have_posts()) :
?>
<!-- <h2 class="Footer-title">Instituciones Asociadas</h2> -->

<aside class="Footer-logos">
  <?php while ($the_query->have_posts()) : ?>
    <?php $the_query->the_post(); ?>

    <?php
      $values = get_post_custom(get_the_id());
      $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
      $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
      $target = (!empty($target) && $target === 'on') ? ' target="_blank" rel="noopener noreferrer"' : '';
    ?>

    <?php if (has_post_thumbnail()) : ?>
      <figure class="Footer-logo-figure">
        <a href="<?php echo $url; ?>" title="<?php echo get_the_title(); ?>"<?php echo $target; ?>>
          <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block', 'alt' => get_the_title()]); ?>
        </a>
      </figure>
    <?php endif; ?>
  <?php endwhile; ?>
</aside>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
