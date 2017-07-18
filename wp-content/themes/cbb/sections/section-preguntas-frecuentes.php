<section class="Page Page--pb" id="<?php echo $post->post_name; ?>">
  <?php
    $pageParent = get_the_id();
    $values = get_post_custom($pageParent);
    $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';
  ?>

  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="Page-title text-azul"><?php the_title(); ?></h2>
        <?php the_excerpt(); ?>

        <?php
          $arguments = [
            'post_type' => 'questions',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
          ];

          $questions = new WP_Query($arguments);

          if ($questions->have_posts()) :
            $i = 1;
        ?>
          <div class="panel-group Accordion" id="accordion-questions" role="tablist" aria-multiselectable="true">
            <?php while ($questions->have_posts()) : ?>
              <?php $questions->the_post(); ?>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading-<?php echo $i; ?>">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-questions" href="#collapse-<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $i; ?>">
                      <?php the_title(); ?>
                    </a>
                  </h4>
                </div>
                <div id="collapse-<?php echo $i; ?>" class="panel-collapse collapse<?php echo ($i === 1) ? ' in' : ''; ?>" role="tabpanel" aria-labelledby="heading-<?php echo $i; ?>">
                  <div class="panel-body">
                    <?php the_content(); ?>
                  </div>
                </div>
              </div>
              <?php $i++; ?>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>

        <?php the_content(); ?>

        <p class="text-center"><a class="Button Button--blue Button--medium" href="<?php echo home_url('contactanos') ?>">Contáctanos</a></p>
      </div>
      <div class="col-md-6">
        <?php if (has_post_thumbnail($pageParent)) : ?>
          <figure class="Page-figure">
            <?php echo get_the_post_thumbnail($pageParent, 'full', [
                'class' => 'img-responsive center-block',
                'alt' => get_the_title()
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
      <section class="Parallax" style="background-image: url('<?php echo $backgroundUrl;?>');">
        <article class="Parallax-caption Parallax-caption--right animation-element animated" data-animation="swing">
          <h2 class="Parallax-caption-title text-center"><?php echo $title; ?></h2>
          <?php the_content(); ?>
        </article>
      </section>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
