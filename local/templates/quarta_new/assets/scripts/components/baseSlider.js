class BaseSlider {
    static breakpointMobile = 576;
    static breakpointTablet = 992;

    constructor(
        swiperSelector = '.swiper',
        options = {
            [BaseSlider.breakpointTablet]: {},
            [BaseSlider.breakpointMobile]: {},
            default: {}
        }
    )
    {
        this.swiperSelector = swiperSelector;
        this.options = options;
    }

    makeSlider() {
        return new Swiper(this.swiperSelector, {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.base-slider__next',
                prevEl: '.base-slider__prev',
            },
            ...this.options.default,
            breakpoints: {
                ...this.makeBreakPoints()
            }
        });
    }

    makeBreakPoints() {
        const result = {};
        Object.keys(this.options).forEach(key => {
            if (key == BaseSlider.breakpointMobile) {
                result[key] = { slidesPerView: 2 };
            }
            if (Object.keys(this.options[key]).length && key !== 'default') {
                result[key] = { ...this.options[key] };
            }
        });
        return result;
    }
}