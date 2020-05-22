
/*
================================================================================

  "Trending" component

================================================================================
*/

var Trending = (function () {
  var initMainSlider = function () {
    if (document.querySelector('.trending__slider')) {
      var slidersList = document.querySelectorAll('.trending__slider');

      Array.from(slidersList, (item) => {
        new Swiper(item, {
          allowTouchMove: false,
          slidesPerView: 3,
          spaceBetween: 32,
          speed: 500,
          breakpoints: {
            1279: {
              slidesPerView: 3,
              spaceBetween: 24
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
          },
          on: {
            resize: function () {
              if (matchMedia('(min-width: 701px) and (max-width: 1023px)').matches) {
                this.slideTo(0, 0);
              }
            }
          }
        });
      });
    }
  };

  var initCardSliders = function () {
    if (document.querySelector('.trending-card__photos')) {
      var slidersList = document.querySelectorAll('.trending-card__photos');

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

  var init = function () {
    initMainSlider();
    initCardSliders();
  };

  return {
    init: init
  };

})();

Trending.init()
