<?php $options = get_option('cbb_custom_settings'); ?>

<?php
  $poster = isset($options['home_video_img']) ? $options['home_video_img'] : '';
  $webm = isset($options['home_video_webm']) ? $options['home_video_webm'] : '';
  $mp4 = isset($options['home_video_mp4']) ? $options['home_video_mp4'] : '';
  $ogv = isset($options['home_video_ogv']) ? $options['home_video_ogv'] : '';
?>

<?php
  $mainMenu = wp_get_nav_menu_object('main-menu');
  $menuItems = wp_get_nav_menu_items($mainMenu->term_id);
  $menuItem = $menuItems[1];
  $dataMenuNext = [];

  if (is_object($menuItem)) {
    $dataMenuNext['title'] = strtolower($menuItem->title);
    $dataMenuNext['url'] = $menuItem->url;
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

    <?php if (count($dataMenuNext)) : ?>
      <a href="<?php echo $dataMenuNext['url']; ?>" class="right NavMenu">
        <span><?php echo strtolower($dataMenuNext['title']); ?></span>
        <i class="glyphicon glyphicon-chevron-right"></i>
      </a>
    <?php endif; ?>
  </section>
<?php else : ?>
  <?php
    $args = array(
      'post_type' => 'sliders',
      'posts_per_page' => -1,
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'tax_query' => [
        [
          'taxonomy' => 'sections',
          'field' => 'slug',
          'terms' => 'inicio'
        ]
      ]
    );

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) :
      $i = 0; $j = 0;
  ?>
    <section id="carousel-home" class="carousel slide Carousel Carousel--home" data-ride="carousel">
      <?php if ($the_query->post_count > 1) : ?>
        <ol class="carousel-indicators">
          <?php while ($the_query->have_posts()) : ?>
            <?php $the_query->the_post(); ?>
            <li data-target="#carousel-home" data-slide-to="<?php echo $i; ?>"<?php echo ($i === 0) ? 'class="active"' : ''; ?>></li>
            <?php $i++ ?>
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
          ?>

          <div class="item<?php echo ($j === 0) ? ' active' : ''; ?>">
            <?php if (has_post_thumbnail()) : ?>
              <?php
                the_post_thumbnail('full', [
                  'class' => 'img-responsive center-block',
                  'alt' => get_the_title()
                ]);
              ?>
            <?php endif; ?>

            <div class="carousel-caption carousel-caption--<?php echo $align; ?>">
              <?php if (!empty($subtitle)) : ?><h3><?php echo $subtitle; ?></h3><?php endif; ?>
              <?php if (!empty($title)) : ?><h2><?php echo $title ?></h2><?php endif; ?>
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

      <!-- <a class="left carousel-control" href="#carousel-home" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-home" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a> -->

      <button class="Arrow js-move-scroll" data-href="por-que-elegir-bertolt-brecht">ir abajo <i class="glyphicon glyphicon-chevron-down"></i></button>

      <?php if (count($dataMenuNext)) : ?>
        <a href="<?php echo $dataMenuNext['url']; ?>" class="right NavMenu">
          <span><?php echo strtolower($dataMenuNext['title']); ?></span>
          <i class="glyphicon glyphicon-chevron-right"></i>
        </a>
      <?php endif; ?>
    </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
