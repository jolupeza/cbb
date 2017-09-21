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
      <?php
        $title = get_the_excerpt();
        $titleArr = explode('/', $title);
      ?>
      <h3 class="PageHome-subtitle text-center"><?php echo $titleArr[0]; ?></h3>
      <h2 class="PageHome-title text-center"><?php echo $titleArr[1]; ?></h2>

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
            <div class="PageHome-info-desc">
              <h4 class="PageHome-info-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
              <div class="PageHome-info-text">
                <?php the_content(' '); ?>
              </div>
            </div>
          </article>
        <?php endwhile; ?>
      </section>

      <p class="text-center"><a class="Button Button--blue" href="<?php echo home_url('vida-escolar'); ?>">Vida Escolar</a></p>
    </div>
  </section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
