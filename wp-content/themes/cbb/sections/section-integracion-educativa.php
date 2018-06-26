<?php
  $parentPage = get_the_id();

  $args = [
    'post_type' => 'page',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'post_parent' => $parentPage
  ];
  $childs = new WP_query($args);

  if ($childs->have_posts()) :
    $i = 0; $j = 0;

    $idCarousel = basename(get_permalink());
?>
  <section id="<?php echo $idCarousel; ?>" class="Page Page--noPaddingTop carousel slide Carousel Carousel--page" data-ride="carousel">
    <?php if ($childs->post_count > 1) : ?>
      <ol class="carousel-indicators">
        <?php while ($childs->have_posts()) : ?>
          <?php $childs->the_post(); ?>
          <li data-target="#<?php echo $idCarousel; ?>" data-slide-to="<?php echo $i; ?>"<?php echo ($i === 0) ? ' class="active"' : ''; ?>></li>
          <?php $i++; ?>
        <?php endwhile; ?>
      </ol>
    <?php endif; ?>

    <div class="carousel-inner" role="listbox">
      <?php while ($childs->have_posts()) : ?>
        <?php $childs->the_post(); ?>
        <?php
          $values = get_post_custom(get_the_ID());
          $youtube = !empty($values['mb_youtube']) ? esc_attr($values['mb_youtube'][0]) : '';
          $classContent = !empty($youtube) ? ' carousel-content--youtube' : '';
          $classCaption = !empty($youtube) ? ' carousel-caption--youtube' : '';
        ?>

        <div class="item<?php echo ($j === 0) ? ' active' : ''; ?>">
          <article class="carousel-content<?php echo $classContent; ?>">
            <?php if (!empty($youtube)) : ?>
              <figure class="Page-youtube text-center">
                <div class="Propuesta-video" id="player<?php the_ID(); ?>"></div>

                <script>
                  var height = '720',
                      width = '1280';  // 854x480

                  if (window.innerWidth < 1600 ) {
                    height = '480';
                    width = '854';
                  }

                  if (window.innerWidth < 1199 ) {
                    height = '360';
                    width = '640';
                  }

                  if (window.innerWidth < 768) {
                    height = '240';
                    width = '426';
                  }

                  if (window.innerWidth < 450) {
                    height = '240';
                    width = '320';
                  }

                  playerInfoList.push({
                    id: '<?php echo get_the_ID(); ?>',
                    idPlayer: 'player<?php echo get_the_ID(); ?>',
                    height: height,
                    width: width,
                    videoId: '<?php echo $youtube; ?>'
                  });
                </script>
              </figure>
            <?php elseif (has_post_thumbnail()) : ?>
              <figure class="carousel-figure">
                <?php the_post_thumbnail('full', ['class' => 'img-responsive', 'alt' => get_the_title()]); ?>
              </figure>
            <?php endif; ?>
            <div class="carousel-caption<?php echo $classCaption; ?>">
              <h3><?php the_title(); ?></h3>
              <?php the_content(); ?>
            </div>
          </article>
        </div>
        <?php $j++; ?>
      <?php endwhile; ?>
    </div>
  </section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
