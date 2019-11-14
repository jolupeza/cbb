<?php
/**
 * Template Name: CBB Convocatorias
 */
?>
<?php get_header(); ?>

<?php
    $args = array(
        'hide_empty' => false
    );
    $levels = get_terms('joblevels', $args);
?>

<section class="App__Page">
    <div class="container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : ?>
                <?php the_post(); ?>

                <h2 class="Page-title text-celeste"><?php the_title(); ?></h2>

                <?php if (!empty($levels) && !is_wp_error($levels)) : ?>
                    <section class="App__CardsLevels">
                        <?php foreach ($levels as $level) : ?>
                            <?php $imageId = get_term_meta($level->term_id, 'joblevels-image-id', true); ?>
                            <article class="App__CardsLevels__item">
                                <?php if (!empty($imageId)) : ?>
                                    <figure class="App__CardsLevels__figure">
                                        <?php echo wp_get_attachment_image($imageId, 'large', false, array('class' => 'img-responsive')); ?>
                                        <aside class="App__CardsLevels__title"><?php esc_attr_e($level->name); ?></aside>
                                    </figure>
                                <?php endif; ?>
                                <div class="App__CardsLevels__info">
                                    <p><?php echo $level->description; ?></p>
                                    <div class="text-center">
                                        <a href="<?php echo esc_url(get_term_link($level)) ?>" class="btn Button Button--blue Button--medium">Postula aquí</a></div>
                                    </div>
                            </article>
                        <?php endforeach; ?>
                    </section>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
