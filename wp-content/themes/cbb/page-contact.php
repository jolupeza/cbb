<?php
  /*
    Template Name: CBB Contáctanos
   */
?>
<?php get_header(); ?>

<?php
  $idPage = 0;
  $poster = '';
  $webm = '';
  $mp4 = '';
  $ogv = '';

  if (have_posts()) {
    while (have_posts()) {
      the_post();
      $idPage = get_the_id();

      $values = get_post_custom($idPage);
      $poster = isset($values['mb_poster']) ? esc_attr($values['mb_poster'][0]) : $poster;
      $webm = isset($values['mb_webm']) ? esc_attr($values['mb_webm'][0]) : $webm;
      $mp4 = isset($values['mb_mp4']) ? esc_attr($values['mb_mp4'][0]) : $mp4;
      $ogv = isset($values['mb_ogv']) ? esc_attr($values['mb_ogv'][0]) : $ogv;
    }
  }
?>

<?php if (!empty($webm) || !empty($mp4) || !empty($ogv)) : ?>
  <section class="Video text-center">
    <video class="img-responsive" autoplay loop="true" poster="<?php echo $poster; ?>">
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

    <?php /* if (count($dataMenuNext)) : ?>
      <a href="<?php echo $dataMenuNext['url']; ?>" class="right NavMenu">
        <?php echo $dataMenuNext['title']; ?>
        <i class="glyphicon glyphicon-chevron-right"></i>
      </a>
    <?php endif; */ ?>
  </section>
<?php else : ?>
  <?php
    $args = [
      'post_type' => 'sliders',
      'posts_per_page' => -1,
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'tax_query' => [
        [
          'taxonomy' => 'sections',
          'field' => 'slug',
          'terms' => 'contactanos'
        ]
      ]
    ];

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) :
      $i = 0;
  ?>
    <section id="carousel-infraestructura" class="carousel slide Carousel Carousel--home">
      <!-- <ol class="carousel-indicators">
        <li data-target="#carousel-infraestructura" data-slide-to="0" class="active"></li>
      </ol> -->

      <div class="carousel-inner" role="listbox">
        <?php while ($the_query->have_posts()) : ?>
          <?php $the_query->the_post(); ?>

          <?php
            $values = get_post_custom(get_the_id());
            $title = isset($values['mb_title']) ? esc_attr($values['mb_title'][0]) : '';
            $subtitle = isset($values['mb_subtitle']) ? esc_attr($values['mb_subtitle'][0]) : '';
            // $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
            // $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
            // $target = (!empty($target) && $target === 'on') ? ' target="_blank" rel="noopener noreferrer"' : '';
          ?>

          <?php if (has_post_thumbnail()) : ?>
            <div class="item<?php echo ($i === 0) ? ' active' : ''; ?>">
              <?php the_post_thumbnail('full', [
                  'class' => 'img-responsive center-block',
                  'alt' => get_the_title()
                ]);
              ?>
              <div class="carousel-caption">
                <?php if (!empty($subtitle)) : ?><h3><?php echo $subtitle; ?></h3><?php endif; ?>
                <?php if (!empty($title)) : ?><h2><?php echo $title; ?></h2><?php endif; ?>
                <?php the_content(); ?>
                <p><a class="Button Button--red" href="">conocer más</a></p>
              </div>
            </div>
          <?php endif; ?>
          <?php $i++; ?>
        <?php endwhile; ?>
      </div>

      <!-- <a class="left carousel-control" href="#carousel-infraestructura" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-infraestructura" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a> -->

      <button class="Arrow js-move-scroll" href="#contact">ir abajo <i class="glyphicon glyphicon-chevron-down"></i></button>
    </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

