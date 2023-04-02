window.addEventListener('DOMContentLoaded', () => {
    class Favorites {
        constructor() {
            this.productCardElements = document.querySelectorAll('.product-card');
            this.productCountElement = document.querySelector('.favorites__count');
            this.productsCount = this.productCardElements.length;
            this.productsDataApi = new ProductsDataApi();
            this.favoritesApi = new FavoritesApi();

            this.setFavoritesQuantity();
            this.hangEvents();
        }

        hangEvents() {
            this.hangCleanButtonEvents();
            this.hangProductCardsEvents();
        }

        setFavoritesQuantity() {
            if (!this.productCountElement) {
                return;
            }
            this.productCountElement.innerHTML = getPluralString(this.productsCount, ['товар', 'товара', 'товаров']);
        }

        hangCleanButtonEvents() {
            const cleanButton = document.querySelector('.favorites__clean-btn');
            if (!cleanButton) {
                return;
            }
            cleanButton.addEventListener('click', () => {
                this.favoritesApi.clearFavorites()
                    .then(response => {
                        if (response) {
                            this.showEmptyBlock();
                        }
                    })
            })
        }

        handleDeleteFavorites(productId) {
            const productCardWrapper = document.querySelector(`.favorites__item[data-id="${productId}"]`);
            productCardWrapper.remove();
            this.productsCount--;
            if (!this.productsCount) {
                this.showEmptyBlock();
            } else {
                this.setFavoritesQuantity();
            }
        }

        showEmptyBlock() {
            const emptyElement = document.querySelector('.cart__empty');
            const favoritesElement = document.querySelector('.favorites__main');
            emptyElement.style.display = 'block';
            favoritesElement.style.display = 'none';
        }

        hangProductCardsEvents() {
            const productIds = Array.from(this.productCardElements).map(element => element.dataset.id);
            if (!productIds.length) {
                return;
            }
            this.productsDataApi.getData(productIds)
                .then(response => {
                    new ProductCards(response, { onDeleteFavorites: (productId) => this.handleDeleteFavorites(productId) });
                })
        }
    }

    new Favorites();
})
