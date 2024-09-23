class ModernPromoSlider {
    constructor(
        swiperSelector = '.swiper',
    ) {
        this.swiperSelector = swiperSelector;
    }

    makeSlider() {
        return new Swiper(this.swiperSelector, {
            spaceBetween: 24,
            pagination: {
                el: '.modern-promo-slider__addit .swiper-pagination',
                type: 'progressbar',
            },
            navigation: {
                nextEl: '.modern-promo-slider__next',
                prevEl: '.modern-promo-slider__prev',
            },
            breakpoints: {
                1200: {
                    slidesPerView: 3,
                    centeredSlides: false,
                },
                375: {
                    slidesPerView: 1,
                    centeredSlides: true,
                }
            }
        });
    }
}