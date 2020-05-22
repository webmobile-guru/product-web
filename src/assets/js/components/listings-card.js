
/*
================================================================================

  "Listing Card" component

================================================================================
*/

const ListingsCard = (function() {
  const initEventListeners = function() {
  };

  const initSliders = function() {
    if (document.querySelector('.listings-card__photos')) {
      const slidersList = document.querySelectorAll('.listings-card__photos');

      Array.from(slidersList, (item) => {
        new Swiper(item, {
          loop: true,
          speed: 500,
          spaceBetween: 0,
          navigation: {
            prevEl: item.querySelector('.slider-nav-btn--prev'),
            nextEl: item.querySelector('.slider-nav-btn--next')
          },
          pagination: {
            el: item.querySelector('.slider-pagination'),
            type: 'bullets',
            bulletClass: 'slider-pagination__item',
            bulletActiveClass: 'slider-pagination__item--active',
            modifierClass: 'slider-pagination--'
          }
        });
      });
    }
  };

  const init = function() {
    initEventListeners();
    initSliders();
  };

  return {
    init: init
  };

})();

 ListingsCard.init()
