<section class="Page" id="<?php echo $post->post_name; ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="Page-title text-center text-gray">¿Por qué el nombre <span>Bertolt Brecht?</span></h2>
        <?php the_content(); ?>
        <p><a class="Button Button--blue" href="">ver reglamento escolar</a></p>
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
        $backgroundUrl = wp_get_attachment_url(get_post_thumbnail_id(get_the_id()));
?>
  <section class="Parallax Parallax--pages" style="background-image: url('<?php echo $backgroundUrl; ?>');">

  <?php
    $objectsPage = get_page_by_title('Objetivos');

    $params = [
      'post_type' => 'page',
      'post_parent' => $objectsPage->ID,
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'posts_per_page' => -1
    ];

    $childPages = new WP_Query($params);

    if ($childPages->have_posts()) :
      while ($childPages->have_posts()) :
        $childPages->the_post();
  ?>
    <article class="Parallax-page">
      <?php if (has_post_thumbnail()) : ?>
        <figure class="Parallax-page-figure animation-element animated" data-animation="swing">
          <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>
        </figure>
      <?php endif; ?>
      <h3 class="Parallax-page-title text-center animation-element animated" data-animation="bounceInLeft"><?php the_title(); ?></h3>
      <div class="animation-element animated" data-animation="flipInX">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
  </section>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
