<?php
    /**
     * Template Name: CBB Trabaja con Nosotros
     */
?>

<?php get_header(); ?>

<?php
    $options = get_option('cbb_custom_settings');

    $currentItem = get_queried_object_id();
    
    $previousNextItemMenu = getPreviousNextLinkItemMenu($currentItem, 'main-menu');
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
            'terms' => 'trabaja-con-nosotros',
            ]
        ]
    ];

  $the_query = new WP_Query($args);

  if ($the_query->have_posts()) :
    $i = 0; $j = 0;
?>
  <section id="carousel-workwithus" class="carousel slide Carousel Carousel--home" data-ride="carousel">
    <?php if ($the_query->post_count > 1) : ?>
      <ol class="carousel-indicators">
        <?php while ($the_query->have_posts()) : ?>
          <?php $the_query->the_post(); ?>
          <li data-target="#carousel-workwithus" data-slide-to="<?php echo $j; ?>"<?php echo ($j === 0) ? 'class="active"' : ''; ?>></li>
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
              <p><a class="Button Button--red" href="<?php echo $link; ?>"<?php echo $target; ?>><?php echo $text; ?></a></p>
            <?php endif; ?>
          </div>
        </div>
        <?php $i++; ?>
      <?php endwhile; ?>
    </div>

    <button class="Arrow js-move-scroll" data-href="content">ir abajo <i class="glyphicon glyphicon-chevron-down"></i></button>

    <?php if (is_object($previousNextItemMenu['prev'])) : ?>
      <?php $prev = $previousNextItemMenu['prev']; ?>
      <a href="<?php echo $prev->url; ?>" class="left NavMenu">
        <span><?php echo strtolower($prev->title); ?></span>
        <i class="glyphicon glyphicon-chevron-left"></i>
      </a>
    <?php endif; ?>

    <?php if (is_object($previousNextItemMenu['next'])) : ?>
      <?php $next = $previousNextItemMenu['next']; ?>
      <a href="<?php echo $next->url; ?>" class="right NavMenu">
        <span><?php echo strtolower($next->title); ?></span>
        <i class="glyphicon glyphicon-chevron-right"></i>
      </a>
    <?php endif; ?>
  </section>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php if (!empty($youtube)) : ?>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) :
            the_post();

            $filename = TEMPLATEPATH . '/partials/video.php';

            if (file_exists($filename)) {
                include $filename;
            }

            endwhile; ?>
    <?php endif; ?>
<?php endif; ?>

<section class="Page" id="content">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
            <h3 class="Page-title Page-title--nmb text-azul">Sé parte de nuestro staff de Profesores</h3>

            <h2 class="Page-title Page-title--nmb text-azul">Convocatoria de Docentes</h2>
      </div>
      <div class="col-md-6">
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Beatae culpa maiores eius sapiente adipisci nisi perspiciatis, mollitia temporibus sequi repellat veritatis ipsum quasi molestias alias soluta nostrum vitae accusamus voluptas.</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi quae expedita saepe neque vel accusantium non ipsa mollitia? Laboriosam, aliquid enim. Quia dignissimos exercitationem voluptatem qui quos suscipit alias minus.</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus voluptatem sapiente suscipit et quod ratione nostrum tempora blanditiis similique molestias, eligendi beatae! Fugiat expedita nemo maxime odio velit accusantium sed.</p>
      </div>
    </div>
  </div>
</section>

<?php /*
  $idParent = 0;
  $idParallax = !empty($options['blog_parallax']) ? (int)$options['blog_parallax'] : 0;
?>

<?php
  if (file_exists(TEMPLATEPATH . '/partials/parallax.php')) {
    include TEMPLATEPATH . '/partials/parallax.php';
  } */
?>

<?php get_footer(); ?>
