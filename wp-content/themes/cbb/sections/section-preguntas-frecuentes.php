<section class="Page Page--pb" id="<?php echo $post->post_name; ?>">
  <?php
    $idParent = get_the_id();
  ?>

  <div class="container">
    <div class="row">
      <h2 class="Page-title text-azul"><?php the_title(); ?></h2>
      <?php the_excerpt(); ?>

      <?php
        $categories = get_terms([
          'taxonomy' => 'categories_questions',
          'orderby' => 'term_id',
          'order' => 'ASC'
        ]);
      ?>

      <?php if (count($categories)) : ?>
        <?php $j = 0; ?>
        <div class="panel-group Accordion Accordion--parent" id="accordion-category-questions" role="tablist" aria-multiselectable="true">
          <?php foreach ($categories as $category) : ?>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="heading-category-<?php echo $category->term_id; ?>">
                <h4 class="panel-title">
                  <a role="button" data-toggle="collapse" data-parent="#accordion-category-questions" href="#collapse-category-<?php echo $category->term_id; ?>" aria-expanded="<?php echo ($j === 0) ? 'true' : 'false'; ?>" aria-controls="collapse-category-<?php echo $category->term_id; ?>">
                    <?php echo $category->name; ?>
                  </a>
                </h4>
              </div>
              <div id="collapse-category-<?php echo $category->term_id; ?>" class="panel-collapse collapse<?php echo ($j === 0) ? ' in' : ''; ?>" role="tabpanel" aria-labelledby="heading-category-<?php echo $category->term_id; ?>">
                <div class="panel-body">
                  <?php
                    $arguments = [
                      'post_type' => 'questions',
                      'posts_per_page' => -1,
                      'orderby' => 'menu_order',
                      'order' => 'ASC',
                      'tax_query' => [
                        [
                          'taxonomy' => 'categories_questions',
                          'field' => 'term_id',
                          'terms' => $category->term_id
                        ]
                      ]
                    ];

                    $questions = new WP_Query($arguments);

                    if ($questions->have_posts()) :
                      $i = 1;
                  ?>
                    <div class="panel-group Accordion Accordion--child" id="accordion-questions-<?php echo $category->slug; ?>" role="tablist" aria-multiselectable="true">
                      <?php while ($questions->have_posts()) : ?>
                        <?php $questions->the_post(); ?>
                        <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="heading-<?php echo $category->slug; ?>-<?php echo $i; ?>">
                            <h4 class="panel-title">
                              <a role="button" data-toggle="collapse" data-parent="#accordion-questions-<?php echo $category->slug; ?>" href="#collapse-<?php echo $category->slug; ?>-<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $category->slug; ?>-<?php echo $i; ?>">
                                <?php the_title(); ?>
                                <i class="Accordion-button glyphicon glyphicon-chevron-down"></i>
                              </a>
                            </h4>
                          </div>
                          <div id="collapse-<?php echo $category->slug; ?>-<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $category->slug; ?>-<?php echo $i; ?>">
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
                </div>
              </div>
            </div>
            <?php $j++; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php the_content(); ?>

      <p class="text-center"><a class="Button Button--blue Button--medium" href="<?php echo home_url('contactanos') ?>">Contáctanos</a></p>
    </div>
  </div>
</section>

<?php
  if (file_exists(TEMPLATEPATH . '/partials/parallax.php')) {
    include TEMPLATEPATH . '/partials/parallax.php';
  }
