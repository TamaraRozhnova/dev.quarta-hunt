class SliderBrands {
    
    constructor() {
        this.sliderSelector = '.swiper-container-brands';
        this.makeSlider();
    }

    makeSlider() {
        const sliderOptions = {
            default: {
                loop: true,
                slidesPerView: 'auto',
                slidesPerGroupAuto: true,
                spaceBetween: 55,
                navigation: {
                    nextEl: '.base-slider__next',
                    prevEl: '.base-slider__prev',
                },
            },
        }
        const brandSlider = new BaseSlider(this.sliderSelector, sliderOptions);
        brandSlider.makeSlider();
    }
}