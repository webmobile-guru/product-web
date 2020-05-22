
/*
================================================================================

  "Search" component

================================================================================
*/

const Search = (function() {
  const toggleTabs = function() {
    const currentTabElem = this;
    const tabIndex = currentTabElem.dataset.tab;
    const currentTabContentElem = document.querySelector('.search-tabs-content__section[data-tab="' + tabIndex + '"]');

    const activeTabElem = document.querySelector('.search-tabs__btn.js-active');
    const activeTabContentElem = document.querySelector('.search-tabs-content__section.js-active');

    activeTabElem.classList.remove('js-active');
    activeTabElem.removeAttribute('tabindex');

    activeTabContentElem.classList.remove('js-active');

    currentTabElem.classList.add('js-active');
    currentTabElem.setAttribute('tabindex', -1);

    currentTabContentElem.classList.add('js-active');
  };

  const showFormFields = function() {
    const formsList = document.querySelectorAll('.search-form');

    if (matchMedia('(max-width: 35.49em)').matches) {
      Array.from(formsList, (form) => {
        const hiddenContainer = form.querySelector('.search-form__container');

        hiddenContainer.classList.add('js-visible');
      });
    }
  };

  const initEventListeners = function() {
    if (document.querySelector('.search')) {
      const buttonsList = document.querySelectorAll('.search-tabs__btn');
      const fieldsList = document.querySelectorAll('.search-form .field__input[type="search"]');

      Array.from(buttonsList, (item) => {
        item.addEventListener('click', toggleTabs);
      });

      Array.from(fieldsList, (item) => {
        item.addEventListener('focus', showFormFields);
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

Search.init()
