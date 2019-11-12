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

    $term = 'trabaja-con-nosotros';
?>

<?php
  $idPage = 0;
  $idParent = 0;
  $poster = '';
  $webm = '';
  $mp4 = '';
  $ogv = '';

  if (have_posts()) {
    while (have_posts()) {
      the_post();
      $idPage = get_the_id();
      $idParent = get_the_id();

      $values = get_post_custom($idPage);
      $poster = isset($values['mb_poster']) ? esc_attr($values['mb_poster'][0]) : $poster;
      $webm = isset($values['mb_webm']) ? esc_attr($values['mb_webm'][0]) : $webm;
      $mp4 = isset($values['mb_mp4']) ? esc_attr($values['mb_mp4'][0]) : $mp4;
      $ogv = isset($values['mb_ogv']) ? esc_attr($values['mb_ogv'][0]) : $ogv;
      $youtube = isset($values['mb_youtube']) ? esc_attr($values['mb_youtube'][0]) : '';
    }
  }
?>

<?php
    if (file_exists(TEMPLATEPATH . '/partials/main-slider.php')) {
        include TEMPLATEPATH . '/partials/main-slider.php';
    }
?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>

        <?php if (!empty($youtube)) : ?>

            <?php 
                $filename = TEMPLATEPATH . '/partials/video.php';

                if (file_exists($filename)) {
                    include $filename;
                }
            ?>

        <?php endif; ?>

        <section class="Page" id="content">
            <div class="container">
                <div class="row">
                <div class="col-md-6">
                    <h3 class="Page-subtitle Page-title--nmb text-azul">Sé parte de nuestro staff de Profesores</h3>

                    <h2 class="Page-title Page-title--nmb text-red">Convocatoria de Docentes</h2>
                </div>
                <div class="col-md-6">
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Beatae culpa maiores eius sapiente adipisci nisi perspiciatis, mollitia temporibus sequi repellat veritatis ipsum quasi molestias alias soluta nostrum vitae accusamus voluptas.</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi quae expedita saepe neque vel accusantium non ipsa mollitia? Laboriosam, aliquid enim. Quia dignissimos exercitationem voluptatem qui quos suscipit alias minus.</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus voluptatem sapiente suscipit et quod ratione nostrum tempora blanditiis similique molestias, eligendi beatae! Fugiat expedita nemo maxime odio velit accusantium sed.</p>
                </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>
<?php endif; ?>

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
