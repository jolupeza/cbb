<?php
  /*
    Template Name: CBB Propuesta Educativa
   */
?>
<?php get_header(); ?>

<?php
  $idPage = 0;
  if (have_posts()) {
    while (have_posts()) {
      the_post();
      $idPage = get_the_id();
    }
  }
?>

<?php
  $args = [
    'post_type' => 'sliders',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'tax_query' => [
      [
        'taxonomy' => 'sections',
        'field' => 'slug',
        'terms' => 'propuesta-educativa'
      ]
    ]
  ];

  $the_query = new WP_Query($args);

  if ($the_query->have_posts()) :
    $i = 0;
?>
    <section id="carousel-propuesta" class="carousel slide Carousel Carousel--home" data-ride="carousel">
      <div class="carousel-inner" role="listbox">
        <?php while ($the_query->have_posts()) : ?>
          <?php $the_query->the_post(); ?>

          <?php
            $values = get_post_custom(get_the_id());
            $title = isset($values['mb_title']) ? esc_attr($values['mb_title'][0]) : '';
            $subtitle = isset($values['mb_subtitle']) ? esc_attr($values['mb_subtitle'][0]) : '';
            // $text = isset($values['mb_text']) ? esc_attr($values['mb_text'][0]) : '';
            // $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
            // $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
            // $target = (!empty($target) && $target === 'on') ? ' target="_blank" rel="noopener noreferrer"' : '';
          ?>

          <?php if (has_post_thumbnail()) : ?>
            <div class="item<?php echo ($i === 0) ? ' active' : ''; ?>">
              <?php the_post_thumbnail('full', [
                  'class' => 'img-responsive center-block',
                  'alt' => get_the_title()
                ]);
              ?>
              <div class="carousel-caption">
                <?php if (!empty($subtitle)) : ?><h3><?php echo $subtitle; ?></h3><?php endif; ?>
                <?php if (!empty($title)) : ?><h2><?php echo $title; ?></h2><?php endif; ?>
                <?php the_content(); ?>
                <p><a class="Button Button--red" href="">conocer más</a></p>
              </div>
            </div>
          <?php endif; ?>
          <?php $i++; ?>
        <?php endwhile; ?>
      </div>

      <button class="Arrow js-move-scroll" href="">ir abajo <i class="glyphicon glyphicon-chevron-down"></i></button>
    </section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php if ($idPage > 0) : ?>
  <?php
    $args = [
      'post_type' => 'page',
      'post_parent' => $idPage,
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'posts_per_page' => -1
    ];

    $mainQuery = new WP_Query($args);
  ?>

  <?php if ($mainQuery->have_posts()) : ?>
    <?php
      while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        global $post;

        $values = get_post_custom(get_the_id());
        $template = isset($values['mb_template']) ? (int)esc_attr($values['mb_template'][0]) : '';

        if (!empty($template)) {
          global $wpdb;
          $slugTemplate = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE post_type = 'templates' AND ID = $template");

          get_template_part('sections/section', $slugTemplate);
        }
      }
    ?>
  <?php endif; ?>
  <?php wp_reset_query(); ?>
<?php endif; ?>

<?php get_footer(); ?>
