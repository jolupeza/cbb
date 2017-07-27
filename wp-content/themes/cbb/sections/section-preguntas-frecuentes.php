<section class="Page Page--pb" id="<?php echo $post->post_name; ?>">
  <?php
    $idParent = get_the_id();
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
        <?php if (has_post_thumbnail($idParent)) : ?>
          <figure class="Page-figure">
            <?php echo get_the_post_thumbnail($idParent, 'full', [
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

<?php
  if (file_exists(TEMPLATEPATH . '/partials/parallax.php')) {
    include TEMPLATEPATH . '/partials/parallax.php';
  }
