<?php get_header(); ?>

<?php
  $mainMenu = wp_get_nav_menu_object('main-menu');
  $menuItems = wp_get_nav_menu_items($mainMenu->term_id, [
    'post_parent' => 0
  ]);

  $keyCurrentItem = NULL;
  $prevMenuItem; $nextMenuItem;

  foreach ($menuItems as $key => $item) {
    if ($item->object === 'category') {
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
  $args = [
    'post_type' => 'sliders',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'tax_query' => [
      [
        'taxonomy' => 'sections',
        'field' => 'slug',
        'terms' => 'vida-escolar'
      ]
    ]
  ];

  $the_query = new WP_Query($args);

  if ($the_query->have_posts()) :
    $i = 0; $j = 0;
?>
  <section id="blog-body" class="carousel slide Carousel Carousel--home" data-ride="carousel">
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
          <div class="carousel-caption carousel-caption--<?php echo $align; ?>">
            <?php if (!empty($subtitle)) : ?><h3><?php echo $subtitle; ?></h3><?php endif; ?>
            <?php if (!empty($title)) : ?><h2><?php echo $title; ?></h2><?php endif; ?>
            <?php the_content(); ?>

            <?php if (!empty($url) || $pageLink > 0) : ?>
              <?php $link = ($pageLink > 0) ? get_page_link($pageLink) : $url; ?>
              <p><a class="Button Button--red" href="<?php echo $link; ?>"<?php echo $target; ?>><?php echo $text; ?></a></p>
            <?php endif; ?>
          </div>
        </div>
        <?php $i++; ?>
      <?php endwhile; ?>
    </div>

    <!-- <a class="left carousel-control" href="#blog-body" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#blog-body" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a> -->

    <button class="Arrow js-move-scroll" data-href="js-page">ir abajo <i class="glyphicon glyphicon-chevron-down"></i></button>

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
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

<section class="Page" id="js-page">
  <div class="container">
    <?php
      $args = [
        'theme_location' => 'categories-zone-menu',
        'container' => 'nav',
        'container_class' => 'MenuZone',
        'menu_class' => 'MenuZone-list'
      ];

      wp_nav_menu($args);
    ?>

    <div class="row">
      <div class="col-md-6">
        <h2 class="Page-title Page-title--nmb text-azul">Resultados de su búsqueda:</h2>
        <h3 class="Page-subtitle text-gray">"<?php echo get_search_query(); ?>"</h3>
      </div>
      <div class="col-md-3 col-md-offset-3">
        <?php get_sidebar('main-sidebar'); ?>
      </div>
    </div>

    <?php if (have_posts()) : ?>
      <section class="grid Box">
        <!-- <div class="grid-sizer"></div> -->
        <?php while (have_posts()) : ?>
          <?php the_post(); ?>
          <?php $thumb = false; ?>
          <article class="grid-item Box-item">
            <?php if (has_post_thumbnail()) : ?>
              <figure class="Box-figure Box-figure--red">
                <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>
              </figure>
              <?php $thumb = true; ?>
            <?php endif; ?>

            <article class="Box-content<?php echo !$thumb ? ' Box-content--green' : ''; ?>">
              <h3 class="Box-title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <?php the_content(' '); ?>
              <p class="text-center">
                <a href="<?php the_permalink(); ?>" class="Button Button--small Button--yellow">Leer más</a>
              </p>
            </article>
          </article>
        <?php endwhile; ?>
      </section>

      <!-- <p class="text-center">
        <a href="" class="Button Button--blue Button--medium">ver más</a>
      </p> -->
    <?php endif; ?>

    <div class="article-nav">

      <p class="article-nav-next"><?php previous_posts_link(__('&laquo; Entradas recientes ', THEMEDOMAIN)); ?></p>
      <p class="article-nav-prev"><?php next_posts_link(__('Entradas anteriores &raquo;', THEMEDOMAIN)); ?></p>

    </div> <!-- end clearfix -->
  </div>
</section>

<?php get_footer(); ?>
