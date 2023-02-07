(function () {
    window.addEventListener('DOMContentLoaded', () => {
        if (!window.mainSliderImages) {
            return;
        }
        const mainSlider = new MainSlider('.swiper-container_main', window.mainSliderImages, window.mainSliderCompact);
        mainSlider.makeSlider();
    })
})();