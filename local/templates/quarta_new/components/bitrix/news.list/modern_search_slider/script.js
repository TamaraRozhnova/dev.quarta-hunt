(function () {
    window.addEventListener('DOMContentLoaded', () => {
        let sliderSelector = '.swiper-container_modern';

        if (window.innerWidth <= 1200) {
            sliderSelector = '.mobile .swiper-container_modern'
        }
        
        const modernPromoSlider = new ModernPromoSlider(sliderSelector);
        modernPromoSlider.makeSlider();
    })
})()