(function () {
    window.addEventListener('DOMContentLoaded', () => {
        const sliderOptions = {
            default: {
                slidesPerView: 2.5,
                spaceBetween: 7,
            },
            [BaseSlider.breakpointMobile]: {
                slidesPerView: 4,
                spaceBetween: 20,
            },
        }
        const baseSlider = new BaseSlider('.swiper-sections', sliderOptions);
        baseSlider.makeSlider();
    })
})()
