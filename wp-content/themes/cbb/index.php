<?php get_header(); ?>

<?php
  if (file_exists(TEMPLATEPATH . '/partials/sliders.php')) {
    include TEMPLATEPATH . '/partials/sliders.php';
  }

  $homePage = get_page_by_title('Homepage');

  $args = [
    'post_type' => 'page',
    'post_parent' => $homePage->ID,
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
