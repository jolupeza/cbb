<?php
  /*
    Template Name: CBB Nosotros
   */
?>
<?php get_header(); ?>

<?php
  $idPage = 0;
  $poster = '';
  $webm = '';
  $mp4 = '';
  $ogv = '';

  if (have_posts()) {
    while (have_posts()) {
      the_post();
      $idPage = get_the_id();

      $values = get_post_custom($idPage);
      $poster = isset($values['mb_poster']) ? esc_attr($values['mb_poster'][0]) : $poster;
      $webm = isset($values['mb_webm']) ? esc_attr($values['mb_webm'][0]) : $webm;
      $mp4 = isset($values['mb_mp4']) ? esc_attr($values['mb_mp4'][0]) : $mp4;
      $ogv = isset($values['mb_ogv']) ? esc_attr($values['mb_ogv'][0]) : $ogv;
    }
  }
?>

<?php if (!empty($webm) || !empty($mp4) || !empty($ogv)) : ?>
  <section class="Video text-center">
    <video class="img-responsive" autoplay loop="true" poster="<?php echo $poster; ?>">
      <?php if (!empty($webm)) : ?>
        <source
          src="<?php echo $webm; ?>"
          type="video/webm">
      <?php endif; ?>

      <?php if (!empty($mp4)) : ?>
        <source
          src="<?php echo $mp4; ?>"
          type="video/mp4">
      <?php endif; ?>

      <?php if (!empty($ogv)) : ?>
        <source
          src="<?php echo $ogv; ?>"
          type="video/ogg">
      <?php endif; ?>
      Su navegador no admite etiquetas de video HTML5.
    </video>

    <?php /* if (count($dataMenuNext)) : ?>
      <a href="<?php echo $dataMenuNext['url']; ?>" class="right NavMenu">
        <?php echo $dataMenuNext['title']; ?>
        <i class="glyphicon glyphicon-chevron-right"></i>
      </a>
    <?php endif; */ ?>
  </section>
<?php else : ?>
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
          'terms' => 'nosotros'
        ]
      ]
    ];

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) :
      $i = 0;
  ?>
    <section id="carousel-about" class="carousel slide Carousel Carousel--home" data-ride="carousel">
      <div class="carousel-inner" role="listbox">
          <?php while ($the_query->have_posts()) : ?>
            <?php $the_query->the_post(); ?>

            <?php
              $values = get_post_custom(get_the_id());
              $title = isset($values['mb_title']) ? esc_attr($values['mb_title'][0]) : '';
              $subtitle = isset($values['mb_subtitle']) ? esc_attr($values['mb_subtitle'][0]) : '';
              // $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
              // $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
              // $target = (!empty($target) && $target === 'on') ? ' target="_blank" rel="noopener noreferrer"' : '';
            ?>

            <div class="item<?php echo ($i === 0) ? ' active' : ''; ?>">
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
            <?php $i++; ?>
          <?php endwhile; ?>
      </div>

      <button class="Arrow js-move-scroll" data-href="bertolt-brecht">ir abajo <i class="glyphicon glyphicon-chevron-down"></i></button>
    </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

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

    if ($mainQuery->have_posts()) {
      while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        global $post;
        $postName = $post->post_name;

        get_template_part('sections/section', $postName);
      }
    }

    wp_reset_query();
  ?>
<?php endif; ?>

<?php get_footer(); ?>
