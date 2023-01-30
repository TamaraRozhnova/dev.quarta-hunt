class BaseSlider {
    constructor(
        swiperSelector = '.swiper',
        swiperSlideNextSelector = '.base-slider__next',
        swiperSlidePrevSelector = '.base-slider__prev',
    ) {
        this.swiperSelector = swiperSelector;
        this.swiperSlideNextSelector = swiperSlideNextSelector;
        this.swiperSlidePrevSelector = swiperSlidePrevSelector;
    }

    makeSlider() {
        return new Swiper(this.swiperSelector, {
            slidesPerView: 2.5,
            spaceBetween: 7,
            linesCount: 2,
            multiLine: false,
            navigation: {
                nextEl: this.swiperSlideNextSelector,
                prevEl: this.swiperSlidePrevSelector,
            },
            breakpoints: {
                580: {
                    slidesPerView: 4,
                    spaceBetween: 20
                },
            }
        });
    }
}