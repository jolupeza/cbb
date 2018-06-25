<section class="Page Page--noPaddingTop Page--pb">
  <div class="container">
    <?php if (!empty($title)) : ?>
      <h2 class="Page-title text-center text-red">
        <?php echo $title; ?>
      </h2>
    <?php endif; ?>

    <p><?php echo get_the_excerpt($idParent); ?></p>

    <figure class="Page-youtube text-center">
      <div class="Single-video" id="player<?php echo $idParent; ?>"></div>

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
          id: '<?php echo $idParent; ?>',
          idPlayer: 'player<?php echo $idParent; ?>',
          height: height,
          width: width,
          videoId: '<?php echo $youtube; ?>'
        });
      </script>
    </figure>
  </div>
</section>
