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

        <?php
            $values = get_post_custom($idPage);
            $textMain = !empty($values['mb_title']) ? esc_attr($values['mb_title'][0]) : '';
            $textSecond = !empty($values['mb_subtitle']) ? esc_attr($values['mb_subtitle'][0]) : '';
            $textButton = !empty($values['mb_text']) ? esc_attr($values['mb_text'][0]) : '';
            $textUrl = !empty($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
            $target = !empty($values['mb_target']) && $values['mb_target'][0] === 'on' ? true : false;
            $pageLink = !empty($values['mb_page']) ? esc_attr($values['mb_page'][0]) : null;

            $linkButton = !is_null($pageLink) ? get_the_permalink($pageLink) : esc_url($textUrl);
        ?>

        <section class="App__Page" id="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <?php if (!empty($textSecond)) : ?>
                            <h3 class="App__Page__subtitle App__secondColorAlt App__fontItalic"><?php _e($textSecond, THEMEDOMAIN); ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($textMain)) : ?>
                            <h2 class="App__Page__title App__firstColorAlt"><?php _e($textMain, THEMEDOMAIN); ?></h2>
                        <?php endif; ?>

                        <?php if (!empty($textButton) && !empty($linkButton)) : ?>
                            <div>
                                <a href="<?php echo $linkButton ?>" class="btn Button Button--blue Button--medium text-uppercase"<?php echo $target ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?php _e($textButton, THEMEDOMAIN); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <article class="App__Page__content">
                            <?php the_content(); ?>
                        </article>
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
