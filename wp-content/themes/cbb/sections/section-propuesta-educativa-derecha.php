<section class="Page" id="<?php echo basename(get_permalink()); ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <?php if (has_post_thumbnail()) : ?>
          <figure class="Page-figure">
            <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block', 'alt' => get_the_title()]); ?>
          </figure>
        <?php endif; ?>
      </div>

      <div class="col-md-6">
        <h3 class="Page-subtitle text-gray">nivel</h3>
        <h2 class="Page-title text-red"><?php the_title(); ?></h2>
        <?php the_content(); ?>
        <p><a class="Button Button--red Button--icon" href=""><i class="icon-play2"></i> ver video</a></p>

        <?php
          $pageParent = get_the_id();

          $arguments = [
            'post_type' => 'page',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_parent' => $pageParent
          ];

          $pageChilds = new WP_Query($arguments);

          if ($pageChilds->have_posts()) :
        ?>
          <section class="Page-table Page-table--blue">
            <?php while ($pageChilds->have_posts()) : ?>
              <?php $pageChilds->the_post(); ?>
              <?php
                $values = get_post_custom(get_the_id());
                $icon = isset($values['mb_icon']) ? esc_attr($values['mb_icon'][0]) : '';
              ?>
              <article class="Page-cel">
                <?php if (!empty($icon)) : ?>
                  <i class="<?php echo $icon; ?>"></i>
                <?php endif; ?>
                <h3 class="Page-cel-title"><?php the_title(); ?></h3>
                <?php the_content(); ?>
              </article>
            <?php endwhile; ?>
          </section>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    </div>
  </div>
</section>

<?php
  $values = get_post_custom($pageParent);
  $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';
?>

<?php if (!empty($parallax)) : ?>
  <?php
    $arguments = [
      'post_type' => 'parallaxs',
      'p' => (int)$parallax
    ];

    $parallaxData = new WP_Query($arguments);

    if ($parallaxData->have_posts()) :
      while ($parallaxData->have_posts()) :
        $parallaxData->the_post();

        $val = get_post_custom(get_the_id());
        $title = isset($val['mb_title']) ? esc_attr($val['mb_title'][0]) : '';
        $backgroundUrl = wp_get_attachment_url(get_post_thumbnail_id(get_the_id()));
  ?>
    <section class="Parallax" style="background-image: url('<?php echo $backgroundUrl; ?>');">
      <article class="Parallax-caption Parallax-caption--left animation-element animated" data-animation="fadeInLeft">
        <h2 class="Parallax-caption-title text-left"><?php the_title(); ?></h2>
        <?php the_content(); ?>
      </article>
    </section>
    <?php endwhile; ?>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>
