<?php
  /*
    Template Name: CBB Nosotros
   */
?>
<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <section class="carousel slide Carousel Carousel--home">
      <div class="carousel-inner">
        <?php if (has_post_thumbnail()) : ?>
          <div class="item active">
            <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block', 'alt' => get_the_title()]); ?>
            <div class="carousel-caption">
              <?php the_content(); ?>
              <p><a class="Button Button--red" href="">conocer más</a></p>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <button class="Arrow js-move-scroll" data-href="bertolt-brecht">ir abajo <i class="glyphicon glyphicon-chevron-down"></i></button>
    </section>
  <?php endwhile; ?>
<?php endif; ?>

<?php
  $aboutPage = get_page_by_title('Nosotros');

  $args = [
    'post_type' => 'page',
    'post_parent' => $aboutPage->ID,
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

<?php get_footer(); ?>
