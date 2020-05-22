
/*
================================================================================

  "Guides" component

================================================================================
*/

const Guides = (function() {
  const initMainSlider = function() {
    if (document.querySelector('.guides__slider')) {
      const slidersList = document.querySelectorAll('.guides__slider');

      Array.from(slidersList, (item) => {
        new Swiper(item, {
          slidesPerView: 4,
          spaceBetween: 20,
          speed: 500,
          navigation: {
            prevEl: item.querySelector('.slider-nav-btn--prev'),
            nextEl: item.querySelector('.slider-nav-btn--next')
          },
          breakpoints: {
            1280: {
              slidesPerView: 3
            },
            1023: {
              allowTouchMove: true,
              slidesPerView: 2.1,
              spaceBetween: 24
            },
            767: {
              allowTouchMove: true,
              slidesPerView: 2.1,
              spaceBetween: 24
            },
            700: {
              allowTouchMove: true,
              slidesPerView: 1.1,
              spaceBetween: 20
            },
            400: {
              allowTouchMove: true,
              slidesPerView: 1.05,
              spaceBetween: 15
            }
          }
        });
      });
    }
  };

  const init = function() {
    initMainSlider();
  };

  return {
    init: init
  };

})();

Guides.init()
