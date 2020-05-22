/*
================================================================================

  "Main Search" component

================================================================================
*/

var MainSearch = (function() {
  var toggleFiltersOptions = function() {
    var mainSearchElem = document.querySelector('.main-search');

    if (!mainSearchElem.classList.contains('js-open')) {
      mainSearchElem.classList.add('js-open');
    } else {
      mainSearchElem.classList.remove('js-open');
    }
  };

  var toggleTabs = function() {
    var currentTabElem = this;
    var tabName = currentTabElem.dataset.tab;
    var currentTabContentElem = document.querySelector(
      '.main-search-tabs-content__section[data-tab="' + tabName + '"]'
    );

    var activeTabElem = document.querySelector('.main-search-tabs__btn.js-active');
    var activeTabContentElem = document.querySelector('.main-search-tabs-content__section.js-active');

    activeTabElem.classList.remove('js-active');
    activeTabElem.removeAttribute('tabindex');

    activeTabContentElem.classList.remove('js-active');

    currentTabElem.classList.add('js-active');
    currentTabElem.setAttribute('tabindex', -1);

    currentTabContentElem.classList.add('js-active');
  };

  var initEventListeners = function() {
    if (document.querySelector('.main-search')) {
      var openFiltersBtn = document.querySelector('.main-search__filters-btn');
      var closeFiltersBtn = document.querySelector('.main-search-dropdown__close-btn');
      var clearBtn = document.querySelector('.main-search-dropdown__clear-btn');
      var tabBtnList = document.querySelectorAll('.main-search-tabs__btn');

      openFiltersBtn.addEventListener('click', toggleFiltersOptions);
      closeFiltersBtn.addEventListener('click', toggleFiltersOptions);

      //clearBtn.addEventListener('click', clearFrom);

      Array.from(tabBtnList, (item) => {
        item.addEventListener('click', toggleTabs);
      });
    }
  };

  var activeTab = function() {
    $('.btn-rent').trigger('click');
    $('.btn-buy').trigger('click');
    let pathName = window.location.href.split('?'); // Returns path only (/path/example.html)
    let type;

    if (pathName.length > 1) {
      let newUrl = pathName[1].split('&');
      type = newUrl[0].split('=')[1];
    } else {
      // url customization for footer links
      let pathFirst = pathName[0].substr(0, pathName[0].lastIndexOf('/'));
      pathFirst = pathFirst.substr(0, pathFirst.lastIndexOf('/'));
      type = pathFirst.substr(pathFirst.lastIndexOf('/') + 1, pathFirst.length - 1);
      type = type.toUpperCase();
    }

    if (type) {
      $('.' + type + '-1').trigger('click');
    }
  };

  var init = function() {
    initEventListeners();
    activeTab();
  };

  return {
    init: init
  };
})();

//export default MainSearch;
MainSearch.init();
