<section class="Page" id="<?php echo basename(get_permalink()); ?>">
  <?php
    $idParent = get_the_id();
    $values = get_post_custom($idParent);
    $parallax = isset($values['mb_parallax']) ? esc_attr($values['mb_parallax'][0]) : '';
    $webm = isset($values['mb_webm']) ? esc_attr($values['mb_webm'][0]) : '';
    $mp4 = isset($values['mb_mp4']) ? esc_attr($values['mb_mp4'][0]) : '';
    $ogv = isset($values['mb_ogv']) ? esc_attr($values['mb_ogv'][0]) : '';
  ?>
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

        <?php if (!empty($webm) || !empty($mp4) || !empty($ogv)) : ?>
          <p>
            <a class="Button Button--red Button--icon" href="#" data-toggle="modal" data-target="#md-video-<?php echo $idParent; ?>"><i class="icon-play2"></i> ver video</a>
          </p>
        <?php endif; ?>

        <?php
          $arguments = [
            'post_type' => 'page',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_parent' => $idParent
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
  if (file_exists(TEMPLATEPATH . '/partials/parallax.php')) {
    include TEMPLATEPATH . '/partials/parallax.php';
  }
?>

<!-- Modal Video -->
<?php if (!empty($webm) || !empty($mp4) || !empty($ogv)) : ?>
  <div class="modal fade Modal Modal--video Modal--red" id="md-video-<?php echo $idParent; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <figure class="Page-video text-center">
            <!-- <video controls poster="<?php // echo IMAGES; ?>/video-about.jpg"> -->

            <video controls>
              <?php if (!empty($webm)) : ?>
                <source
                  src="<?php echo $webm; ?>"
                  type="video/webm">
              <?php endif; ?>

              <?php if (!empty($mp4)) : ?>
                <source
                  src="<?php echo $mp4; ?>"
                  type="video/mp4">
              <?php endif; ?>

              <?php if (!empty($ogv)) : ?>
                <source
                  src="<?php echo $ogv; ?>"
                  type="video/ogg">
              <?php endif; ?>
              Su navegador no admite etiquetas de video HTML5.
            </video>
          </figure>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
