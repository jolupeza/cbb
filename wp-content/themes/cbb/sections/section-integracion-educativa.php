<section id="<?php echo $post->post_name; ?>" class="Page Page--redSoft carousel slide Carousel Carousel--page" data-ride="carousel">
  <!-- <ol class="carousel-indicators">
    <li data-target="#<?php echo $post->post_name; ?>" data-slide-to="0" class="active"></li>
    <li data-target="#<?php echo $post->post_name; ?>" data-slide-to="1"></li>
  </ol> -->

  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <article class="carousel-content">
        <?php if (has_post_thumbnail()) : ?>
          <figure class="carousel-figure">
            <?php the_post_thumbnail('full', ['class' => 'img-responsive', 'alt' => get_the_title()]); ?>
          </figure>
        <?php endif; ?>
        <div class="carousel-caption">
          <h3><?php the_title(); ?></h3>
          <?php the_content(); ?>
        </div>
      </article>
    </div>
  </div>
</section>
