<?php get_header(); ?>

<section class="Page">
  <div class="container">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : ?>
        <?php the_post(); ?>

        <h2 class="Page-title text-celeste"><?php the_title(); ?> <?php if (has_excerpt()) : echo get_the_excerpt(); endif; ?></h2>

        <?php the_content(); ?>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
