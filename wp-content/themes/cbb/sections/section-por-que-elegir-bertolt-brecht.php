<section class="PageHome">
  <div class="container">
    <h3 class="PageHome-subtitle text-center">¿Por qué elegir</h3>
    <h2 class="PageHome-title text-center">Bertolt Brecht?</h2>
    <p class="text-center PageHome-legend"><?php echo get_the_content(); ?></p>

    <section class="PageHome-cols PageHome-info">
      <article class="PageHome-item">
        <figure class="PageHome-info-figure PageHome-info-figure--border">
          <img class="img-responsive center-block img-rounded" src="https://lorempixel.com/400/352" alt="" />
        </figure>
        <h4 class="text-center PageHome-info-title">Formación Integral</h4>
        <p class="text-center PageHome-info-text">tanto a nivel intelectual como social de nuestros estudiantes.</p>
      </article>
      <article class="PageHome-item">
        <figure class="PageHome-info-figure PageHome-info-figure--border">
          <img class="img-responsive center-block img-rounded" src="https://lorempixel.com/400/352" alt="" />
        </figure>
        <h4 class="text-center PageHome-info-title">Formamos Líderes</h4>
        <p class="text-center PageHome-info-text">la toma de decisiones un pilar fundamental.</p>
      </article>
      <article class="PageHome-item">
        <figure class="PageHome-info-figure PageHome-info-figure--border">
          <img class="img-responsive center-block img-rounded" src="https://lorempixel.com/400/352" alt="" />
        </figure>
        <h4 class="text-center PageHome-info-title">Formación Integral</h4>
        <p class="text-center PageHome-info-text">tanto a nivel intelectual como social de nuestros estudiantes.</p>
      </article>
      <article class="PageHome-item">
        <figure class="PageHome-info-figure PageHome-info-figure--border">
          <img class="img-responsive center-block img-rounded" src="https://lorempixel.com/400/352" alt="" />
        </figure>
        <h4 class="text-center PageHome-info-title">Formamos Líderes</h4>
        <p class="text-center PageHome-info-text">la toma de decisiones un pilar fundamental.</p>
      </article>
    </section>
  </div>
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
    <article class="animation-element Parallax-caption Parallax-caption--left animated" data-animation="fadeInLeft">
      <h2 class="Parallax-caption-title text-right"><?php echo $title; ?></h2>
      <?php the_content(); ?>
    </article>
  </section>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
