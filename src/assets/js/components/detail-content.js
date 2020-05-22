
/*
================================================================================

  "Detail Content" component

================================================================================
*/

const DetailContent = (function() {
  const toggleTabs = function() {
    const currentTabElem = this;
    const tabIndex = currentTabElem.dataset.tab;
    const currentTabContentElem = document.querySelector('.js-detail-tab-content[data-tab="' + tabIndex + '"]');

    const activeTabElem = document.querySelector('.detail-content-tabs__btn.js-active');
    const activeTabContentElem = document.querySelector('.js-detail-tab-content.js-active');

    activeTabElem.classList.remove('js-active');
    activeTabElem.removeAttribute('tabindex');

    activeTabContentElem.classList.remove('js-active');

    currentTabElem.classList.add('js-active');
    currentTabElem.setAttribute('tabindex', -1);

    currentTabContentElem.classList.add('js-active');
  };

  const initEventListeners = function() {
    if (document.querySelector('.detail-content')) {
      const buttonsList = document.querySelectorAll('.detail-content-tabs__btn');

      Array.from(buttonsList, (item) => {
        item.addEventListener('click', toggleTabs);
      });
    }
  };

  const init = function() {
    initEventListeners();
  };

  return {
    init: init
  };

})();

DetailContent.init()