<section class="Page Page--red" id="<?php echo $post->post_name; ?>">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <?php
          $title = get_the_excerpt();
          $titleArr = explode('/', $title);
        ?>
        <h4 class="Page-title text-white text-center"><?php echo $titleArr[0]; ?></h4>
        <h3 class="Page-resalt text-white text-center"><?php echo $titleArr[1]; ?></h3>
        <div class="text-center">
          <?php the_content(); ?>
        </div>
      </div>
    </div>
    <?php
      $values = get_post_custom(get_the_id());

      $poster = isset($values['mb_poster']) ? esc_attr($values['mb_poster'][0]) : '';
      $webm = isset($values['mb_webm']) ? esc_attr($values['mb_webm'][0]) : '';
      $mp4 = isset($values['mb_mp4']) ? esc_attr($values['mb_mp4'][0]) : '';
      $ogv = isset($values['mb_ogv']) ? esc_attr($values['mb_ogv'][0]) : '';
      $poster2 = isset($values['mb_poster2']) ? esc_attr($values['mb_poster2'][0]) : '';
      $webm2 = isset($values['mb_webm2']) ? esc_attr($values['mb_webm2'][0]) : '';
      $mp42 = isset($values['mb_mp42']) ? esc_attr($values['mb_mp42'][0]) : '';
      $ogv2 = isset($values['mb_ogv2']) ? esc_attr($values['mb_ogv2'][0]) : '';
      $poster3 = isset($values['mb_poster3']) ? esc_attr($values['mb_poster3'][0]) : '';
      $webm3 = isset($values['mb_webm3']) ? esc_attr($values['mb_webm3'][0]) : '';
      $mp43 = isset($values['mb_mp43']) ? esc_attr($values['mb_mp43'][0]) : '';
      $ogv3 = isset($values['mb_ogv3']) ? esc_attr($values['mb_ogv3'][0]) : '';

      $youtube = isset($values['mb_youtube']) ? esc_attr($values['mb_youtube'][0]) : '';

      $classVideos = empty($youtube) ? ' Videos--html' : '';
    ?>

    <section class="Videos<?php echo $classVideos; ?>">
      <?php if (!empty($youtube)) : ?>
          <?php
            $idsYoutube = explode(';', $youtube);
            $i = 1;
          ?>
          <?php foreach ($idsYoutube as $id) : ?>
            <script>
              playerInfoList.push({
                id: '<?php echo $i; ?>',
                idPlayer: 'player<?php echo $i; ?>',
                height: '240',
                width: '320',
                videoId: '<?php echo $id; ?>'
              });
            </script>
            <figure class="Page-video" id="player<?php echo $i; ?>"></figure>
            <?php $i++; ?>
          <?php endforeach; ?>
      <?php else : ?>
        <?php if (!empty($webm) || !empty($mp4) || !empty($ogv)) : ?>
          <figure class="Page-video Page-video--html text-center">
            <video controls<?php echo (!empty($poster)) ? 'poster="' . $poster . '"' : ''; ?>>
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
        <?php endif; ?>

        <?php if (!empty($webm2) || !empty($mp42) || !empty($ogv2)) : ?>
          <figure class="Page-video Page-video--html text-center">
            <video controls<?php echo (!empty($poster2)) ? 'poster="' . $poster2 . '"' : ''; ?>>
              <?php if (!empty($webm2)) : ?>
                <source
                  src="<?php echo $webm2; ?>"
                  type="video/webm">
              <?php endif; ?>

              <?php if (!empty($mp42)) : ?>
                <source
                  src="<?php echo $mp42; ?>"
                  type="video/mp4">
              <?php endif; ?>

              <?php if (!empty($ogv2)) : ?>
                <source
                  src="<?php echo $ogv2; ?>"
                  type="video/ogg">
              <?php endif; ?>
              Su navegador no admite etiquetas de video HTML5.
            </video>
          </figure>
        <?php endif; ?>

        <?php if (!empty($webm3) || !empty($mp43) || !empty($ogv3)) : ?>
          <figure class="Page-video Page-video--html text-center">
            <video controls<?php echo (!empty($poster3)) ? 'poster="' . $poster3 . '"' : ''; ?>>
              <?php if (!empty($webm3)) : ?>
                <source
                  src="<?php echo $webm3; ?>"
                  type="video/webm">
              <?php endif; ?>

              <?php if (!empty($mp43)) : ?>
                <source
                  src="<?php echo $mp43; ?>"
                  type="video/mp4">
              <?php endif; ?>

              <?php if (!empty($ogv3)) : ?>
                <source
                  src="<?php echo $ogv3; ?>"
                  type="video/ogg">
              <?php endif; ?>
              Su navegador no admite etiquetas de video HTML5.
            </video>
          </figure>
        <?php endif; ?>
      <?php endif; ?>
    </section>
  </div>
</section>
