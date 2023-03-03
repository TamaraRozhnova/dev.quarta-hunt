class ProductCards {

    constructor() {
        this.productElements = document.querySelectorAll('.product-card');
        this.hangEvents();
    }

    hangEvents() {
        this.productElements.forEach(productElement => {
            new ProductCardFavorites(productElement);
            new ProductCardCompare(productElement);
            new ProductCardBasket(productElement);

            const tooltipContainers = productElement.querySelectorAll('.product-card__tags .info');
            tooltipContainers.forEach(container => {
                const wrapperElement = container.querySelector('span:first-child');
                const tooltipElement = container.querySelector('.tooltip');
                new Tooltip(wrapperElement, tooltipElement)
            })
        })
    }
}