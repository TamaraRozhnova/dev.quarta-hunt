class ProductCards {

    constructor(
        productsData,
        events = {
            onDeleteFavorites: null,
            onDeleteCompare: null
        }
    ) {
        this.productElements = document.querySelectorAll('.product-card');
        this.onDeleteFavorites = events.onDeleteFavorites;
        this.onDeleteCompare = events.onDeleteCompare;

        this.productsData = productsData;
        this.hangEvents();
    }

    hangEvents() {
        this.productElements.forEach(productElement => {
            new ProductCardFavorites(
                { productElement, favoritesList: this.productsData.FAVORITES },
                { onDelete: this.onDeleteFavorites }
            );
            new ProductCardCompare(
                { productElement, compareList: this.productsData.COMPARE },
                { onDelete: this.onDeleteCompare }
            );
            new ProductCardBasket(
                { productElement, basketList: this.productsData.BASKET }
            );
            new RatingStarsHelper(
                { productElement, ratingsList: this.productsData.RATINGS }
            );
            new ProductCardLabels(productElement)

            const tooltipContainers = productElement.querySelectorAll('.product-card__tags .info');
            tooltipContainers.forEach(container => {
                const wrapperElement = container.querySelector('span:first-child');
                const tooltipElement = container.querySelector('.tooltip');
                new Tooltip(wrapperElement, tooltipElement)
            })
        })
    }
}