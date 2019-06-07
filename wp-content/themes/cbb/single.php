<?php get_header(); ?>

<section class="Page Single">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <?php if (have_posts()) : ?>
          <?php while (have_posts()) : ?>
            <?php the_post(); ?>
            <article class="Single-box">
              <?php if (has_post_thumbnail()) : ?>
                <figure class="Single-figure">
                  <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block', 'alt' => get_the_title()]); ?>
                </figure>
              <?php endif; ?>

              <div class="Single-content">
                <h2 class="Single-title"><?php the_title(); ?></h2>
                <?php the_content(); ?>

                <!-- <p><a href="single.html" class="Button Button--small Button--yellow">Admisión 2016</a></p> -->
              </div>
            </article>
          <?php endwhile; ?>
        <?php endif; ?>

        <?php
          $prevPost = get_previous_post(true);
          $nextPost = get_next_post(true);

          if (is_object($prevPost) || is_object($nextPost)) :
        ?>
          <section class="Single-related text-center">
            <h3 class="Single-related-title text-left">También te puede interesar:</h3>

            <?php if (is_object($prevPost)) : ?>
              <?php
                $args = [
                  'posts_per_page' => 1,
                  'p' => $prevPost->ID
                ];
                $prevPost = get_posts($args);

                foreach ($prevPost as $post) :
                  setup_postdata($post);
              ?>
                <section class="Box-item">
                  <?php $thumb = false; ?>
                  <?php if (has_post_thumbnail()) : ?>
                    <figure class="Box-figure Box-figure--red">
                      <?php the_post_thumbnail('full', [
                          'class' => 'img-responsive center-block',
                          'alt' => get_the_title()
                        ]);
                      ?>
                    </figure>
                    <?php $thumb = true; ?>
                  <?php endif; ?>
                  <article class="Box-content<?php echo !$thumb ? ' Box-content--green' : ''; ?>">
                    <h3 class="Box-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php the_content(''); ?>
                    <p class="text-center"><a href="<?php the_permalink(); ?>" class="Button Button--small Button--yellow">Leer más</a></p>
                  </article>
                </section>
              <?php endforeach; ?>
            <?php endif; ?>

            <?php if (is_object($nextPost)) : ?>
              <?php
                $args = [
                  'posts_per_page' => 1,
                  'p' => $nextPost->ID
                ];
                $nextPost = get_posts($args);

                foreach ($nextPost as $post) :
                  setup_postdata($post);
              ?>
                <section class="grid-item Box-item">
                  <?php $thumb = false; ?>
                  <?php if (has_post_thumbnail()) : ?>
                    <figure class="Box-figure Box-figure--red">
                      <?php the_post_thumbnail('full', [
                          'class' => 'img-responsive center-block',
                          'alt' => get_the_title()
                        ]);
                      ?>
                    </figure>
                    <?php $thumb = true; ?>
                  <?php endif; ?>
                  <article class="Box-content<?php echo !$thumb ? ' Box-content--green' : ''; ?>">
                    <h3 class="Box-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php the_content(''); ?>
                    <p class="text-center"><a href="<?php the_permalink(); ?>" class="Button Button--small Button--yellow">Leer más</a></p>
                  </article>
                </section>
              <?php endforeach; ?>
            <?php endif; ?>
          </section>
        <?php endif; ?>
      </div>

      <div class="col-md-4">
        <aside class="Sidebar">
          <?php get_sidebar('single-sidebar'); ?>
        </aside>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
