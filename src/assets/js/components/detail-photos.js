/*
================================================================================

  "Detail Photos" component

================================================================================
*/


    var mainSlider = document.querySelector('.detail-photos__main-slider');
    var thumbsSlider = document.querySelector('.detail-photos__thumbs-slider');

    if (mainSlider) {
      new Swiper(mainSlider, {
        loop: true,
        slidesPerView: 1,
        speed: 500,
        navigation: {
          prevEl: mainSlider.querySelector('.slider-nav-btn--prev'),
          nextEl: mainSlider.querySelector('.slider-nav-btn--next')
        },
        pagination: {
          el: mainSlider.querySelector('.slider-pagination'),
          type: 'bullets',
          bulletClass: 'slider-pagination__item',
          bulletActiveClass: 'slider-pagination__item--active',
          modifierClass: 'slider-pagination--'
        },
        thumbs: {
          swiper: {
            el: thumbsSlider,
            slidesPerView: 8,
            spaceBetween: 10,
            speed: 500,
            navigation: {
              prevEl: thumbsSlider.querySelector('.slider-nav-btn--prev'),
              nextEl: thumbsSlider.querySelector('.slider-nav-btn--next')
            }
          },
          slideThumbActiveClass: 'js-active'
        }
      });
    }
