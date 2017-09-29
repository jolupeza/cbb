<?php
  /**
   *  Template Name: CBB Plantilla Genérica
   */
?>
<?php
  if (isset($isChildTemplate) && !$isChildTemplate) {
    get_header();
  }
?>

<?php
  $idParent = get_the_id();
  $values = get_post_custom($idParent);
  $text = isset($values['mb_text']) ? esc_attr($values['mb_text'][0]) : '';
  $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
  $pageLink = isset($values['mb_page']) ? (int)esc_attr($values['mb_page'][0]) : 0;
  $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
  $target = (!empty($target) && $target === 'on') ? ' target="_blank" rel="noopener noreferrer"' : '';
  $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';
?>

<section class="Page Page--pb" id="<?php echo $postName; ?>">
  <div class="container">
    <section class="Page-wrapper">
      <article class="Page-wrapper-item">
        <h2 class="Page-title text-red"><?php the_title(); ?></h2>
        <?php the_content(); ?>
        <?php if (!empty($url) || $pageLink > 0) : ?>
          <?php $link = ($pageLink > 0) ? get_page_link($pageLink) : $url; ?>
          <p class="text-center">
            <a class="Button Button--red Button--small" href="<?php echo $link; ?>"<?php echo $target; ?>><?php echo $text; ?></a>
          </p>
        <?php endif; ?>
      </article>
      <article class="Page-wrapper-item">
        <?php if (has_post_thumbnail()) : ?>
          <figure class="Page-figure">
            <?php the_post_thumbnail('full', [
                'class' => 'img-responsive center-block',
                'alt' => get_the_title()
              ]);
            ?>
          </figure>
        <?php endif; ?>
      </article>
    </section>
  </div>
</section>

<?php if (file_exists(TEMPLATEPATH . '/partials/parallax.php')) {
    include TEMPLATEPATH . '/partials/parallax.php';
  }
?>

<?php
  if (isset($isChildTemplate) && !$isChildTemplate) {
    get_footer();
  }
?>
