<?php
  $values = get_post_custom(get_the_id());
  $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';
  $pdf = isset($values['mb_pdf']) ? esc_attr($values['mb_pdf'][0]) : '';
?>

<section class="Page" id="<?php echo $post->post_name; ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <?php
          $title = get_the_excerpt();
          $titleArr = explode('/', $title);
        ?>
        <h2 class="Page-title text-center text-gray"><?php echo $titleArr[0]; ?> <span><?php echo $titleArr[1]; ?></span></h2>
        <?php the_content(); ?>

        <?php if (!empty($pdf)) : ?>
          <p>
            <a class="Button Button--blue" href="<?php echo $pdf; ?>" target="_blank" rel="noopener noreferrer">ver reglamento escolar</a>
          </p>
        <?php endif; ?>
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
        $responsive = isset( $val['mb_responsive'] ) ? esc_attr($val['mb_responsive'][0]) : '';
?>
      <section class="Parallax Parallax--pages">
        <figure class="Parallax-figure">
          <picture>
            <?php if (!empty($responsive)) : ?>
              <source class="img-responsive center-block" media="(max-width: 991px)" srcset="<?php echo $responsive; ?>" />
            <?php endif; ?>
            <?php the_post_thumbnail('full', [
                'class' => 'img-responsive center-block'
              ]);
            ?>
          </picture>

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
              $i = 0;
              while ($childPages->have_posts()) :
                $childPages->the_post();
                $alignPage = ($i === 0) ? 'left' : 'right';
          ?>
            <article class="Parallax-page Parallax-page--<?php echo $alignPage; ?>">
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
            <?php $i++; ?>
          <?php endwhile; ?>
          <?php endif; ?>
          <?php wp_reset_postdata(); ?>
        </figure>
      </section>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
