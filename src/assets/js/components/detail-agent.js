
/*
================================================================================

  "Detail Agent" component

================================================================================
*/

var DetailAgent = (function() {
  var openEmailPopup = function() {
    $.magnificPopup.open({
      items: {
        type: 'inline',
        src: '#email-popup'
      },
      showCloseBtn: false,
      mainClass: 'mfp-fade',
      removalDelay: 200
    });
  };

  var initEventListeners = function() {
    var emailButtons = document.querySelectorAll('.js-open-email-popup');

    Array.from(emailButtons, (item) => {
      item.addEventListener('click', openEmailPopup);
    });
  };

  var init = function() {
    initEventListeners();
  };

  return {
    init: init
  };

})();

DetailAgent.init()
