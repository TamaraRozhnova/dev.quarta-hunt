window.addEventListener('DOMContentLoaded', () => {
    class ProductDetail {
        constructor() {
            this.recommendedSliderSelector = '.swiper-container_recommended';

            this.makeRecommendedProductsSlider();
        }

        makeRecommendedProductsSlider() {
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
            const baseSlider = new BaseSlider(this.recommendedSliderSelector, sliderOptions);
            baseSlider.makeSlider();

            this.hangRecommendedProductCardsEvents();
        }

        hangRecommendedProductCardsEvents() {
            new ProductCards();
        }
    }

    new ProductDetail();
})
