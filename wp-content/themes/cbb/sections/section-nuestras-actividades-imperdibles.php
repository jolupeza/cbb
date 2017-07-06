<?php
  $args = [
    'post_type' => 'post',
    'posts_per_page' => 4
  ];

  $the_query = new WP_Query($args);

  if ($the_query->have_posts()) :
?>
  <section class="PageHome">
    <div class="container">
      <h3 class="PageHome-subtitle text-center">Nuestras actividades</h3>
      <h2 class="PageHome-title text-center">Imperdibles</h2>

      <section class="PageHome-cols PageHome-info PageHome-info--blog">
        <?php while ($the_query->have_posts()) : ?>
          <?php $the_query->the_post(); ?>
          <article class="PageHome-item">
            <?php if (has_post_thumbnail()) : ?>
              <figure class="PageHome-info-figure">
                <?php the_post_thumbnail('medium', [
                    'class' => 'img-responsive center-block',
                    'alt' => get_the_title()
                  ]);
                ?>
                <aside class="PageHome-info-date text-center">
                  <span class="day"><?php echo get_the_date('d'); ?></span>
                  <span class="month"><?php echo get_the_date('M'); ?></span>
                </aside>
              </figure>
            <?php else : ?>
              <figure class="PageHome-info-figure PageHome-info-figure--noImage">
                <aside class="PageHome-info-date PageHome-info-date--noImage text-center">
                  <span class="day"><?php echo get_the_date('d'); ?></span>
                  <span class="month"><?php echo get_the_date('M'); ?></span>
                </aside>
              </figure>
            <?php endif; ?>
            <h4 class="PageHome-info-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <div class="PageHome-info-text">
              <?php the_content(' '); ?>
            </div>
          </article>
        <?php endwhile; ?>
      </section>

      <p class="text-center"><a class="Button Button--blue" href="<?php echo home_url('vida-escolar'); ?>">ver agenda escolar</a></p>
    </div>
  </section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
