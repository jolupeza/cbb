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
          $prevPost = get_previous_post();
          $nextPost = get_next_post();

          if (is_object($prevPost) || is_object($nextPost)) :
        ?>
          <section class="Single-related text-center">
            <h3 class="Single-related-title text-left">También te puede interesar:</h3>

            <?php if (is_object($prevPost)) : ?>
              <article class="Box-item">
                <?php
                  $permalink = get_permalink($prevPost->ID);
                  $image = wp_get_attachment_image_src(get_post_thumbnail_id($prevPost->ID), 'full');
                  $thumb = false;
                ?>
                <?php if ($image) : ?>
                  <figure class="Box-figure Box-figure--red">
                    <img src="<?php echo $image[0]; ?>" alt="<?php echo $prevPost->post_title; ?>" class="img-responsive center-block" />
                  </figure>
                  <?php $thumb = true; ?>
                <?php endif; ?>
                <article class="Box-content<?php echo !$thumb ? ' Box-content--green' : ''; ?>">
                  <h3 class="Box-title"><a href="<?php echo $permalink; ?>"><?php echo $prevPost->post_title; ?></a></h3>
                  <p><?php echo substr($prevPost->post_content, 0, 100); ?>...</p>
                  <p class="text-center"><a href="<?php echo $permalink; ?>" class="Button Button--small Button--yellow">Leer más</a></p>
                </article>
              </article>
            <?php endif; ?>

            <?php if (is_object($nextPost)) : ?>
              <article class="grid-item Box-item">
                <?php
                  $permalink = get_permalink($nextPost->ID);
                  $image = wp_get_attachment_image_src(get_post_thumbnail_id($nextPost->ID), 'full');
                  $thumb = false;
                ?>
                <?php if ($image) : ?>
                  <figure class="Box-figure Box-figure--red">
                    <img src="<?php echo $image[0]; ?>" alt="<?php echo $nextPost->post_title; ?>" class="img-responsive center-block" />
                  </figure>
                  <?php $thumb = true; ?>
                <?php endif; ?>
                <article class="Box-content<?php echo !$thumb ? ' Box-content--green' : ''; ?>">
                  <h3 class="Box-title"><a href="<?php echo $permalink; ?>"><?php echo $nextPost->post_title; ?></a></h3>
                  <p><?php echo substr($nextPost->post_content, 0, 100); ?>...</p>
                  <p class="text-center"><a href="<?php echo $permalink; ?>" class="Button Button--small Button--yellow">Leer más</a></p>
                </article>
              </article>
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
