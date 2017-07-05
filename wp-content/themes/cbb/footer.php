    <?php
      $args = [
        'post_type' => 'locals',
        'posts_per_page' => -1,
        'post_parent' => 0
      ];

      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) :
    ?>
      <section class="Prefooter">
        <div class="container">
          <h2 class="Prefooter-title">Nuestras Sedes</h2>

          <div class="row">
            <?php while ($the_query->have_posts()) : ?>
              <?php $the_query->the_post(); ?>

              <?php
                $values = get_post_custom(get_the_id());
                $address = isset($values['mb_address']) ? esc_attr($values['mb_address'][0]) : '';
                $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
              ?>
              <div class="col-md-4">
                <h3 class="Prefooter-subtitle"><?php the_title(); ?></h3>
                <p class="Prefooter-text"><?php echo $address; ?></p>
                <p class="Prefooter-text">Telefono: <?php echo $phone; ?></p>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </section>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>

    <footer class="Footer">
      <div class="container">
        <?php
          if ( file_exists(TEMPLATEPATH . '/partials/partners.php')) {
            include TEMPLATEPATH . '/partials/partners.php';
          }
        ?>

        <hr class="Footer-separator">

        <div class="Footer-copy">
          <p>Copyright &copy; <?php echo date('Y') ?>. Derechos Reservados</p>
          <p>Desarrollado por <a href="http://watson.pe" target="_blank" rel="noopener noreferrer">Agencia Watson.</a></p>
        </div>
      </div>
    </footer>

    <button class="ArrowTop text-hide" title="Ir arriba"><i class="glyphicon glyphicon-chevron-up"></i></button>

    <?php $options = get_option('cbb_custom_settings'); ?>

    <?php if ($options['display_social_link'] && !is_null($options['display_social_link'])) : ?>
      <aside class="Social">
        <ul class="Social-list">
          <?php if (!empty($options['whatsapp'])) : ?>
            <li>
              <a href="" title="Ir a Whatsapp" target="_blank" rel="noopener noreferrer"><i class="icon-phone"></i></a>
            </li>
          <?php endif; ?>
          <?php if (!empty($options['facebook'])) : ?>
            <li>
              <a href="https://www.facebook.com/<?php echo $options['facebook']; ?>" title="Ir a Facebook" target="_blank" rel="noopener noreferrer"><i class="icon-facebook"></i></a>
            </li>
          <?php endif; ?>
          <?php if (!empty($options['flickr'])) : ?>
            <li>
              <a href="https://www.flickr.com/<?php echo $options['flickr']; ?>" title="Ir a Flickr" target="_blank" rel="noopener noreferrer"><i class="icon-flickr2"></i></a>
            </li>
          <?php endif; ?>
          <?php if (!empty($options['youtube'])) : ?>
            <li>
              <a href="https://www.youtube.com/<?php echo $options['youtube']; ?>" title="Ir a Youtube" target="_blank" rel="noopener noreferrer"><i class="icon-youtube"></i></a>
            </li>
          <?php endif; ?>
        </ul>
      </aside>
    <?php endif; ?>

    <script>
      _root_ = '<?php echo home_url(); ?>'
    </script>

    <?php wp_footer(); ?>
  </body>
</html>
