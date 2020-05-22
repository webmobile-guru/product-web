
/*
================================================================================

  "Verified" component

================================================================================
*/

var Verified = (function() {
  var toggleExplanation = function() {
    var verifiedElem = this;

    if (!verifiedElem.classList.contains('js-expanded')) {
      verifiedElem.classList.add('js-expanded');
    } else {
      verifiedElem.classList.remove('js-expanded');
    }
  };

  var initEventListeners = function() {
    var verifiedItemsList = document.querySelectorAll('.verified');

    Array.from(verifiedItemsList, (item) => {
      item.addEventListener('click', toggleExplanation);
    });
  };

  var init = function() {
    initEventListeners();
  };

  return {
    init: init
  };

})();

Verified.init()
