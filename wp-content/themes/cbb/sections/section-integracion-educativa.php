<?php
  $parentPage = get_the_id();

  $args = [
    'post_type' => 'page',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'post_parent' => $parentPage
  ];
  $childs = new WP_query($args);

  if ($childs->have_posts()) :
    $i = 0; $j = 0;
?>
  <section id="carouse-integracion" class="Page Page--noPaddingTop Page--redSoft carousel slide Carousel Carousel--page" data-ride="carousel">
    <?php if ($childs->post_count > 1) : ?>
      <ol class="carousel-indicators">
        <?php while ($childs->have_posts()) : ?>
          <?php $childs->the_post(); ?>
          <li data-target="#carouse-integracion" data-slide-to="<?php echo $i; ?>"<?php echo ($i === 0) ? ' class="active"' : ''; ?>></li>
          <?php $i++; ?>
        <?php endwhile; ?>
      </ol>
    <?php endif; ?>

    <div class="carousel-inner" role="listbox">
      <?php while ($childs->have_posts()) : ?>
        <?php $childs->the_post(); ?>
        <div class="item<?php echo ($j === 0) ? ' active' : ''; ?>">
          <article class="carousel-content">
            <?php if (has_post_thumbnail()) : ?>
              <figure class="carousel-figure">
                <?php the_post_thumbnail('full', ['class' => 'img-responsive', 'alt' => get_the_title()]); ?>
              </figure>
            <?php endif; ?>
            <div class="carousel-caption">
              <h3><?php the_title(); ?></h3>
              <?php the_content(); ?>
            </div>
          </article>
        </div>
        <?php $j++; ?>
      <?php endwhile; ?>
    </div>
  </section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
