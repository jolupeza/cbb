<?php get_header(); ?>

<?php
  $mainMenu = wp_get_nav_menu_object('main-menu');
  $menuItems = wp_get_nav_menu_items($mainMenu->term_id, [
    'post_parent' => 0
  ]);

  $keyCurrentItem = NULL;
  $prevMenuItem; $nextMenuItem;

  foreach ($menuItems as $key => $item) {
    if ($item->object === 'locals') {
      $keyCurrentItem = $key;
      break;
    }
  }

  if (!is_null($keyCurrentItem)) {
    $prevMenuItem = array_key_exists($keyCurrentItem - 1, $menuItems) ? $menuItems[$keyCurrentItem - 1] : null;
    $nextMenuItem = array_key_exists($keyCurrentItem + 1, $menuItems) ? $menuItems[$keyCurrentItem + 1] : null;
  }
?>

<?php $options = get_option('cbb_custom_settings'); ?>
<?php
  $poster = isset($options['infraestructura_video_img']) ? $options['infraestructura_video_img'] : '';
  $webm = isset($options['infraestructura_video_webm']) ? $options['infraestructura_video_webm'] : '';
  $mp4 = isset($options['infraestructura_video_mp4']) ? $options['infraestructura_video_mp4'] : '';
  $ogv = isset($options['infraestructura_video_ogv']) ? $options['infraestructura_video_ogv'] : '';
  $desc = isset($options['infraestructura_desc']) ? $options['infraestructura_desc'] : '';
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
        <?php if ($sliders->post_count > 1) : ?>
          <ol class="carousel-indicators">
            <?php while ($sliders->have_posts()) : ?>
              <?php $sliders->the_post(); ?>
              <li data-target="#carousel-home" data-slide-to="<?php echo $j; ?>"<?php echo ($j === 0) ? 'class="active"' : ''; ?>></li>
              <?php $j++ ?>
            <?php endwhile; ?>
          </ol>
        <?php endif; ?>

        <div class="carousel-inner" role="listbox">
          <?php while ($sliders->have_posts()) : ?>
            <?php $sliders->the_post(); ?>

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
            <?php $j++; ?>
          <?php endwhile; ?>
        </div>

        <button class="Arrow js-move-scroll" href="locals">ir abajo <i class="glyphicon glyphicon-chevron-down"></i></button>

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
<?php endif; ?>

<?php
  $idSede = 0;

  if (have_posts()) {
    while (have_posts()){
      the_post();
      $idSede = get_the_id();
?>
  <?php if (!empty($desc)) : ?>
  <section class="Page" id="locals">
    <div class="container">
      <p><?php echo $desc; ?></p>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($idSede > 0) : ?>
    <section class="Page">
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

        <?php the_content(); ?>

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
<?php
    }
  }
?>

<?php get_footer(); ?>
