
/*
================================================================================

  "Listings Areas" component

================================================================================
*/

const ListingsAreas = (function() {
  const toggleAreas = function() {
    const listingsAreasElem = document.querySelector('.listings-areas');

    if (!listingsAreasElem.classList.contains('js-expanded')) {
      listingsAreasElem.classList.add('js-expanded');
    } else {
      listingsAreasElem.classList.remove('js-expanded');
    }
  };

  const initEventListeners = function() {
    if (document.querySelector('.listings-areas')) {
      const viewToggleElem = document.querySelector('.listings-areas__view-toggle');

      viewToggleElem.addEventListener('click', toggleAreas);
    }
  };

  const init = function() {
    initEventListeners();
  };

  return {
    init: init
  };

})();

ListingsAreas.init()
