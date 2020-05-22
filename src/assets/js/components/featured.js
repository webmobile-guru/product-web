
/*
================================================================================

  "Featured" component

================================================================================
*/

const Featured = (function() {
  const initMainSlider = function() {
    if (document.querySelector('.featured__slider')) {
      const slidersList = document.querySelectorAll('.featured__slider');

      Array.from(slidersList, (item) => {
        new Swiper(item, {
          allowTouchMove: false,
          slidesPerView: 3,
          spaceBetween: 24,
          speed: 500,
          breakpoints: {
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
            resize: function() {
              if (matchMedia('(min-width: 701px) and (max-width: 1023px)').matches) {
                this.slideTo(0, 0);
              }
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

Featured.init()