<section class="Page Page--contact" id="contact">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <?php if (have_posts()) : ?>
          <?php while (have_posts()) : ?>
            <?php the_post(); ?>
            <h2 class="Page-title text-celeste">Contacto</h2>
            <?php the_content(); ?>
          <?php endwhile; ?>
        <?php endif; ?>

        <p class="text-center" id="js-form-contact-msg"></p>

        <form class="Form Form--fields" action="" method="POST" id="js-frm-contact">
          <div class="form-group">
            <label for="contact_name" class="sr-only">Nombre completo</label>
            <input type="text" class="form-control" name="contact_name" placeholder="Nombre completo" autocomplete="off" required />
          </div>
          <div class="form-group">
            <label for="contact_email" class="sr-only">Correo electrónico</label>
            <input type="email" class="form-control" name="contact_email" placeholder="Correo electrónico" autocomplete="off" required />
          </div>
          <div class="form-group">
            <label for="contact_subject" class="sr-only">Asunto</label>
            <select name="contact_subject" class="form-control" data-fv-notempty-message="Debe seleccionar el asunto">
              <option value="">-- Elije el asunto o el tipo de consulta --</option>
            </select>
          </div>
          <div class="form-group">
            <label for="contact_message" class="sr-only">Mensaje</label>
            <textarea name="contact_message" rows="6" class="form-control" placeholder="Mensaje" required></textarea>
          </div>
          <p class="text-center">
            <button type="submit" class="btn Button Button--blue Button--medium">enviar <span class="Form-loader rotateIn hidden" id="js-form-contact-loader"><i class="glyphicon glyphicon-refresh"></i></span></button>
          </p>
        </form>
      </div>
      <div class="col-md-6">
        <h2 class="Page-title text-right text-celeste">Nuestras sedes</h2>
        <div class="text-right">
          <p>Conoce nuestras sedes y visítanos</p>
        </div>

        <?php
          $args = [
            'post_type' => 'locals',
            'posts_per_page' => -1,
            'post_parent' => 0,
            'orderby' => 'menu_order',
            'order' => 'ASC'
          ];

          $the_query = new WP_Query($args);

          if ($the_query->have_posts()) :
            $i = 0; $j = 0;
        ?>
          <nav class="MenuSedes">
            <ul class="MenuSedes-list nav-tabs" role="tablist">
              <?php while ($the_query->have_posts()) : ?>
                <?php $the_query->the_post(); ?>
                <?php global $post; ?>
                <li<?php echo ($i === 0) ? ' class="active"' : ''; ?> role="presentation">
                  <a href="#<?php echo $post->post_name; ?>" aria-controls="<?php echo $post->post_name; ?>" role="tab" data-toggle="tab"><?php the_title(); ?></a>
                </li>
                <?php $i++; ?>
              <?php endwhile; ?>
            </ul>
          </nav>

          <section class="tab-content">
            <?php while ($the_query->have_posts()) : ?>
              <?php $the_query->the_post(); ?>
              <?php global $post; ?>
              <?php
                $values = get_post_custom(get_the_id());
                $address = isset($values['mb_address']) ? esc_attr($values['mb_address'][0]) : '';
                $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
                $lat = isset($values['mb_lat']) ? esc_attr($values['mb_lat'][0]) : '';
                $long = isset($values['mb_long']) ? esc_attr($values['mb_long'][0]) : '';
              ?>
              <div role="tabpanel" class="tab-pane fade<?php echo ($j === 0) ? ' in active' : ''; ?>" id="<?php echo $post->post_name; ?>">
                <figure class="Contact-map"
                        id="<?php echo $post->post_name; ?>-map"
                        data-lat="<?php echo $lat; ?>"
                        data-long="<?php echo $long; ?>"
                        data-address="<?php echo $address; ?>"
                        data-phone="<?php echo $phone; ?>">
                </figure>

                <?php if (!empty($address)) : ?>
                  <h3 class="Contact-title">Dirección:</h3>
                  <p><?php echo $address; ?></p>
                <?php endif; ?>

                <?php if (!empty($phone)) : ?>
                  <h3 class="Contact-title">Central Telefónica:</h3>
                  <p><?php echo $phone; ?></p>
                <?php endif; ?>

                <script>
                  infoMaps.push({
                    id: "<?php echo $post->post_name; ?>-map",
                    lat: <?php echo $lat; ?>,
                    long: <?php echo $long; ?>,
                    address: '<?php echo $address; ?>',
                    phone: '<?php echo $phone; ?>',
                    map: {},
                    marker: {},
                    infowindow: {}
                  });
                </script>

              </div>
              <?php $j++; ?>
            <?php endwhile; ?>
          </section>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
