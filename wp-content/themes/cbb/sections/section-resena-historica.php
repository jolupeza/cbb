<section class="Page" id="<?php echo $post->post_name; ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php
          $arrTitle = get_the_excerpt();
          $arrTitle = explode('/', $arrTitle);
        ?>
        <h3 class="Page-subtitle text-center text-gray">
          <?php
            if (count($arrTitle) > 1) {
              echo $arrTitle[0];
            } else {
              the_title();
            }
          ?>
        </h3>
        <?php if (count($arrTitle) > 1) : ?>
          <h2 class="Page-title text-center text-red"><?php echo $arrTitle[1]; ?></h2>
        <?php endif; ?>

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
          <section class="bxslider Cards Cards--history">
            <?php while ($childPages->have_posts()) : ?>
              <?php $childPages->the_post(); ?>
              <article class="Cards-item">
                <?php if (has_excerpt()) : ?>
                  <h2 class="Cards-title text-center text-red"><?php echo get_the_excerpt(); ?></h2>
                <?php endif; ?>
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
  if (file_exists(TEMPLATEPATH . '/partials/parallax.php')) {
    include TEMPLATEPATH . '/partials/parallax.php';
  }
