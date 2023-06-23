class ProductCardFavorites {
    constructor(data = {
        productElement,
        favoritesList
    }, events = {
        onDelete
    }
    ) {
        this.productElement = data.productElement;
        this.productId = this.productElement.dataset.id;
        this.favoritesList = data.favoritesList;

        this.onDelete = events.onDelete;

        /** Детальная карточка товара */
        if (document.querySelector('.product') != null) {

            this.productDetailElement = document.querySelector('.product');

            if (this.productId == this.productDetailElement.dataset.id) {

                this.productDetailElementFavoritesButton = this.productDetailElement.querySelector('.product-fav');
                this.productDetailElementFavoritesText = this.productDetailElementFavoritesButton.querySelector('.product-fav__text');

                this.productDetailElementFavoritesIconDefault = this.productDetailElementFavoritesButton.querySelector('.product-fav__default');
                this.productDetailElementFavoritesIconActive = this.productDetailElementFavoritesButton.querySelector('.product-fav__active');

            }

        }

        this.favoritesApi = new FavoritesApi();

        this.hangEvents();
        this.defineFavorites();
    }

    defineFavorites() {
        this.removePlaceholder();
        const inFavorites = this.favoritesList[this.productId];
        if (inFavorites) {
            this.changeStyles(true);
        } else {
            this.changeStyles(false);
        }
    }

    hangEvents() {
        this.productId = this.productElement.dataset.id;
        this.favoritesIconDefault = this.productElement.querySelector('.product-card__fav--default');
        this.favoritesIconActive = this.productElement.querySelector('.product-card__fav--active');

        this.favoritesIconDefault.addEventListener('click', async() => this.addFavorites());
        this.favoritesIconActive.addEventListener('click', async() => this.deleteFavorites());
    }

    async addFavorites() {
        const response = await this.favoritesApi.addToFavorites(this.productId);
        if (!response) {
            return;
        }
        this.changeStyles(true);
    }

    async deleteFavorites() {
        const response = await this.favoritesApi.deleteFromFavorites(this.productId);
        if (!response) {
            return;
        }
        if (this.onDelete) {
            this.onDelete(this.productId);
            return;
        }
        this.changeStyles(false);
    }

    changeStyles(state = true) {
        if (state) {
            this.favoritesIconDefault.style.display = 'none';
            this.favoritesIconActive.style.display = 'inline';

            /** Смена стилей для детальной страницы */
            if (document.querySelector('.product') != null != null) {

                if (this.productId == this.productDetailElement.dataset.id) { 

                    this.productDetailElementFavoritesButton.classList.add('text-secondary', 'border-secondary', 'in-fav');
                    this.productDetailElementFavoritesIconDefault.style.display = 'none';
                    this.productDetailElementFavoritesIconActive.style.display = 'inline';
                    this.productDetailElementFavoritesText.textContent = 'В избранном';

                }
            }


        } else {
            this.favoritesIconActive.style.display = 'none';
            this.favoritesIconDefault.style.display = 'inline';

            /** Смена стилей для детальной страницы */
            if (document.querySelector('.product') != null != null) {

                if (this.productId == this.productDetailElement.dataset.id) { 

                    this.productDetailElementFavoritesButton.classList.remove('text-secondary', 'border-secondary', 'in-fav');
                    this.productDetailElementFavoritesIconDefault.style.display = 'inline';
                    this.productDetailElementFavoritesIconActive.style.display = 'none';
                    this.productDetailElementFavoritesText.textContent = 'В избранное';

                }
            }

        }
    }

    removePlaceholder() {
        const placeholder = this.productElement.querySelector('.placeholder--fav');
        placeholder.remove();
    }
}