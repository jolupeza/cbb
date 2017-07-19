'use strict';

var j = jQuery.noConflict();

(function ($) {
  var $win = j(window),
      $doc = j(document),
      $animationElements = j('.animation-element');

  function affixHeader() {
    var noAffix = false;

    if (j('body').hasClass('single-post')) {
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

  function loadMap(latPriv, longPriv, idPriv, contentString) {
    var mapCoord = new google.maps.LatLng(latPriv, longPriv);
    var opciones = {
      zoom: 16,
      center: mapCoord,
      scrollwheel: false,
    };

    infowindow = new google.maps.InfoWindow({
      content: contentString,
      maxWidth: 300
    });

    map = new google.maps.Map(document.getElementById(idPriv), opciones);

    marker = new google.maps.Marker({
      position: mapCoord,
      map: map,
      title: 'Colegio Bertolt Brecht'
    });

    marker.addListener('click', function() {
      infowindow.open(map, marker);
    });
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

  // $win.on('resize', function() {
  //   if (map) {
  //     var $map = j('#map');

  //     if ($map.length) {
  //       var lat = $map.data('lat'),
  //           long = $map.data('long');

  //       map.setCenter({lat: lat, lng: long});
  //     }
  //   }
  // });

  $doc.on('ready', function () {
    affixHeader();

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
          msg.text('Ya tenemos su consulta. En breve nos pondremos en contacto con usted.');
        } else {
          msg.text(data.error);
        }

        loader.addClass('hidden').removeClass('infinite animated');
        msg.fadeIn('slow');
        setTimeout(function(){
          msg.fadeOut('slow', function(){
              j(this).text('');
          });
        }, 5000);
      }, 'json').fail(function(){
        alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo.');
      });
    });

    j('#js-frm-admision').formValidation({
      locale: 'es_ES',
      framework: 'bootstrap',
      icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        'parent_dni': {
          validators: {
            regexp: {
              regexp: /^[0-9]+$/i,
              message: 'Ingresar sólo dígitos'
            }
          }
        },
        'parent_phone': {
          validators: {
            regexp: {
              regexp: /^[0-9]+$/i,
              message: 'Ingresar sólo dígitos'
            }
          }
        }
      }
    }).on('change', '[name="parent_sede"]', function (e) {
      var $this = j(this),
          local = parseInt($this.val()),
          fv = j('#js-frm-admision').data('formValidation'),
          level = parseInt(j('select[name="son_level"]').val()),
          schedule = j('select[name="schedule"]');

      if (!level) {
        fv.revalidateField('son_level');
        return;
      }

      if (local) {
        j.post(CbbAjax.url, {
          nonce: CbbAjax.nonce,
          action: 'load_schedule',
          local: local,
          level: level
        }, function(data) {
          if (data.result) {
            var options = '<option value="">-- Seleccione el horario que mejor le convenga --</option>';
            data.posts.forEach(function (item) {
              options += '<option value="' + item.ID + '">' + item.post_excerpt + '</option>';
            });

            schedule.html(options);
          } else {
            fv.revalidateField('parent_sede');
            fv.revalidateField('son_level');
          }
        }, 'json').fail(function() {
          alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo.');
        });
      }
    }).on('change', '[name="son_level"]', function (e) {
      var $this = j(this),
          level = parseInt($this.val()),
          fv = j('#js-frm-admision').data('formValidation'),
          local = parseInt(j('select[name="parent_sede"]').val()),
          schedule = j('select[name="schedule"]');

      if (!local) {
        fv.revalidateField('parent_sede');
        return;
      }

      if (level) {
        j.post(CbbAjax.url, {
          nonce: CbbAjax.nonce,
          action: 'load_schedule',
          local: local,
          level: level
        }, function(data) {
          if (data.result) {
            var options = '<option value="">-- Seleccione el horario que mejor le convenga --</option>';
            data.posts.forEach(function (item) {
              options += '<option value="' + item.ID + '">' + item.post_excerpt + '</option>';
            });

            schedule.html(options);
          } else {
            fv.revalidateField('parent_sede');
            fv.revalidateField('son_level');
          }
        }, 'json').fail(function() {
          alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo.');
        });
      }
    }).on('err.field.fv', function(e, data){
      var field = e.target;
      j('small.help-block[data-bv-result="INVALID"]').addClass('hide');
    }).on('success.form.fv', function(e){
      e.preventDefault();

      var $form = j(e.target),
          fv = j(e.target).data('formValidation');

      var msg     = j('#js-form-admision-msg'),
          loader  = j('#js-form-admision-loader');

      loader.removeClass('hidden').addClass('infinite animated');
      msg.text('');

      var data = $form.serialize() + '&nonce=' + CbbAjax.nonce + '&action=register_admision';

      j.post(CbbAjax.url, data, function(data){
        $form.data('formValidation').resetForm(true);

        if (data.result) {
          msg.text('Se registró correctamente. En breve nos estaremos poniendo en contacto con usted.');
        } else {
          msg.text(data.error);
        }

        loader.addClass('hidden').removeClass('infinite animated');
        msg.fadeIn('slow');
        setTimeout(function(){
          msg.fadeOut('slow', function(){
              j(this).text('');
          });
        }, 5000);
      }, 'json').fail(function(){
        alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo.');
      });
    });

    /*j('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
      // console.log(j(e.target));
      // console.log(e.relatedTarget);

      var tab = j(e.target),
          info = j(tab.attr('href') + ' figure.Contact-map');

      lat = parseFloat(info.data('lat'));
      long = parseFloat(info.data('long'));
      idMap = info.attr('id');

      var address = info.data('address'),
          phone = info.data('phone');

      var contentString = '<div id="content" class="Marker">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading Marker-title text-center">Colegio Bertolt Brecht</h1>'+
            '<div id="bodyContent" class="Marker-body">'+
            '<ul class="Marker-list">'+
            '<li><strong>Dirección: </strong>' + address + '</li>'+
            '<li><strong>Teléfono: </strong>' + phone + '</li>'+
            '</ul>'+
            '</div>'+
            '</div>';

      loadMap(lat, long, idMap, contentString);

      var currentCenter = map.getCenter();
      google.maps.event.trigger(map, "resize");
      map.setCenter(currentCenter);
    })*/

    // j('.grid').isotope({
    //   itemSelector: '.grid-item',
    //   percentPosition: true,
    //   mansory: {
    //     columnWidth: '.grid-sizer',
    //     gutter: 15
    //   }
    // });
  });
})(jQuery);
