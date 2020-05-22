
/*
================================================================================

  "Popup" component

================================================================================
*/

var Popup = (function() {
  var initEventListeners = function() {
    var closeButtonsList = document.querySelectorAll('.js-close-popup');

    Array.from(closeButtonsList, (item) => {
      item.addEventListener('click', () => { $.magnificPopup.close()} );
    });
  };

  var init = function() {
    initEventListeners();
  };

  return {
    init: init
  };

})();
Popup.init()
