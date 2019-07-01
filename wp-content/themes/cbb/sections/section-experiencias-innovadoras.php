<section class="Page" id="<?php echo basename(get_permalink()); ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="Page-title text-red text-center"><?php the_title(); ?></h2>
        <?php the_content(); ?>

        <?php
          $args = [
            'post_type' => 'experiences',
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'posts_per_page' => 4
          ];

          $experiences = new WP_Query($args);
        ?>
        <?php if ($experiences->have_posts()) : ?>
          <section class="Experiences">
            <?php while ($experiences->have_posts()) : ?>
              <?php $experiences->the_post(); ?>
              <article class="Experiences__item">
                <?php if (has_post_thumbnail()) : ?>
                  <figure class="Experiences__figure">
                    <a href="<?php the_permalink(); ?>" title="<?php _e(get_the_title()); ?>">
                      <?php the_post_thumbnail('full', [
                        'class' => 'img-responsive',
                        'alt' => get_the_title()
                      ]); ?>
                    </a>
                  </figure>
                <?php endif; ?>
                <h3 class="Page-subtitle text-red text-center"><?php the_title(); ?></h3>
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
  if (file_exists(TEMPLATEPATH . '/partials/parallax.php')) {
    include TEMPLATEPATH . '/partials/parallax.php';
  }
?>
