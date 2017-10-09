<section class="Page">
  <div class="container">
    <?php if (has_excerpt()) : ?>
      <h2 class="Page-title text-center text-azul"><?php echo get_the_excerpt(); ?></h2>
    <?php endif; ?>

    <?php the_content(); ?>

    <figure class="Page-youtube text-center">
      <div class="Single-video" id="player<?php echo get_the_id(); ?>"></div>

      <script>
        var height = '360',
            width = '640';  // 854x480

        if (window.innerWidth < 768) {
          height = '240';
          width = '426';
        }

        if (window.innerWidth < 450) {
          height = '240';
          width = '320';
        }

        playerInfoList.push({
          id: '<?php echo get_the_id(); ?>',
          idPlayer: 'player<?php echo get_the_id(); ?>',
          height: height,
          width: width,
          videoId: '<?php echo $youtube; ?>'
        });
      </script>
    </figure>
  </div>
</section>
