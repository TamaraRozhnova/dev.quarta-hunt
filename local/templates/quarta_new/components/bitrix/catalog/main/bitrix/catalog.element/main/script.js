window.addEventListener('DOMContentLoaded', () => {
    class ProductDetail {
        constructor() {
            this.productElement = document.querySelector('.product');
            this.productId = this.productElement.dataset.id;

            new ProductQuestionForm();
            new PhotosSlider();
            new Tabs();
            new DescriptionBlock();
            new RecommendedProductsSlider();
            new VideoReviewsSlider();
            this.hangPersonalProductDataEvents();
            this.hangShareNetworkEvents();
            this.hangTooltipsEvents();
            this.hangStarsClick()
        }

        hangPersonalProductDataEvents() {
            const recommendedProductElements = document.querySelectorAll('.product-card');
            const productIds = Array.from(recommendedProductElements).map(element => element.dataset.id);
            productIds.push(this.productId);
            const productsDataApi = new ProductsDataApi();
            productsDataApi.getData(productIds)
                .then(response => {
                    const { FAVORITES, COMPARE, BASKET, RATINGS } = response;
                    new ProductFavorites(FAVORITES);
                    new ProductCompare(COMPARE);
                    new ProductBasket(BASKET);
                    new RatingStarsHelper({ productElement: this.productElement, ratingsList: RATINGS });
                    this.setReviewsCount(RATINGS);
                    new ProductCards(response);
                    new AvailableBlock(response);
                })
        }

        hangStarsClick() {
            const stars = document.querySelector('section.product .stars')
            const tabReviews = document.querySelector('.product-tab-reviews')

            if (stars) {
                stars.addEventListener('click', (e) => {
                    tabReviews.dispatchEvent(
                        new Event('click')
                    )
                    tabReviews.scrollIntoView(
                        {
                            behavior: "smooth", 
                            block: "start", 
                        }
                    )
                })
            }
        }

        setReviewsCount(ratingsList) {
            const reviewsDataForProduct = ratingsList[this.productId];
            if (reviewsDataForProduct) {
                const reviewsCount = ratingsList[this.productId].COUNT;
                const reviewsCountElements = document.querySelector('.product-about__reviews-count');
                reviewsCountElements.innerHTML = `(${reviewsCount})`;
            }
            new RatingStarsHelper({ productId: this.productId, starsSelector: '.stars--reviews-list', ratingsList }, true)
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
