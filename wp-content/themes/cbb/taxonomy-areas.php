<?php get_header(); ?>

<section id="blog-body" class="carousel slide Carousel Carousel--home">
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="<?php echo IMAGES; ?>/slide-blog.jpg" alt="Slide Vida Escolar" />
      <div class="carousel-caption carousel-caption--right">
        <h3>aprendes más</h3>
        <h2>estando feliz</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae natus deserunt perspiciatis possimus.</p>
        <p><a class="Button Button--red" href="">conocer más</a></p>
      </div>
    </div>
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
</section>

<section class="Page" id="js-page">
  <div class="container">
    <?php if (have_posts()) : ?>
      <?php
        $args = [
          'theme_location' => 'areas-menu',
          'container' => 'nav',
          'container_class' => 'MenuZone',
          'menu_class' => 'MenuZone-list'
        ];

        wp_nav_menu($args);
      ?>

      <?php
        $menuName = 'categories-menu';
        $menuItems = [];

        if (($locations = get_nav_menu_locations()) && isset($locations[$menuName])) {
          $menu = wp_get_nav_menu_object($locations[$menuName]);

          $menuItems = wp_get_nav_menu_items($menu->term_id);
        }
      ?>
      <nav class="MenuCategories">
        <ul class="MenuCategories-list">
          <li class="active"><a href="" data-filter="*">Destacados</a></li>
          <?php if (count($menuItems)) : ?>
            <?php foreach ($menuItems as $item) : ?>
              <li><a href="" data-filter=".<?php echo sanitize_title($item->title); ?>"><?php echo $item->title; ?></a></li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </nav>

      <div class="row">
        <div class="col-md-6">
          <h2 class="Page-title Page-title--nmb text-azul">Lo más reciente</h2>
          <p class="text-resalt text-gray">Entérate de nuestras actividades y más</p>
        </div>
        <div class="col-md-3 col-md-offset-3">
          <form class="Form Form--group Form--search">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Buscar">
              <span class="input-group-btn">
                <button class="btn" type="submit"><i class="icon-search"></i></button>
              </span>
            </div><!-- /input-group -->
          </form>
        </div>
      </div>

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
  </div>
</section>

<?php get_footer(); ?>
