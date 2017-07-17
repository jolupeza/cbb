<section class="Page Page--pb" id="<?php echo $post->post_name; ?>">
  <?php
    $pageParent = get_the_id();
    $values = get_post_custom($pageParent);
    $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="Page-title text-red"><?php the_title(); ?></h2>
        <?php the_excerpt(); ?>

        <?php
          $arguments = [
            'post_type' => 'page',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_parent' => $pageParent
          ];

          $pageChilds = new WP_Query($arguments);

          if ($pageChilds->have_posts()) :
            $i = 1;
        ?>
          <section class="Page-table Page-table--red">
            <?php while ($pageChilds->have_posts()) : ?>
              <?php $pageChilds->the_post(); ?>
              <article class="Page-cel">
                <i class="Pasos Pasos--<?php echo $i; ?>"></i>
                <h3 class="Page-cel-title">Paso</h3>
                <?php the_content(); ?>
              </article>
              <?php $i++; ?>
            <?php endwhile; ?>
          </section>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>

        <?php setup_postdata($post); ?>
        <div class="Page-asterisc">
          <?php the_content(); ?>
        </div>

        <p class="text-center"><a class="Button Button--red Button--medium" href="">Matricularme ahora</a></p>
      </div>
      <div class="col-md-6">
        <?php if (has_post_thumbnail($pageParent)) : ?>
          <figure class="Page-figure">
            <?php echo get_the_post_thumbnail($pageParent, 'full', [
                'class' => 'img-responsive center-block',
                'alt' => get_the_title($pageParent)
              ]);
            ?>
          </figure>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

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
      <article class="Parallax-caption Parallax-caption--left animation-element animated" data-animation="swing">
        <h2 class="Parallax-caption-title text-center"><?php echo $title; ?></h2>
        <?php the_content(); ?>
      </article>
    </section>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
