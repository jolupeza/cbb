<?php
  /*
    Template Name: CBB Propuesta Educativa
   */
?>
<?php get_header(); ?>

<?php $idPage = 0; ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <?php $idPage = get_the_id(); ?>
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

      <button class="Arrow js-move-scroll" href="">ir abajo <i class="glyphicon glyphicon-chevron-down"></i></button>
    </section>
  <?php endwhile; ?>
<?php endif; ?>

<?php if ($idPage) : ?>
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
