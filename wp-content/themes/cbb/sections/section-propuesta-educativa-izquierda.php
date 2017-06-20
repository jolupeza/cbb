<section class="Page" id="<?php echo $post->post_name; ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3 class="Page-subtitle text-gray">nivel</h3>
        <h2 class="Page-title text-red"><?php the_title(); ?></h2>
        <?php the_content(); ?>
        <p><a class="Button Button--red Button--icon" href=""><i class="icon-play2"></i> ver video</a></p>

        <section class="Page-table Page-table--blue">
          <article class="Page-cel">
            <i class="icon-commenting-o"></i>
            <h3 class="Page-cel-title">Comunicarse</h3>
            <p>con nuestros alumnos es la mejor forma de enseñar y saber que necesitan.</p>
          </article>
          <article class="Page-cel">
            <i class="icon-brush-alt"></i>
            <h3 class="Page-cel-title">Expresión Artística</h3>
            <p>ayudamos a desarrollar su imaginación y su interés por el arte.</p>
          </article>
          <article class="Page-cel">
            <i class="icon-commenting-o"></i>
            <h3 class="Page-cel-title">Comunicarse</h3>
            <p>con nuestros alumnos es la mejor forma de enseñar y saber que necesitan.</p>
          </article>
          <article class="Page-cel">
            <i class="icon-brush-alt"></i>
            <h3 class="Page-cel-title">Expresión Artística</h3>
            <p>ayudamos a desarrollar su imaginación y su interés por el arte.</p>
          </article>
        </section>
      </div>
      <div class="col-md-6">
        <?php if (has_post_thumbnail()) : ?>
          <figure class="Page-figure">
            <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block', 'alt' => get_the_title()]); ?>
          </figure>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php
  $values = get_post_custom(get_the_id());
  $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';
?>

<?php if (!empty($parallax)) : ?>
  <?php
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
      <article class="Parallax-caption Parallax-caption--full animation-element animated" data-animation="swing">
        <h2 class="Parallax-caption-title text-center"><?php echo $title; ?></h2>
        <?php the_content(); ?>
      </article>
    </section>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
