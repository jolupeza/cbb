<?php get_header(); ?>

<?php
  $homePage = get_page_by_title('Homepage');
  $idPage = $homePage->ID;
?>

<?php
  if (file_exists(TEMPLATEPATH . '/partials/sliders.php')) {
    include TEMPLATEPATH . '/partials/sliders.php';
  }

  $values = get_post_custom($idPage);
  $youtube = isset($values['mb_youtube']) ? esc_attr($values['mb_youtube'][0]) : '';
?>

<?php if (!empty($youtube)) : ?>
  <section class="Page">
    <div class="container">
      <?php if (has_excerpt($idPage)) : ?>
        <h2 class="Page-title text-center text-azul"><?php echo get_the_excerpt($idPage); ?></h2>
      <?php endif; ?>

      <?php echo $homePage->post_content; ?>

      <figure class="Page-youtube text-center">
        <div class="Single-video" id="player<?php echo $idPage; ?>"></div>

        <script>
          var height = '360',
              width = '640';  // 854x480

          if (window.innerWidth < 768) {
            height = '240';
            width = '426';
          }

          if (window.innerWidth < 450) {
            height = '240';
            width = '320';
          }

          playerInfoList.push({
            id: '<?php echo $idPage; ?>',
            idPlayer: 'player<?php echo $idPage; ?>',
            height: height,
            width: width,
            videoId: '<?php echo $youtube; ?>'
          });
        </script>
      </figure>
    </div>
  </section>
<?php endif; ?>

<?php
  $args = [
    'post_type' => 'page',
    'post_parent' => $idPage,
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
