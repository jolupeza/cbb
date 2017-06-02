'use strict';

var j = jQuery.noConflict();

(function ($) {
  function affixHeader() {
    j('.Header').affix({
      offset: {
        top: function () {
          return j('.Carousel--home').outerHeight(true) / 3;
        }
      }
    });
  }

  j(document).on('ready', function () {
    affixHeader();
  });
})(jQuery);
