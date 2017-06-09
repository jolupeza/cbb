<section class="Page" id="<?php echo $post->post_name; ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3 class="Page-subtitle text-center text-gray"><?php the_title(); ?></h3>
        <h2 class="Page-title text-center text-red"><?php echo get_the_excerpt(); ?></h2>

        <?php
          $idParent = get_the_id();

          $arguments = [
            'post_type' => 'page',
            'post_parent' => $idParent,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page' => -1
          ];

          $childPages = new WP_Query($arguments);

          if ($childPages->have_posts()) :
        ?>
          <section class="Cards Cards--history">
            <?php while ($childPages->have_posts()) : ?>
              <?php $childPages->the_post(); ?>
              <article class="Cards-item">
                <h2 class="Cards-title text-center text-red"><?php echo get_the_excerpt(); ?></h2>
                <div class="text-center">
                  <?php the_content(); ?>
                </div>
              </article>
            <?php endwhile; ?>
          </section>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    </div>
  </div>
</section>

<?php
  $values = get_post_custom($idParent);
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
        $legend = isset($val['mb_legend']) ? esc_attr($val['mb_legend'][0]) : '';
        $backgroundUrl = wp_get_attachment_url(get_post_thumbnail_id(get_the_id()));
?>
      <section class="Parallax" style="background-image: url('<?php echo $backgroundUrl; ?>');">
        <article class="Parallax-caption Parallax-caption--right animation-element animated" data-animation="fadeInRight">
          <?php the_content(); ?>
          <h2 class="Parallax-caption-title text-right"><?php echo $title; ?></h2>
          <h4 class="Parallax-caption-author text-right"><?php echo $legend; ?></h4>
        </article>
      </section>
    <?php endwhile; ?>
  <?php endif; ?>
<?php endif; ?>
