class ProductCardFavorites {
    constructor(productElement) {
        this.productElement = productElement;
        this.favoritesApi = new FavoritesApi();

        this.hangEvents();
    }

    hangEvents() {
        const productId = this.productElement.dataset.id;
        const favoritesIconDefault = this.productElement.querySelector('.product-card__fav--default');
        const favoritesIconActive = this.productElement.querySelector('.product-card__fav--active');

        favoritesIconDefault.addEventListener('click', async() => this.addFavorites(favoritesIconDefault, favoritesIconActive, productId));
        favoritesIconActive.addEventListener('click', async() => this.deleteFavorites(favoritesIconDefault, favoritesIconActive, productId));
    }

    async addFavorites(favoritesIconDefault, favoritesIconActive, productId) {
        const response = await this.favoritesApi.addToFavorites(productId);
        if (!response) {
            return;
        }
        favoritesIconDefault.style.display = 'none';
        favoritesIconActive.style.display = 'inline';
    }

    async deleteFavorites(favoritesIconDefault, favoritesIconActive, productId) {
        const response = await this.favoritesApi.deleteFromFavorites(productId);
        if (!response) {
            return;
        }
        favoritesIconActive.style.display = 'none';
        favoritesIconDefault.style.display = 'inline';
    }
}