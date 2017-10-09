<?php
  /*
    Template Name: CBB Propuesta Educativa
   */
?>
<?php get_header(); ?>

<?php
  $mainMenu = wp_get_nav_menu_object('main-menu');
  $menuItems = wp_get_nav_menu_items($mainMenu->term_id, [
    'post_parent' => 0
  ]);

  $keyCurrentItem = NULL;
  $prevMenuItem; $nextMenuItem;

  foreach ($menuItems as $key => $item) {
    if ((int)$item->object_id === get_queried_object_id()) {
      $keyCurrentItem = $key;
      break;
    }
  }

  if (!is_null($keyCurrentItem)) {
    $prevMenuItem = array_key_exists($keyCurrentItem - 1, $menuItems) ? $menuItems[$keyCurrentItem - 1] : null;
    $nextMenuItem = array_key_exists($keyCurrentItem + 1, $menuItems) ? $menuItems[$keyCurrentItem + 1] : null;
  }
?>

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
      $youtube = isset($values['mb_youtube']) ? esc_attr($values['mb_youtube'][0]) : '';
    }
  }
?>

<?php if (!empty($webm) || !empty($mp4) || !empty($ogv)) : ?>
  <section class="Video text-center">
    <video class="img-responsive" autoplay="true" loop="true" poster="<?php echo $poster; ?>">
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

    <?php if (is_object($prevMenuItem)) : ?>
      <a href="<?php echo $prevMenuItem->url; ?>" class="left NavMenu">
        <span><?php echo strtolower($prevMenuItem->title); ?></span>
        <i class="glyphicon glyphicon-chevron-left"></i>
      </a>
    <?php endif; ?>

    <?php if (is_object($nextMenuItem)) : ?>
      <a href="<?php echo $nextMenuItem->url; ?>" class="right NavMenu">
        <span><?php echo strtolower($nextMenuItem->title); ?></span>
        <i class="glyphicon glyphicon-chevron-right"></i>
      </a>
    <?php endif; ?>
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
          'terms' => 'propuesta-educativa'
        ]
      ]
    ];

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) :
      $i = 0; $j = 0;
  ?>
      <section id="carousel-propuesta" class="carousel slide Carousel Carousel--home" data-ride="carousel">
        <?php if ($the_query->post_count > 1) : ?>
          <ol class="carousel-indicators">
            <?php while ($the_query->have_posts()) : ?>
              <?php $the_query->the_post(); ?>
              <li data-target="#carousel-home" data-slide-to="<?php echo $j; ?>"<?php echo ($j === 0) ? 'class="active"' : ''; ?>></li>
              <?php $j++ ?>
            <?php endwhile; ?>
          </ol>
        <?php endif; ?>

        <div class="carousel-inner" role="listbox">
          <?php while ($the_query->have_posts()) : ?>
            <?php $the_query->the_post(); ?>

            <?php
              $values = get_post_custom(get_the_id());
              $title = isset($values['mb_title']) ? esc_attr($values['mb_title'][0]) : '';
              $subtitle = isset($values['mb_subtitle']) ? esc_attr($values['mb_subtitle'][0]) : '';
              $text = isset($values['mb_text']) ? esc_attr($values['mb_text'][0]) : '';
              $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
              $pageLink = isset($values['mb_page']) ? (int)esc_attr($values['mb_page'][0]) : 0;
              $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
              $target = (!empty($target) && $target === 'on') ? ' target="_blank" rel="noopener noreferrer"' : '';
              $align = isset($values['mb_align']) ? esc_attr($values['mb_align'][0]) : 'left';
              $responsive = isset($values['mb_responsive']) ? esc_attr($values['mb_responsive'][0]) : '';
            ?>

            <div class="item<?php echo ($i === 0) ? ' active' : ''; ?>">
              <?php if (has_post_thumbnail()) : ?>
                <picture>
                  <source class="img-responsive center-block" media="(max-width: 767px) and (orientation: portrait)" srcset="<?php echo $responsive; ?>" alt="<?php echo get_the_title(); ?>" />
                  <?php the_post_thumbnail('full', [
                      'class' => 'img-responsive center-block',
                      'alt' => get_the_title()
                    ]);
                  ?>
                </picture>
              <?php endif; ?>

              <div class="carousel-caption carousel-caption--<?php echo $align; ?>">
                <?php if (!empty($subtitle)) : ?><h3><?php echo $subtitle; ?></h3><?php endif; ?>
                <?php if (!empty($title)) : ?><h2><?php echo $title; ?></h2><?php endif; ?>
                <?php the_content(); ?>

                <?php if (!empty($url) || $pageLink > 0) : ?>
                  <?php $link = ($pageLink > 0) ? get_page_link($pageLink) : $url; ?>
                  <p>
                    <a class="Button Button--red" href="<?php echo $link; ?>"<?php echo $target; ?>><?php echo $text; ?></a>
                  </p>
                <?php endif; ?>
              </div>
            </div>
            <?php $i++; ?>
          <?php endwhile; ?>
        </div>

        <button class="Arrow js-move-scroll" data-href="educacion-inicial">ir abajo <i class="glyphicon glyphicon-chevron-down"></i></button>

        <?php if (is_object($prevMenuItem)) : ?>
          <a href="<?php echo $prevMenuItem->url; ?>" class="left NavMenu">
            <span><?php echo strtolower($prevMenuItem->title); ?></span>
            <i class="glyphicon glyphicon-chevron-left"></i>
          </a>
        <?php endif; ?>

        <?php if (is_object($nextMenuItem)) : ?>
          <a href="<?php echo $nextMenuItem->url; ?>" class="right NavMenu">
            <span><?php echo strtolower($nextMenuItem->title); ?></span>
            <i class="glyphicon glyphicon-chevron-right"></i>
          </a>
        <?php endif; ?>
      </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php if (!empty($youtube)) : ?>
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : ?>
      <?php the_post(); ?>

      <?php
        $filename = TEMPLATEPATH . '/partials/video.php';

        if (file_exists($filename)) {
          include $filename;
        }
      ?>
    <?php endwhile; ?>
  <?php endif; ?>
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
  ?>

  <?php global $post; ?>
  <?php if ($mainQuery->have_posts()) : ?>
    <?php
      while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

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
