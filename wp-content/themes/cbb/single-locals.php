<?php get_header(); ?>

<?php $options = get_option('cbb_custom_settings'); ?>
<?php
  $sliderCategory = isset($options['slider']) ? (int)$options['slider'] : 0;

  if ($sliderCategory > 0) :
    $args = [
      'post_type' => 'sliders',
      'posts_per_page' => -1,
      'order' => 'ASC',
      'orderby' => 'menu_order',
      'tax_query' => [
        [
          'taxonomy' => 'sections',
          'field' => 'term_id',
          'terms' => $sliderCategory
        ]
      ]
    ];

    $sliders = new WP_Query($args);

    if ($sliders->have_posts()) :
      $i = 0; $j = 0;
?>
    <section id="carousel-locals" class="carousel slide Carousel Carousel--home" data-ride="carousel">
      <div class="carousel-inner" role="listbox">
        <?php while ($sliders->have_posts()) : ?>
          <?php $sliders->the_post(); ?>

          <?php
            $values = get_post_custom(get_the_id());
            $title = isset($values['mb_title']) ? esc_attr($values['mb_title'][0]) : '';
            $subtitle = isset($values['mb_subtitle']) ? esc_attr($values['mb_subtitle'][0]) : '';
            // $text = isset($values['mb_text']) ? esc_attr($values['mb_text'][0]) : '';
            // $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
            // $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
            // $target = (!empty($target) && $target === 'on') ? ' target="_blank" rel="noopener noreferrer"' : '';
          ?>

          <div class="item<?php echo ($j === 0) ? ' active' : ''; ?>">
            <?php
              if (has_post_thumbnail()) {
                the_post_thumbnail('full', [
                  'class' => 'img-responsive center-block',
                  'alt' => get_the_title()
                ]);
              }
            ?>
            <div class="carousel-caption">
              <?php if (!empty($subtitle)) : ?><h3><?php echo $subtitle; ?></h3><?php endif; ?>
              <?php if (!empty($title)) : ?><h2><?php echo $title; ?></h2><?php endif; ?>
              <?php the_content(); ?>
              <p><a class="Button Button--red" href="">conocer más</a></p>
            </div>
          </div>
          <?php $j++; ?>
        <?php endwhile; ?>
      </div>

      <button class="Arrow js-move-scroll" href="locals">ir abajo <i class="glyphicon glyphicon-chevron-down"></i></button>
    </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php
  $idSede = 0;

  if (have_posts()) {
    while (have_posts()){
      the_post();
      $idSede = get_the_id();
    }
  }
?>

<?php if ($idSede > 0) : ?>
  <section class="Page" id="locals">
    <div class="container">
      <?php
        $args = [
          'theme_location' => 'locals-menu',
          'container' => 'nav',
          'container_class' => 'MenuZone',
          'menu_class' => 'MenuZone-list MenuZone-list--blue'
        ];

        wp_nav_menu($args);
      ?>

      <?php
        $args = [
          'post_type' => 'locals',
          'posts_per_page' => -1,
          'post_parent' => (int)$idSede
        ];

        $the_query = new WP_Query($args);

        if ($the_query->have_posts()) :
          $i = 0; $j = 0;
      ?>
        <div id="carousel-sedes" class="carousel slide Carousel Carousel--sedes" data-ride="carousel">
          <?php if ($the_query->post_count > 1) : ?>
            <ol class="carousel-indicators">
              <?php while ($the_query->have_posts()) : ?>
                <?php $the_query->the_post(); ?>
                <li data-target="#carousel-sedes" data-slide-to="<?php echo $i; ?>"<?php echo ($i === 0) ? ' class="active"' : ''; ?>></li>
                <?php $i++; ?>
              <?php endwhile; ?>
            </ol>
          <?php endif; ?>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <?php while ($the_query->have_posts()) : ?>
              <?php $the_query->the_post(); ?>
              <div class="item<?php echo ($j === 0) ? ' active' : ''; ?>">
                <?php if (has_post_thumbnail()) : ?>
                  <?php the_post_thumbnail('full', [
                      'class' => 'img-responsive',
                      'alt' => get_the_title()
                    ]);
                  ?>
                  <div class="carousel-caption">
                    <h3><?php the_title(); ?></h3>
                    <?php the_content(); ?>
                  </div>
                <?php endif; ?>
                <p><a class="Button Button--small Button--red" href="">Tour Virtual</a></p>
              </div>
              <?php $j++; ?>
            <?php endwhile; ?>
          </div>

          <?php if ($the_query->post_count > 1) : ?>
            <a class="left carousel-control" href="#carousel-sedes" role="button" data-slide="prev">
              <i class="icon-keyboard_arrow_left"></i>
            </a>
            <a class="right carousel-control" href="#carousel-sedes" role="button" data-slide="next">
              <i class="icon-keyboard_arrow_right"></i>
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </section>
<?php endif; ?>

<?php get_footer(); ?>
