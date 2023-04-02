class RecommendedProductsSlider {
    constructor() {
        this.recommendedSliderSelector = '.swiper-container_recommended';
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
        const baseSlider = new BaseSlider(this.recommendedSliderSelector, sliderOptions);
        baseSlider.makeSlider();
    }
}