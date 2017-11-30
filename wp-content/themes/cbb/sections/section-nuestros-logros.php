<section class="Page" id="<?php echo $post->post_name; ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php
          $title = get_the_excerpt();
          $titleArr = explode('/', $title);
          $idParent = get_the_ID();
        ?>
        <h3 class="Page-subtitle text-center text-gray"><?php echo $titleArr[0]; ?></h3>
        <h2 class="Page-title text-center text-red"><?php echo $titleArr[1]; ?></h2>

        <?php
          $arguments = [
            'post_type' => 'achievements',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
          ];

          $logros = new WP_Query($arguments);

          if ($logros->have_posts()) :
        ?>
          <section class="Cards Cards--logos">
            <?php while ($logros->have_posts()) : ?>
              <?php $logros->the_post(); ?>

              <?php
                $values = get_post_custom(get_the_id());
                $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
                $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
                $target = (!empty($target) && $target === 'on') ? ' target="_blank" rel="noopener noreferrer"' : '';
              ?>
              <?php if (has_post_thumbnail()) : ?>
                <figure class="Cards-item">
                  <?php if (!empty($url)) : ?>
                    <a href="<?php echo $url; ?>" title="<?php the_title(); ?>"<?php echo $target; ?>>
                      <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block', 'alt' => get_the_title()]); ?>
                    </a>
                  <?php else : ?>
                    <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block', 'alt' => get_the_title()]); ?>
                  <?php endif; ?>
                </figure>
              <?php endif; ?>
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
