<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <section class="Page Page--experiences">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <h2 class="Page-title text-red"><?php the_title(); ?></h2>

            <?php the_content(); ?>

            <?php if (has_excerpt()) : ?>
              <p class="text-center">
                <a href="<?php _e(esc_url(get_the_excerpt())); ?>" class="Button Button--red" download>Descargar</a>
              </p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
