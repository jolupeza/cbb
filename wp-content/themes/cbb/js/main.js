'use strict';

var j = jQuery.noConflict();

(function ($) {
  var $win = j(window),
      $doc = j(document),
      $body = j('body'),
      sldHistory,
      $animationElements = j('.animation-element');

  function affixHeader() {
    var noAffix = false;

    if ($body.hasClass('single-post') || $body.hasClass('page-template-default') || $body.hasClass('page-template-page-applications') || $body.hasClass('tax-joblevels')) {
      noAffix = true;
    }

    if (!noAffix) {
      j('.Header').affix({
        offset: {
          top: function () {
            return 20;
          }
        }
      });
    } else {
      j('.Header').addClass('affix');
    }
  }

  function checkIfInView() {
    var windowHeight = $win.height();
    var windowTopPosition = $win.scrollTop();
    var windowBottomPosition = (windowTopPosition + windowHeight);

    j.each($animationElements, function(){
      var element = j(this);
      var animation = element.data('animation');
      var elementHeight = element.outerHeight();
      var elementTopPosition = element.offset().top;
      var elementBottomPosition = (elementTopPosition + elementHeight);

      if ((elementBottomPosition >= windowTopPosition) && (elementTopPosition <= windowBottomPosition)) {
        element.addClass(animation);
      } else {
        element.removeClass(animation);
      }
    });
  }

  function loadMap(info) {
    var mapCoord = new google.maps.LatLng(info.lat, info.long);
    var options = {
      zoom: 16,
      center: mapCoord,
      scrollwheel: false,
    };

    var icon = 'http://cbb.edu.pe/wp-content/uploads/2017/10/iconcbb.png';

    info.map = new google.maps.Map(document.getElementById(info.id), options);

    info.marker = new google.maps.Marker({
      position: mapCoord,
      map: info.map,
      title: 'Colegio Bertolt Brecht',
      icon: icon
    });

    var currentCenter = info.map.getCenter();
    google.maps.event.trigger(info.map, "resize");
    info.map.setCenter(currentCenter);
  }

  function borderRadiusTable() {
    var table = j('.Page-table');

    if (table.length) {
      table.each(function(index) {
        var $this = j(this),
            cel = $this.children('.Page-cel');

        if (cel.length % 2 == 0) {
          cel.last().prev().addClass('Page-cel--borderLeftRadius');
        } else {
          cel.last().addClass('Page-cel--borderLeftRadius');
        }
      });
    }
  }

  $win.on('scroll resize', checkIfInView);

  $win.on('scroll', function(event) {
    var arrow = j('.ArrowTop');

    if ( j(this).scrollTop() > 150) {
      arrow.fadeIn();
    } else {
      arrow.fadeOut();
    }
  });

  $win.on('resize', function() {
    if (infoMaps.length > 0) {
      infoMaps.forEach(function (info){
        if (!j.isEmptyObject(info.map)) {
          google.maps.event.trigger(info.map, "resize");
          info.map.setCenter({lat: info.lat, lng: info.long});
        }
      });
    }

    if (playerInfoList.length) {
      for (var i in players) {
        if (players[i].a.className === 'Single-video') {
          if (j(window).width() >= 768) {
            resizeVideoPlayer(players[i], '640', '360');
          }

          if (j(window).width() < 768) {
            resizeVideoPlayer(players[i], '426', '240');
          }

          if (j(window).width() < 450) {
            resizeVideoPlayer(players[i], '320', '240');
          }
        }

        if (players[i].a.className === 'Propuesta-video') {
          if (j(window).width() >= 1600) {
            resizeVideoPlayer(players[i], '1280', '720');
          }

          if (j(window).width() < 1600) {
            resizeVideoPlayer(players[i], '854', '480');
          }

          if (j(window).width() < 1199) {
            resizeVideoPlayer(players[i], '640', '360');
          }

          if (j(window).width() < 768) {
            resizeVideoPlayer(players[i], '426', '240');
          }

          if (j(window).width() < 450) {
            resizeVideoPlayer(players[i], '320', '240');
          }
        }

        if (players[i].a.className === 'Modal-video') {
          if (j(window).width() >= 992) {
            resizeVideoPlayer(players[i], '854', '480');
          }

          if (j(window).width() < 992) {
            resizeVideoPlayer(players[i], '640', '360');
          }

          if (j(window).width() < 768) {
            resizeVideoPlayer(players[i], '426', '240');
          }

          if (j(window).width() < 450) {
            resizeVideoPlayer(players[i], '320', '240');
          }
        }
      }
    }

    if (j('.Cards--history').length) {
      var bx = j('.Cards--history'),
          bxWiewport = bx.parent(),
          widthBxSlider = parseInt(bxWiewport.width()),
          slides = 0;

      if ($win.width() > 991) {
        widthBxSlider = widthBxSlider / 5;
        slides = 5;
      } else if ($win.width() > 600) {
        widthBxSlider = widthBxSlider / 2;
        slides = 2;
      } else {
        widthBxSlider = 0;
        slides = 1;
      }

      sldHistory.reloadSlider({
        auto: true,
        autoHover: true,
        minSlides: slides,
        maxSlides: slides,
        moveSlides: 1,
        slideWidth: widthBxSlider,
        pager: false,
        onSlidePrev: function($slideElement, oldIndex, newIndex) {
          sldHistory.goToSlide(newIndex);
          sldHistory.stopAuto();
          sldHistory.startAuto();
          return false;
        },
        onSlideNext: function($slideElement, oldIndex, newIndex) {
          sldHistory.goToSlide(newIndex);
          sldHistory.stopAuto();
          sldHistory.startAuto();
          return false;
        }
      });
    }
  });

  $doc.on('ready', function () {
    affixHeader();

    borderRadiusTable();

    j('.ArrowTop').on('click', function(ev){
      ev.preventDefault();
      j('html, body').animate({scrollTop: 0}, 800);
    });

    j('.js-move-scroll').on('click', function(event) {
      event.preventDefault();
      var $this = j(this);
      var dest = $this.data('href');

      dest = (typeof dest === 'undefined') ? $this.attr('href') : dest;

      dest = (dest.charAt(0) === '#') ? dest : '#' + dest;

      j('html, body').stop().animate({
        scrollTop: j(dest).offset().top
      }, 2000, 'easeInOutExpo');
    });

    j('#js-frm-contact').formValidation({
      locale: 'es_ES',
      framework: 'bootstrap',
      icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        'contact_phone': {
          validators: {
            regexp: {
              regexp: /^[0-9]+$/i,
              message: 'Ingresar sólo dígitos'
            }
          }
        }
      }
    }).on('err.field.fv', function(e, data){
      var field = e.target;
      j('small.help-block[data-bv-result="INVALID"]').addClass('hide');
    }).on('success.form.fv', function(e){
      e.preventDefault();

      var $form = j(e.target),
          fv = j(e.target).data('formValidation');

      var msg     = j('#js-form-contact-msg'),
          loader  = j('#js-form-contact-loader');

      loader.removeClass('hidden').addClass('infinite animated');
      msg.text('');

      var data = $form.serialize() + '&nonce=' + CbbAjax.nonce + '&action=register_contact';

      j.post(CbbAjax.url, data, function(data){
        $form.data('formValidation').resetForm(true);

        if (data.result) {
          msg.addClass('alert-success').text(data.msg);
        } else {
          msg.addClass('alert-danger').text(data.error);
        }

        loader.addClass('hidden').removeClass('infinite animated');
        msg.fadeIn('slow');
        setTimeout(function(){
          msg.fadeOut('slow', function(){
            j(this).text('').removeClass('alert-success alert-danger');
          });
        }, 15000);
      }, 'json').fail(function(){
        alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo.');
      });
    });

    j('select[name="contact_local"]').on('change', function () {
      var $this = j(this),
          option = $this.find(':selected').data('local');

      j('.MenuSedes-list a[href="#' + option + '"]').tab('show')
    });

    j('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var tab = j(e.target),
        id = tab.attr('aria-controls') + '-map';

      for (var i in infoMaps) {
        if (infoMaps[i].id === id) {
          setTimeout(function(){
            loadMap(infoMaps[i]);
          }, 50);

          infoMaps[i].load = true;
          return;
        }
      }
    });

    j('.js-toggle-slidebar').on('click', function(ev) {
      ev.preventDefault();
      var slidebar = j('.Slidebar');

      if (slidebar.hasClass('active')) {
        slidebar.removeClass('active');
      } else {
        slidebar.addClass('active');
      }
    });

    j('.Accordion--child').on('hide.bs.collapse', function(e) {
      j('.Accordion-button').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
    });

    j('.Accordion--child').on('shown.bs.collapse', function(e) {
      var collapse = j(e.target);

      collapse.prev().find('.Accordion-button').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
    });

    if (j('.Cards--history').length) {
      var bx = j('.Cards--history'),
          bxWiewport = bx.parent(),
          widthBxSlider = parseInt(bxWiewport.width()),
          slides = 0;

      if ($win.width() > 991) {
        widthBxSlider = widthBxSlider / 5;
        slides = 5;
      } else if ($win.width() > 600) {
        widthBxSlider = widthBxSlider / 2;
        slides = 2;
      } else {
        widthBxSlider = 0;
        slides = 1;
      }

      sldHistory = j('.Cards--history').bxSlider({
        auto: true,
        autoHover: true,
        minSlides: slides,
        maxSlides: slides,
        moveSlides: 1,
        slideWidth: widthBxSlider,
        pager: false,
        onSlidePrev: function($slideElement, oldIndex, newIndex) {
          sldHistory.goToSlide(newIndex);
          sldHistory.stopAuto();
          sldHistory.startAuto();
          return false;
        },
        onSlideNext: function($slideElement, oldIndex, newIndex) {
          sldHistory.goToSlide(newIndex);
          sldHistory.stopAuto();
          sldHistory.startAuto();
          return false;
        }
        /*onSliderLoad: function () {
          j('.bx-controls-direction a').on('click', function(){
            var i = $(this).attr('data-slide-index');
              sldHistory.goToSlide(i);
              sldHistory.stopAuto();
              sldHistory.startAuto();
              return false;
          });
        }*/
      });
    }

    j('.Modal--video').on('hidden.bs.modal', function(e) {
      if (players.length) {
        for (var i in players) {
          if (players[i].a.className === 'Modal-video') {
            stopVideoPlayer(players[i]);
          }
        }
      }

      var videos = j('video[id^="video-"]');
      if (videos.length) {
        videos.each(function(index) {
          j(this)[0].pause();
        });
      }
    });

    j('[data-toggle="tooltip"]').tooltip();

    j('#my-video').on('click', function () {
      j(this)[0].play();
    });
  });
})(jQuery);
