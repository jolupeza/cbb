<section class="PageHome" id="<?php echo $post->post_name; ?>">
  <?php
    $title = get_the_excerpt();
    $titleArr = explode('/', $title);
    $idParent = get_the_id();
  ?>
  <div class="container">
    <h3 class="PageHome-subtitle text-center"><?php echo $titleArr[0]; ?></h3>
    <h2 class="PageHome-title text-center"><?php echo $titleArr[1]; ?></h2>

    <p class="text-center PageHome-legend"><?php echo get_the_content(); ?></p>
    <p class="text-center"><a class="Button Button--blue" href="<?php echo home_url('infraestructura'); ?>">ver ambientes</a></p>
  </div>
  <?php if (has_post_thumbnail()) : ?>
    <figure class="PageHome-figure">
      <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block', 'alt' => get_the_title()]); ?>
    </figure>
  <?php endif; ?>
</section>

<?php
  if (file_exists(TEMPLATEPATH . '/partials/parallax.php')) {
    include TEMPLATEPATH . '/partials/parallax.php';
  }
