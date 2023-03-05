class BasketApi {
    constructor() {
        this.url = '/ajax/personal/basket.php';
        this.action = {
            ADD: 'ADD',
            SET_QUANTITY: 'SET_QUANTITY',
            DELETE: 'DELETE',
            GET_COUNT: 'GET_COUNT',
            GET_AVAILABLE_OFFERS_FOR_PURCHASING: 'GET_AVAILABLE_OFFERS_FOR_PURCHASING',
            GET_AVAILABLE_OFFERS_FOR_DELETING: 'GET_AVAILABLE_OFFERS_FOR_DELETING'
        }

        this.headerTopBasketBadge = document.querySelector('.header__top-item .basket-badge');
        this.headerBottomBasketBadge = document.querySelector('.header__bottom-item .basket-badge');
    }

    async getBasketCount() {
        const data = { action: this.action.GET_COUNT }
        return await Request.fetch(this.url, data);
    }

    async getAvailableOffersForPurchasing(productId) {
        const data = { action: this.action.GET_AVAILABLE_OFFERS_FOR_PURCHASING, id: productId}
        return await Request.fetch(this.url, data);
    }

    async getAvailableOffersForDeleting(productId) {
        const data = { action: this.action.GET_AVAILABLE_OFFERS_FOR_DELETING, id: productId}
        return await Request.fetch(this.url, data);
    }

    async addToBasket(productId, quantity = 1) {
        const data = { action: this.action.ADD, id: productId, quantity }
        const response = await Request.fetch(this.url, data);
        if (response) {
            this.displayBasketItemsCount();
        }
        return response;
    }

    async setProductQuantityToBasket(productId, quantity) {
        const data = { action: this.action.SET_QUANTITY, id: productId, quantity }
        const response = await Request.fetch(this.url, data);
        if (typeof response === 'number') {
            this.displayBasketItemsCount();
        }
        return response;
    }

    async deleteFromBasket(productId, quantity = 1) {
        const data = { action: this.action.DELETE, id: productId, quantity }
        const response = await Request.fetch(this.url, data);
        if (response) {
            this.displayBasketItemsCount();
        }
        return response;
    }

    displayBasketItemsCount() {
        this.getBasketCount()
            .then((response) => {
                if (!response) {
                    this.headerTopBasketBadge.style.display = 'none';
                    this.headerBottomBasketBadge.style.display = 'none';
                    return;
                }
                this.headerTopBasketBadge.textContent = response;
                this.headerTopBasketBadge.style.display = 'block';
                this.headerBottomBasketBadge.textContent = response;
                this.headerBottomBasketBadge.style.display = 'flex';
            })
    }

}