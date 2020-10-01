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
  $titleMainColor = !empty($values['mb_title_main_color']) ? esc_attr($values['mb_title_main_color'][0]) : 'red';
  $buttonAlign = !empty($values['mb_button_align']) ? esc_attr($values['mb_button_align'][0]) : 'center';
  $buttonSize = !empty($values['mb_button_size']) ? esc_attr($values['mb_button_size'][0]) : 'small';
  $buttonColor = !empty($values['mb_button_color']) ? esc_attr($values['mb_button_color'][0]) : 'red';
  $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
  $pageLink = isset($values['mb_page']) ? (int)esc_attr($values['mb_page'][0]) : 0;
  $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
  $target = (!empty($target) && $target === 'on') ? ' target="_blank" rel="noopener noreferrer"' : '';
  $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';

  $classButtonSize = $buttonSize !== 'big' ? ' Button--' . $buttonSize : '';
  $classButtonColor = ' Button--' . $buttonColor;
  $classTitleMainColor = ' text-' . $titleMainColor;
?>

<section class="Page Page--generic Page--pb" id="<?php echo $postName; ?>">
  <div class="container">
    <section class="Page-wrapper">
      <article class="Page-wrapper-item">
        <h2 class="Page-title<?php echo $classTitleMainColor; ?>"><?php the_title(); ?></h2>
        <?php the_content(); ?>
        <?php if (!empty($url) || $pageLink > 0) : ?>
          <?php $link = ($pageLink > 0) ? get_page_link($pageLink) : $url; ?>
          <p class="text-<?php echo $buttonAlign; ?>">
            <a class="Button<?php echo $classButtonColor; ?><?php echo $classButtonSize; ?>" href="<?php echo $link; ?>"<?php echo $target; ?>><?php echo $text; ?></a>
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
