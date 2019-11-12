"use strict";

;(function($) {
  $(function () {
    $('#js-frm-contact').formValidation({
      locale: 'es_ES',
      framework: 'bootstrap',
      icon: {
        valid: 'icon-check',
        invalid: 'icon-close',
        validating: 'icon-rotate'
      },
      fields: {
        'phone': {
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
      $('small.help-block[data-bv-result="INVALID"]').addClass('hide');
    }).on('success.form.fv', function(e){
      e.preventDefault();

      var $form = $(e.target),
          fv = $(e.target).data('formValidation');

      var msg     = $('#js-form-contact-msg'),
          loader  = $('#js-form-contact-loader'),
          wrapper = $('#wrapper-contact');

      loader.removeClass('d-none').addClass('infinite animated d-inline-block');
      msg.text('');

      var data = $form.serialize() + '&nonce=' + VillaMariaManagerAjax.nonce + '&action=register_contact';

      $.post(VillaMariaManagerAjax.url, data, function(data){
        $form.data('formValidation').resetForm(true);

        if (data.result) {
          if (data.content.length > 0) {
            loader.addClass('d-none').removeClass('infinite animated d-inline-block');
            wrapper.html('').html(data.content);
            return;
          }

          msg.removeClass('d-none').addClass('d-block alert-success').text(data.msg);
        } else {
          msg.removeClass('d-none').addClass('d-block alert-danger').text(data.msg);
        }

        loader.addClass('d-none').removeClass('infinite animated d-inline-block');
        msg.fadeIn('slow');

        setTimeout(function(){
          msg.fadeOut('slow', function(){
            $(this).text('').removeClass('alert-success alert-danger d-block').addClass('d-none');
          });
        }, 10000);
      }, 'json').fail(function(){
        $form.data('formValidation').resetForm(true);

        loader.addClass('d-none').removeClass('infinite animated d-inline-block');

        alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo.');
      });
    });
  });
})(jQuery);