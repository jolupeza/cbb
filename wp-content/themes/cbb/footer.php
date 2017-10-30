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

          <?php
              $args = [
                'theme_location' => 'footer-menu',
                'container' => 'nav',
                'container_class' => 'Footer-menu',
                'menu_class' => 'FooterMenu',
              ];

              wp_nav_menu($args);
            ?>

          <p>Desarrollado por <a href="http://watson.pe" target="_blank" rel="noopener noreferrer">Agencia Watson.</a></p>
        </div>
      </div>
    </footer>

    <button class="ArrowTop text-hide" title="Ir arriba"><i class="glyphicon glyphicon-chevron-up"></i></button>

    <?php $options = get_option('cbb_custom_settings'); ?>

    <?php if ($options['display_social_link'] && !is_null($options['display_social_link'])) : ?>
      <aside class="Social">
        <ul class="Social-list">
          <?php if (isset($options['display_admision_link']) && $options['display_admision_link'] && !is_null($options['display_admision_link'])) : ?>
            <li class="Social-item Social-item--text">
              <a href="<?php echo home_url('admision/#formulario-admision'); ?>" title="Ir a Admisión">Admisión <span><?php echo isset($options['admision_year']) && !empty($options['admision_year']) ? $options['admision_year'] : date('Y') + 1; ?></span></a>
            </li>
          <?php endif; ?>
          <?php if (!empty($options['alexia'])) : ?>
            <li class="Social-item">
              <a href="<?php echo $options['alexia']; ?>" title="Ir a Alexia" target="_blank" rel="noopener noreferrer"><i class="icon-alexia"></i></a>
            </li>
          <?php endif; ?>
          <?php if (!empty($options['whatsapp'])) : ?>
            <li class="Social-item">
              <button type="button" data-toggle="tooltip" data-placement="top" title="<?php echo $options['whatsapp']; ?>"><i class="icon-whatsapp"></i></button>
            </li>
          <?php endif; ?>
          <?php if (!empty($options['facebook'])) : ?>
            <li class="Social-item">
              <a href="https://www.facebook.com/<?php echo $options['facebook']; ?>" title="Ir a Facebook" target="_blank" rel="noopener noreferrer"><i class="icon-facebook"></i></a>
            </li>
          <?php endif; ?>
          <?php if (!empty($options['flickr'])) : ?>
            <li class="Social-item">
              <a href="https://www.flickr.com/<?php echo $options['flickr']; ?>" title="Ir a Flickr" target="_blank" rel="noopener noreferrer"><i class="icon-flickr2"></i></a>
            </li>
          <?php endif; ?>
          <?php if (!empty($options['youtube'])) : ?>
            <li class="Social-item">
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
    <?php if (is_page('contactanos')) : ?>
      <script>
        if (infoMaps.length) {
          function initMap() {
            // infoMaps.forEach( function(info) {
              /*contentString = '<div id="content" class="Marker">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h1 id="firstHeading" class="firstHeading Marker-title text-center">Colegio Bertolt Brecht</h1>'+
                    '<div id="bodyContent" class="Marker-body">'+
                    '<ul class="Marker-list">'+
                    '<li><strong>Dirección: </strong>' + info.address + '</li>'+
                    '<li><strong>Teléfono: </strong>' + info.phone + '</li>'+
                    '</ul>'+
                    '</div>'+
                    '</div>';*/

              var mapCoord = new google.maps.LatLng(infoMaps[0].lat, infoMaps[0].long);
              var options = {
                zoom: 16,
                center: mapCoord,
                scrollwheel: false,
              };

              /*info.infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 300
              });*/

              var icon = 'http://cbb.edu.pe/wp-content/uploads/2017/10/iconcbb.png';

              infoMaps[0].map = new google.maps.Map(document.getElementById(infoMaps[0].id), options);

              infoMaps[0].marker = new google.maps.Marker({
                position: mapCoord,
                map: infoMaps[0].map,
                title: 'Colegio Bertolt Brecht',
                icon: icon
              });

              infoMaps[0].load = true;

              /*info.marker.addListener('click', function() {
                info.infowindow.open(info.map, info.marker);
              });*/

              // var currentCenter = info.map.getCenter();
              // google.maps.event.trigger(info.map, "resize");
              // info.map.setCenter(currentCenter);
            // });
          }
        }
      </script>

      <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcwEHssQPFRTJKnufst79FirJGX9NXo2o&callback=initMap"></script>
    <?php endif; ?>

    <script>
      var tag = document.createElement('script');
      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      function onYouTubeIframeAPIReady() {
        if (playerInfoList.length) {
          for (var i = 0; i < playerInfoList.length; i++) {
            players[i] = createPlayer(playerInfoList[i]);
          }
        }
      }

      function createPlayer(playerInfo) {
        return new YT.Player(playerInfo.idPlayer, {
            height: playerInfo.height,
            width: playerInfo.width,
            videoId: playerInfo.videoId,
            playerVars: {
              'rel': 0
            },
            events: {
              // 'onReady': onPlayerReady,
              'onStateChange': onPlayerStateChange
            }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      // var done = false;
      function onPlayerStateChange(event) {
        //if (event.data == YT.PlayerState.PLAYING && !done) {
          /*setTimeout(stopVideo, 6000);
          done = true;*/
        //}
        //if (event.target.a.className === 'Page-video') {
          /*if (event.data == YT.PlayerState.PLAYING) {
            if (jQuery('#carousel-programs-events').length) {
              jQuery('#carousel-programs-events').carousel('pause');
            }
          }
          if ((event.data == YT.PlayerState.ENDED) || (event.data == YT.PlayerState.PAUSED)) {
            if (jQuery('#carousel-programs-events').length) {
              jQuery('#carousel-programs-events').carousel('cycle');
            }
          }*/
        //}
      }
      function stopVideoPlayer(player) {
        player.stopVideo();
      }
      function stopVideo() {
        player.stopVideo();
      }
      function loadVideo(id) {
        player.loadVideoById(id);
      }
      function resizeVideoPlayer(player, width, height) {
        player.setSize(width, height);
      }
      function resizeVideo(width, height) {
        player.setSize(width, height);
      }
    </script>
  </body>
</html>
