<section class="Page Page--red" id="<?php echo $post->post_name; ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <?php
          $title = get_the_excerpt();
          $titleArr = explode('/', $title);
        ?>
        <h4 class="Page-title text-white"><?php echo $titleArr[0]; ?></h4>
        <h3 class="Page-resalt text-white"><?php echo $titleArr[1]; ?></h3>
        <?php the_content(); ?>
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
      ?>

      <?php if (!empty($webm) || !empty($mp4) || !empty($ogv)) : ?>
        <div class="col-md-4">
          <figure class="Page-video text-center">
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
        </div>
      <?php endif; ?>

      <?php if (!empty($webm2) || !empty($mp42) || !empty($ogv2)) : ?>
        <div class="col-md-4">
          <figure class="Page-video text-center">
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
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
