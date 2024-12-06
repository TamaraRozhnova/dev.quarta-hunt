class AnalogProductsSlider {
    constructor() {
        this.analogSliderSelector = '.swiper-container_analogs';
        this.makeSlider();
    }

    makeSlider() {
        const sliderOptions = {
            default: {
                slidesPerView: 2,
                spaceBetween: 15,
            },
            [BaseSlider.breakpointMobile]: {
                slidesPerView: 4,
                spaceBetween: 20,
            }
        }
        const baseSlider = new BaseSlider(this.analogSliderSelector, sliderOptions);
        baseSlider.makeSlider();
    }
}