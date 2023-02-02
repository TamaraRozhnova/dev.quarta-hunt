class BaseSlider {
    static breakpointMobile = 580;

    constructor(
        swiperSelector = '.swiper',
        options = {[BaseSlider.breakpointMobile]: {}, default: {}},
    )
    {
        this.swiperSelector = swiperSelector;
        this.options = options;
    }

    makeSlider() {
        return new Swiper(this.swiperSelector, {
            slidesPerView: 1,
            spaceBetween: 20,
            linesCount: 2,
            multiLine: false,
            navigation: {
                nextEl: '.base-slider__next',
                prevEl: '.base-slider__prev',
            },
            ...this.options.default,
            breakpoints: {
                [BaseSlider.breakpointMobile]: {
                    slidesPerView: 2,
                    ...this.options[BaseSlider.breakpointMobile]
                },
            }
        });
    }
}