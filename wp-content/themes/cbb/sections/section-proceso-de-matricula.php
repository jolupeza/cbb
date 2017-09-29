<section class="Page Page--pb" id="<?php echo $post->post_name; ?>">
  <?php $idParent = get_the_id(); ?>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="Page-title text-red"><?php the_title(); ?></h2>
        <?php the_excerpt(); ?>

        <?php
          $arguments = [
            'post_type' => 'page',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_parent' => $idParent
          ];

          $pageChilds = new WP_Query($arguments);

          if ($pageChilds->have_posts()) :
            $i = 1;
        ?>
          <section class="Page-table Page-table--red">
            <?php while ($pageChilds->have_posts()) : ?>
              <?php $pageChilds->the_post(); ?>
              <article class="Page-cel">
                <i class="Pasos Pasos--<?php echo $i; ?>"></i>
                <h3 class="Page-cel-title">Paso</h3>
                <?php the_content(); ?>
              </article>
              <?php $i++; ?>
            <?php endwhile; ?>
          </section>
        <?php endif; ?>

        <?php setup_postdata($post); ?>
        <?php $content = get_the_content(); ?>
        <?php if (!empty($content)) : ?>
          <div class="Page-asterisc">
            <?php the_content(); ?>
          </div>
        <?php endif; ?>

        <?php /*
        <p class="text-center">
          <a class="Button Button--red Button--medium js-move-scroll" href="#admision-2018">Matricularme ahora</a>
        </p>
        */ ?>
      </div>
      <div class="col-md-6">
        <?php if (has_post_thumbnail($idParent)) : ?>
          <figure class="Page-figure">
            <?php echo get_the_post_thumbnail($idParent, 'full', [
                'class' => 'img-responsive center-block',
                'alt' => get_the_title($idParent)
              ]);
            ?>
          </figure>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php
  if (file_exists(TEMPLATEPATH . '/partials/parallax.php')) {
    include TEMPLATEPATH . '/partials/parallax.php';
  }
