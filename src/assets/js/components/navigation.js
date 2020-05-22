
/*
================================================================================

  "Navigation" component

================================================================================
*/

const Navigation = (function() {
  const toggleNavigation = function() {
    const navElem = document.querySelector('.nav');

    if (!navElem.classList.contains('js-open')) {
      navElem.classList.add('js-open');
      bodyScrollLock.disableBodyScroll(navElem);
    } else {
      navElem.classList.remove('js-open');
      bodyScrollLock.enableBodyScroll(navElem);
    }
  };

  const initEventListeners = function() {
    const openNavBtnElem = document.querySelector('.header__hamburger-btn');
    const closeNavBtnElem = document.querySelector('.nav__close-btn');

    openNavBtnElem.addEventListener('click', toggleNavigation);
    closeNavBtnElem.addEventListener('click', toggleNavigation);
  };

  const init = function() {
    initEventListeners();
  };

  return {
    init: init
  };

})();

Navigation.init()
