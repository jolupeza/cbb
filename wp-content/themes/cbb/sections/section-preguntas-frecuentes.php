<section class="Page Page--pb" id="<?php echo $post->post_name; ?>">
  <?php
    $pageParent = get_the_id();
    $values = get_post_custom($pageParent);
    $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';
  ?>

  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="Page-title text-azul"><?php the_title(); ?></h2>
        <?php the_excerpt(); ?>

        <div class="panel-group Accordion" id="accordion-questions" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-1">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion-questions" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                  ¿Cuáles son los horarios de atención?
                </a>
              </h4>
            </div>
            <div id="collapse-1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-1">
              <div class="panel-body">
                El horario de atención es de lunes a viernes de 9:00 am. a 1:00 pm.
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-2">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-questions" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                  ¿En qué bancos puedo pagar la pensión?
                </a>
              </h4>
            </div>
            <div id="collapse-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-2">
              <div class="panel-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos modi dolorem non odit est, nisi, pariatur officia harum dolor ut consequuntur quibusdam, neque ab quia quis blanditiis reiciendis omnis error!
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-3">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-questions" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                  ¿Cuáles son los horarios de atención?
                </a>
              </h4>
            </div>
            <div id="collapse-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-3">
              <div class="panel-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero magnam soluta sit neque, facere porro alias nobis ea, libero totam, debitis nisi iste. Commodi illo dolore voluptatibus impedit, ad alias.
              </div>
            </div>
          </div>
        </div>

        <?php the_content(); ?>

        <p class="text-center"><a class="Button Button--blue Button--medium" href="<?php echo home_url('contactanos') ?>">Contáctanos</a></p>
      </div>
      <div class="col-md-6">
        <?php if (has_post_thumbnail()) : ?>
          <figure class="Page-figure">
            <?php the_post_thumbnail('full', [
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

<?php if (!empty($parallax)) : ?>
  <?php
    $arguments = [
      'post_type' => 'parallaxs',
      'p' => (int)$parallax
    ];

    $parallaxData = new WP_Query($arguments);

    if ($parallaxData->have_posts()) :
      while ($parallaxData->have_posts()) :
        $parallaxData->the_post();

        $val = get_post_custom(get_the_id());
        $title = isset($val['mb_title']) ? esc_attr($val['mb_title'][0]) : '';
        $backgroundUrl = wp_get_attachment_url(get_post_thumbnail_id(get_the_id()));
  ?>
      <section class="Parallax" style="background-image: url('<?php echo $backgroundUrl;?>');">
        <article class="Parallax-caption Parallax-caption--right animation-element animated" data-animation="swing">
          <h2 class="Parallax-caption-title text-center"><?php echo $title; ?></h2>
          <?php the_content(); ?>
        </article>
      </section>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
