'use strict';

var j = jQuery.noConflict();

(function ($) {
  var $win = j(window),
      $doc = j(document),
      $animationElements = j('.animation-element');

  function affixHeader() {
    j('.Header').affix({
      offset: {
        top: function () {
          return j('.Carousel--home').outerHeight(true) / 3;
        }
      }
    });
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

  $win.on('scroll resize', checkIfInView);

  $doc.on('ready', function () {
    affixHeader();
  });
})(jQuery);
