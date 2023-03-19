window.addEventListener('DOMContentLoaded', () => {
    class ProductDetail {
        constructor() {
            new ProductQuestionForm();
            new PhotosSlider();
            new Tabs();
            new DescriptionBlock();
            new RecommendedProductsSlider();
            new VideoReviewsSlider();

            new ProductFavorites();
            new ProductCompare();
            new ProductBasket();

            this.hangShareNetworkEvents();
            this.hangTooltipsEvents();
        }

        hangTooltipsEvents() {
            const tooltipContainers = document.querySelectorAll('.product-photos__tags .info');
            tooltipContainers.forEach(container => {
                const wrapperElement = container.querySelector('span:first-child');
                const tooltipElement = container.querySelector('.tooltip');
                new Tooltip(wrapperElement, tooltipElement)
            })
        }

        hangShareNetworkEvents() {
            const shareNetworkButton = document.querySelector('.product__share-toggle');
            const shareNetworkPopup = document.querySelector('.product__share-modal');
            shareNetworkButton.addEventListener('click', () => {
                shareNetworkPopup.classList.toggle('product__share-modal--show');
            });
            window.addEventListener('click', event => {
                if (!shareNetworkPopup.contains(event.target) && !shareNetworkButton.contains(event.target)) {
                    shareNetworkPopup.classList.remove('product__share-modal--show');
                }
            });
        }
    }

    new ProductDetail();
})
