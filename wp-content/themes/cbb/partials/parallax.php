<?php
  $values = get_post_custom($idParent);
  $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';

  if (!empty($parallax)) :
    $arguments = [
      'post_type' => 'parallaxs',
      'p' => (int)$parallax
    ];

    $parallaxData = new WP_Query($arguments);
    if ($parallaxData->have_posts()) :
      while ($parallaxData->have_posts()) :
        $parallaxData->the_post();

        $val = get_post_custom(get_the_id());
        $alignTitle = isset($val['mb_alignTitle']) ? esc_attr($val['mb_alignTitle'][0]) : 'left';
        $align = isset($val['mb_align']) ? esc_attr($val['mb_align'][0]) : 'left';
        $animate = isset($val['mb_animate']) ? esc_attr($val['mb_animate'][0]) : 'fadeInLeft';
        $title = isset($val['mb_title']) ? esc_attr($val['mb_title'][0]) : '';
        $legend = isset($val['mb_legend']) ? esc_attr($val['mb_legend'][0]) : '';
        $backgroundUrl = wp_get_attachment_url(get_post_thumbnail_id(get_the_id()));

        $text = isset($val['mb_text']) ? esc_attr($val['mb_text'][0]) : '';
        $url = isset($val['mb_url']) ? esc_attr($val['mb_url'][0]) : '';
        $pageLink = isset($val['mb_page']) ? (int)esc_attr($val['mb_page'][0]) : 0;
        $target = isset($val['mb_target']) ? esc_attr($val['mb_target'][0]) : '';
        $target = (!empty($target) && $target === 'on') ? ' target="_blank" rel="noopener noreferrer"' : '';
?>
  <section class="Parallax" style="background-image: url('<?php echo $backgroundUrl; ?>');">
    <article class="animation-element Parallax-caption Parallax-caption--<?php echo $align; ?> animated" data-animation="<?php echo $animate; ?>">
      <h2 class="Parallax-caption-title text-<?php echo $alignTitle; ?>"><?php echo $title; ?></h2>
      <?php the_content(); ?>
      <?php if (!empty($legend)) : ?><h4 class="Parallax-caption-author text-right"><?php echo $legend; ?></h4><?php endif; ?>

      <?php if (!empty($url) || $pageLink > 0) : ?>
        <?php $link = ($pageLink > 0) ? get_page_link($pageLink) : $url; ?>
        <p class="text-<?php echo $alignTitle; ?>">
          <a class="Button Button--medium Button--red" href="<?php echo $link; ?>"<?php echo $target; ?>><?php echo $text; ?></a>
        </p>
      <?php endif; ?>
    </article>
  </section>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
