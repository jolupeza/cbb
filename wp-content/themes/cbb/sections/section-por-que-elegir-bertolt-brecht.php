<section class="PageHome" id="<?php echo $post->post_name; ?>">
  <?php
    $title = get_the_excerpt();
    $titleArr = explode('/', $title);
  ?>
  <div class="container">
    <h3 class="PageHome-subtitle text-center"><?php echo $titleArr[0]; ?></h3>
    <h2 class="PageHome-title text-center"><?php echo $titleArr[1]; ?></h2>
    <p class="text-center PageHome-legend"><?php echo get_the_content(); ?></p>

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
      <section class="PageHome-cols PageHome-info">
        <?php while ($childPages->have_posts()) : ?>
          <?php $childPages->the_post(); ?>
          <article class="PageHome-item">
            <?php if (has_post_thumbnail()) : ?>
              <figure class="PageHome-info-figure PageHome-info-figure--border">
                <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block img-rounded', 'alt' => get_the_title()]); ?>
              </figure>
            <?php endif; ?>
            <h4 class="text-center PageHome-info-title"><?php the_title(); ?></h4>
            <div class="text-center PageHome-info-text">
              <?php the_content(); ?>
            </div>
          </article>
        <?php endwhile; ?>
      </section>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</section>

<?php
  if (file_exists(TEMPLATEPATH . '/partials/parallax.php')) {
    include TEMPLATEPATH . '/partials/parallax.php';
  }
