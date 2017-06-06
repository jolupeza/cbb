<section class="PageHome" id="<?php echo $post->post_name; ?>">
  <div class="container">
    <h3 class="PageHome-subtitle text-center">Nuevos y modernos</h3>
    <h2 class="PageHome-title text-center">Ambientes</h2>

    <p class="text-center PageHome-legend"><?php echo get_the_content(); ?></p>
    <p class="text-center"><a class="Button Button--blue" href="">ver ambientes</a></p>
  </div>
  <?php if (has_post_thumbnail()) : ?>
    <figure class="PageHome-figure">
      <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block', 'alt' => get_the_title()]); ?>
    </figure>
  <?php endif; ?>
</section>

<?php
  $values = get_post_custom(get_the_id());
  $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';

  if (!empty($parallax)) :
    $arguments = [
      'post_type' => 'parallaxs',
      'p' => (int)$parallax
    ];

    $parallaxData = new WP_Query($arguments);
    if ($parallaxData->have_posts()) :
      while ($parallaxData->have_posts()) :
        $parallaxData->the_post();

        $val = get_post_custom(get_the_id());
        $title = isset($val['mb_title']) ? esc_attr($val['mb_title'][0]) : '';
        $backgroundUrl = wp_get_attachment_url(get_post_thumbnail_id(get_the_id()));
?>
  <section class="Parallax" style="background-image: url('<?php echo $backgroundUrl; ?>');">
    <article class="animation-element Parallax-caption Parallax-caption--right animated" data-animation="fadeInRightBig">
      <h2 class="Parallax-caption-title text-right"><?php echo $title; ?></h2>
      <?php the_content(); ?>
    </article>
  </section>
<?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
