<section class="Page Page--red" id="<?php echo $post->post_name; ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h4 class="Page-title text-white">¿Por qué elegir</h4>
        <h3 class="Page-resalt text-white">Bertolt Brecht?</h3>
        <?php the_content(); ?>
      </div>
      <div class="col-md-4">
        <figure class="Page-video text-center">
          <!-- <video controls poster="<?php //echo IMAGES; ?>/video-about.jpg" > -->
          <video controls>
            <?php //if (!empty($webm)) : ?>
              <source
                src="<?php echo THEMEROOT; ?>/videos/test.webm"
                type="video/webm">
            <?php //endif; ?>

            <?php //if (!empty($mp4)) : ?>
              <source
                src="<?php echo THEMEROOT; ?>/videos/test.mp4"
                type="video/mp4">
            <?php// endif; ?>

            <?php //if (!empty($ogv)) : ?>
              <source
                src="<?php echo THEMEROOT; ?>/videos/test.ogv"
                type="video/ogg">
            <?php //endif; ?>
            Su navegador no admite etiquetas de video HTML5.
          </video>
        </figure>
      </div>
      <div class="col-md-4">
        <figure class="Page-video text-center">
          <!-- <video controls poster="<?php //echo IMAGES; ?>/video-about.jpg" > -->
          <video controls>
            <?php //if (!empty($webm)) : ?>
              <source
                src="<?php echo THEMEROOT; ?>/videos/test.webm"
                type="video/webm">
            <?php //endif; ?>

            <?php //if (!empty($mp4)) : ?>
              <source
                src="<?php echo THEMEROOT; ?>/videos/test.mp4"
                type="video/mp4">
            <?php// endif; ?>

            <?php //if (!empty($ogv)) : ?>
              <source
                src="<?php echo THEMEROOT; ?>/videos/test.ogv"
                type="video/ogg">
            <?php //endif; ?>
            Su navegador no admite etiquetas de video HTML5.
          </video>
        </figure>
      </div>
    </div>
  </div>
</section>
